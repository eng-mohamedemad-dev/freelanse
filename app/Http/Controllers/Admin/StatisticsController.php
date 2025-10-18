<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function index(Request $request)
    {
        // Default: show products list
        $products = $this->getTopProducts($request);
        return view('admin.statistics.index', compact('products'));
    }

    public function products(Request $request)
    {
        $products = $this->getTopProducts($request);
        
        // Prepare chart data
        $chartData = $this->prepareChartData($products, 'products');
        
        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.statistics.partials.products_table', compact('products'))->render(),
                'chartData' => $chartData
            ]);
        }
        return view('admin.statistics.index', compact('products'));
    }

    public function users(Request $request)
    {
        $query = OrderItem::select('orders.user_id', DB::raw('COUNT(order_items.product_id) as purchases'))
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->groupBy('orders.user_id')
            ->orderByDesc('purchases');

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->join('users', 'users.id', '=', 'orders.user_id')
                  ->where(function($q) use ($search) {
                      $q->where('users.name', 'like', "%$search%")
                        ->orWhere('users.email', 'like', "%$search%");
                  });
        }

        $users = $query->paginate(10)->withQueryString();

        // Attach top product for each user
        $userIds = $users->pluck('user_id')->all();
        $topByUser = OrderItem::select('orders.user_id','order_items.product_id', DB::raw('COUNT(*) as cnt'))
            ->join('orders','orders.id','=','order_items.order_id')
            ->whereIn('orders.user_id', $userIds)
            ->groupBy('orders.user_id','order_items.product_id')
            ->orderByDesc('cnt')
            ->get()
            ->groupBy('user_id');

        $productsMap = Product::whereIn('id', $topByUser->flatten()->pluck('product_id')->unique())->get()->keyBy('id');
        foreach ($users as $u) {
            $top = optional($topByUser->get($u->user_id))->first();
            $u->top_product = $top ? $productsMap->get($top->product_id) : null;
        }

        // Prepare chart data
        $chartData = $this->prepareChartData($users, 'users');

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.statistics.partials.users_table', compact('users'))->render(),
                'chartData' => $chartData
            ]);
        }

        $products = collect();
        return view('admin.statistics.index', compact('products','users'));
    }

    private function getTopProducts(Request $request)
    {
        $query = OrderItem::select('order_items.product_id', DB::raw('SUM(order_items.quantity) as qty'))
            ->groupBy('order_items.product_id')
            ->orderByDesc('qty');

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->join('products','products.id','=','order_items.product_id')
                  ->where(function($q) use ($search){
                      $q->where('products.name_ar','like', "%$search%")
                        ->orWhere('products.name_en','like', "%$search%");
                  });
        }

        $productsAgg = $query->paginate(10)->withQueryString();
        $productIds = $productsAgg->pluck('product_id')->all();
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        // attach product model
        foreach ($productsAgg as $row) {
            $row->product = $products->get($row->product_id);
        }
        return $productsAgg;
    }

    private function prepareChartData($data, $type)
    {
        $labels = [];
        $values = [];
        $title = '';

        if ($type === 'products') {
            foreach ($data as $row) {
                $productName = optional($row->product)->name_ar ?? optional($row->product)->name_en ?? ('#' . $row->product_id);
                $labels[] = $productName;
                $values[] = (int) $row->qty;
            }
            $title = __('admin.total_sold');
        } else {
            foreach ($data as $u) {
                $userName = optional(User::find($u->user_id))->name ?? ('#' . $u->user_id);
                $labels[] = $userName;
                $values[] = (int) $u->purchases;
            }
            $title = __('admin.purchases');
        }

        // Ensure we have data and limit to top 10 for chart
        if (empty($labels) || empty($values)) {
            return [
                'labels' => ['لا توجد بيانات'],
                'values' => [0],
                'title' => $title
            ];
        }

        // Limit to top 10 for chart display
        $chartLabels = array_slice($labels, 0, 10);
        $chartValues = array_slice($values, 0, 10);

        return [
            'labels' => $chartLabels,
            'values' => $chartValues,
            'title' => $title
        ];
    }
}
