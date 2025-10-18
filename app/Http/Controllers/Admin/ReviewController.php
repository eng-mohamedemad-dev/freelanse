<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::with(['user', 'product']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by rating
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('comment', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($userQuery) use ($request) {
                      $userQuery->where('name', 'like', '%' . $request->search . '%')
                                ->orWhere('email', 'like', '%' . $request->search . '%');
                  })
                  ->orWhereHas('product', function($productQuery) use ($request) {
                      $productQuery->where('name_ar', 'like', '%' . $request->search . '%')
                                   ->orWhere('name_en', 'like', '%' . $request->search . '%');
                  });
            });
        }

        $reviews = $query->orderBy('created_at', 'desc')->paginate(15);

        // If AJAX request, return only table content
        if ($request->ajax() || $request->has('ajax')) {
            return response()->json([
                'html' => view('admin.reviews.partials.table', compact('reviews'))->render(),
                'paginationHtml' => $reviews->appends(request()->query())->links()->render(),
                'count' => $reviews->count()
            ]);
        }

        return view('admin.reviews.index', compact('reviews'));
    }

    public function show(Review $review)
    {
        $review->load(['user', 'product']);
        
        return view('admin.reviews.show', compact('review'));
    }

    public function updateStatus(Request $request, Review $review)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected'
        ]);

        $review->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => __('admin.review_status_updated_successfully')
        ]);
    }

    public function approve(Review $review)
    {
        $review->update(['status' => 'approved']);

        return response()->json([
            'success' => true,
            'message' => __('admin.review_approved_successfully')
        ]);
    }

    public function reject(Review $review)
    {
        $review->update(['status' => 'rejected']);

        return response()->json([
            'success' => true,
            'message' => __('admin.review_rejected_successfully')
        ]);
    }

    public function destroy(Review $review)
    {
        try {
            $review->delete();

            return response()->json([
                'success' => true,
                'message' => __('admin.review_deleted_successfully')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('admin.error')
            ], 500);
        }
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:approve,reject,delete',
            'review_ids' => 'required|array',
            'review_ids.*' => 'exists:reviews,id'
        ]);

        $reviewIds = $request->review_ids;
        $action = $request->action;

        try {
            switch ($action) {
                case 'approve':
                    Review::whereIn('id', $reviewIds)->update(['status' => 'approved']);
                    $message = __('admin.reviews_approved_successfully');
                    break;
                case 'reject':
                    Review::whereIn('id', $reviewIds)->update(['status' => 'rejected']);
                    $message = __('admin.reviews_rejected_successfully');
                    break;
                case 'delete':
                    Review::whereIn('id', $reviewIds)->delete();
                    $message = __('admin.reviews_deleted_successfully');
                    break;
            }

            return response()->json([
                'success' => true,
                'message' => $message
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('admin.error')
            ], 500);
        }
    }
}
