<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\OrderServiceInterface;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use App\Models\Notification;
use App\Services\OrderService;
use App\Services\StockNotificationService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $orderService;

    public function __construct(OrderServiceInterface $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index()
    {
        // فحص المخزون وإرسال الإشعارات
        $stockService = new StockNotificationService();
        $stockCheckResult = $stockService->checkAllProductsStock();
        
        $statistics = $this->orderService->getOrderStatistics();
        $recentOrders = $this->orderService->getRecentOrders(5);
        $salesData = $this->orderService->getSalesChartData(30);
        
        // Get sales comparison data
        $currentMonthSales = $this->getCurrentMonthSales();
        $lastMonthSales = $this->getLastMonthSales();
        $salesComparison = $this->calculateSalesComparison($currentMonthSales, $lastMonthSales);
        
        // Initialize sales data if not exists
        if (!isset($salesData['revenue'])) {
            $salesData = [
                'revenue' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                'pending' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                'delivered' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
            ];
        }
        
        // Ensure we have proper data for the chart
        $salesData = $this->orderService->getSalesChartData(30);
        
        // Get top products
        $topProducts = Product::withCount('orderItems')
            ->orderBy('order_items_count', 'desc')
            ->limit(5)
            ->get();

        // Get notifications for the dashboard
        $notifications = $stockService->getRecentNotifications(5);
        $unreadNotificationsCount = $stockService->getUnreadNotificationsCount();

        return view('admin.dashboard', compact(
            'statistics',
            'recentOrders', 
            'salesData',
            'topProducts',
            'currentMonthSales',
            'lastMonthSales',
            'salesComparison',
            'notifications',
            'unreadNotificationsCount',
            'stockCheckResult'
        ));
    }

    public function salesReport(Request $request)
    {
        $period = $request->get('period', '30');
        $salesData = $this->orderService->getSalesChartData($period);
        
        return response()->json($salesData);
    }

    public function productsReport()
    {
        $products = Product::withCount('orderItems')
            ->with(['category', 'brand'])
            ->orderBy('order_items_count', 'desc')
            ->get();

        return view('admin.reports.products', compact('products'));
    }

    public function customersReport()
    {
        $customers = User::where('role', 'customer')
            ->withCount('orders')
            ->orderBy('orders_count', 'desc')
            ->get();

        return view('admin.reports.customers', compact('customers'));
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $image = $request->file('image');
        $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        $path = $image->storeAs('uploads/images', $filename, 'public');

        return response()->json([
            'success' => true,
            'url' => asset('storage/' . $path),
            'path' => $path
        ]);
    }

    public function uploadFile(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx|max:10240'
        ]);

        $file = $request->file('file');
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('uploads/files', $filename, 'public');

        return response()->json([
            'success' => true,
            'url' => asset('storage/' . $path),
            'path' => $path
        ]);
    }
    
    public function getSalesData(Request $request)
    {
        $period = $request->get('period', 'this_month');
        
        switch ($period) {
            case 'this_month':
                $currentSales = $this->getCurrentMonthSales();
                $lastSales = $this->getLastMonthSales();
                $chartData = $this->getMonthlyChartData();
                break;
            case 'last_month':
                $currentSales = $this->getLastMonthSales();
                $lastSales = $this->getTwoMonthsAgoSales();
                $chartData = $this->getMonthlyChartData(2);
                break;
            case 'last_3_months':
                $currentSales = $this->getLast3MonthsSales();
                $lastSales = $this->getPrevious3MonthsSales();
                $chartData = $this->getQuarterlyChartData();
                break;
            case 'last_6_months':
                $currentSales = $this->getLast6MonthsSales();
                $lastSales = $this->getPrevious6MonthsSales();
                $chartData = $this->getHalfYearlyChartData();
                break;
            case 'this_year':
                $currentSales = $this->getThisYearSales();
                $lastSales = $this->getLastYearSales();
                $chartData = $this->getYearlyChartData();
                break;
            default:
                $currentSales = $this->getCurrentMonthSales();
                $lastSales = $this->getLastMonthSales();
                $chartData = $this->getMonthlyChartData();
        }
        
        $comparison = $this->calculateSalesComparison($currentSales, $lastSales);
        
        return response()->json([
            'current_sales' => $currentSales,
            'last_sales' => $lastSales,
            'comparison' => $comparison,
            'chart_data' => $chartData
        ]);
    }

    /**
     * الحصول على الإشعارات
     */
    public function getNotifications(Request $request)
    {
        $stockService = new StockNotificationService();
        $notifications = $stockService->getRecentNotifications($request->get('limit', 10));
        $unreadCount = $stockService->getUnreadNotificationsCount();

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unreadCount
        ]);
    }

    /**
     * تحديد إشعار كمقروء
     */
    public function markNotificationAsRead(Request $request, $id)
    {
        $notification = Notification::findOrFail($id);
        $notification->markAsRead();

        return response()->json([
            'success' => true,
            'message' => 'تم تحديد الإشعار كمقروء'
        ]);
    }

    /**
     * تحديد جميع الإشعارات كمقروءة
     */
    public function markAllNotificationsAsRead(Request $request)
    {
        Notification::unread()->update([
            'is_read' => true,
            'read_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم تحديد جميع الإشعارات كمقروءة'
        ]);
    }

    /**
     * حذف إشعار
     */
    public function deleteNotification(Request $request, $id)
    {
        $notification = Notification::findOrFail($id);
        $notification->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم حذف الإشعار'
        ]);
    }

    /**
     * صفحة عرض جميع الإشعارات
     */
    public function notifications()
    {
        $notifications = Notification::orderBy('created_at', 'desc')->paginate(20);
        $unreadCount = Notification::unread()->count();

        return view('admin.notifications.index', compact('notifications', 'unreadCount'));
    }

    /**
     * جلب الإشعارات للهيدر
     */
    public function getHeaderNotifications()
    {
        $notifications = Notification::orderBy('created_at', 'desc')->limit(5)->get();
        $unreadCount = Notification::unread()->count();

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unreadCount
        ]);
    }
    
    private function getCurrentMonthSales()
    {
        // Get the last month with data (December 2024)
        return Order::where('status', 'delivered')
            ->whereYear('created_at', 2024)
            ->whereMonth('created_at', 12)
            ->sum('total_amount') ?: 0;
    }
    
    private function getLastMonthSales()
    {
        // Get the previous month with data (November 2024)
        return Order::where('status', 'delivered')
            ->whereYear('created_at', 2024)
            ->whereMonth('created_at', 11)
            ->sum('total_amount') ?: 0;
    }
    
    private function getTwoMonthsAgoSales()
    {
        return Order::where('status', 'delivered')
            ->whereYear('created_at', now()->subMonths(2)->year)
            ->whereMonth('created_at', now()->subMonths(2)->month)
            ->sum('total_amount');
    }
    
    private function getLast3MonthsSales()
    {
        return Order::where('status', 'delivered')
            ->where('created_at', '>=', now()->subMonths(3))
            ->sum('total_amount');
    }
    
    private function getPrevious3MonthsSales()
    {
        return Order::where('status', 'delivered')
            ->whereBetween('created_at', [now()->subMonths(6), now()->subMonths(3)])
            ->sum('total_amount');
    }
    
    private function getLast6MonthsSales()
    {
        return Order::where('status', 'delivered')
            ->where('created_at', '>=', now()->subMonths(6))
            ->sum('total_amount');
    }
    
    private function getPrevious6MonthsSales()
    {
        return Order::where('status', 'delivered')
            ->whereBetween('created_at', [now()->subMonths(12), now()->subMonths(6)])
            ->sum('total_amount');
    }
    
    private function getThisYearSales()
    {
        return Order::where('status', 'delivered')
            ->whereYear('created_at', now()->year)
            ->sum('total_amount');
    }
    
    private function getLastYearSales()
    {
        return Order::where('status', 'delivered')
            ->whereYear('created_at', now()->subYear()->year)
            ->sum('total_amount');
    }
    
    private function calculateSalesComparison($current, $last)
    {
        if ($last == 0) {
            return $current > 0 ? 100 : 0;
        }
        
        return round((($current - $last) / $last) * 100, 2);
    }
    
    private function getMonthlyChartData($monthsBack = 1)
    {
        $data = [];
        $categories = [];
        
        for ($i = $monthsBack; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $categories[] = $month->format('M Y');
            
            $data['revenue'][] = Order::where('status', 'delivered')
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('total_amount') / 1000;
                
            $data['pending'][] = Order::where('status', 'pending')
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('total_amount') / 1000;
                
            $data['delivered'][] = Order::where('status', 'delivered')
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('total_amount') / 1000;
        }
        
        $data['categories'] = $categories;
        return $data;
    }
    
    private function getQuarterlyChartData()
    {
        $data = [];
        $categories = [];
        
        for ($i = 2; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $categories[] = $month->format('M Y');
            
            $data['revenue'][] = Order::where('status', 'delivered')
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('total_amount') / 1000;
                
            $data['pending'][] = Order::where('status', 'pending')
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('total_amount') / 1000;
                
            $data['delivered'][] = Order::where('status', 'delivered')
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('total_amount') / 1000;
        }
        
        $data['categories'] = $categories;
        return $data;
    }
    
    private function getHalfYearlyChartData()
    {
        $data = [];
        $categories = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $categories[] = $month->format('M Y');
            
            $data['revenue'][] = Order::where('status', 'delivered')
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('total_amount') / 1000;
                
            $data['pending'][] = Order::where('status', 'pending')
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('total_amount') / 1000;
                
            $data['delivered'][] = Order::where('status', 'delivered')
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('total_amount') / 1000;
        }
        
        $data['categories'] = $categories;
        return $data;
    }
    
    private function getYearlyChartData()
    {
        $data = [];
        $categories = [];
        
        for ($i = 11; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $categories[] = $month->format('M Y');
            
            $data['revenue'][] = Order::where('status', 'delivered')
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('total_amount') / 1000;
                
            $data['pending'][] = Order::where('status', 'pending')
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('total_amount') / 1000;
                
            $data['delivered'][] = Order::where('status', 'delivered')
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('total_amount') / 1000;
        }
        
        $data['categories'] = $categories;
        return $data;
    }
}
