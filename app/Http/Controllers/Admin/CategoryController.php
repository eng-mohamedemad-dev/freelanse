<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::with('parent');
        
        // Search functionality
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }
        
        $categories = $query->paginate(10);
        
        // If AJAX request, return JSON response
        if ($request->ajax() || $request->has('ajax')) {
            return response()->json([
                'html' => view('admin.categories.partials.table', compact('categories'))->render(),
                'count' => $categories->count()
            ]);
        }
        
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $categories = Category::active()->root()->get();
        
        return view('admin.categories.create', compact('categories'));
    }

    public function store(StoreCategoryRequest $request)
    {

        $data = $request->all();
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $filename = time() . '_' . uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $uploadPath = public_path('uploads/categories');
            
            // Create directory if it doesn't exist
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            // Move the file
            $request->file('image')->move($uploadPath, $filename);
            $data['image'] = 'uploads/categories/' . $filename;
        }
        
        // Set status as active by default
        $data['status'] = 'active';

        Category::create($data);

        return redirect()->route('admin.categories.index')
            ->with('success', __('admin.category_created_successfully'));
    }

    public function show(Category $category)
    {
        return view('admin.categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        $categories = Category::active()->root()->where('id', '!=', $category->id)->get();
        
        return view('admin.categories.edit', compact('category', 'categories'));
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {

        $data = $request->all();
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $filename = time() . '_' . uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $uploadPath = public_path('uploads/categories');
            
            // Create directory if it doesn't exist
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            // Move the file
            $request->file('image')->move($uploadPath, $filename);
            $data['image'] = 'uploads/categories/' . $filename;
        }
        
        // Handle removal of current image
        if ($request->has('remove_current_image')) {
            if ($category->image && file_exists(public_path($category->image))) {
                unlink(public_path($category->image));
            }
            $data['image'] = null;
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')
            ->with('success', __('admin.category_updated_successfully'));
    }

    public function destroy(Category $category)
    {
        // Delete associated image
        if ($category->image && file_exists(public_path($category->image))) {
            unlink(public_path($category->image));
        }
        
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', __('admin.category_deleted_successfully'));
    }

    public function toggleStatus(Category $category)
    {
        $category->update([
            'status' => $category->status === 'active' ? 'inactive' : 'active'
        ]);

        return response()->json([
            'success' => true,
            'message' => __('admin.category_status_updated_successfully')
        ]);
    }
}