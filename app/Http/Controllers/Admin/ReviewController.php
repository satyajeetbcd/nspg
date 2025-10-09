<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.reviews.index', compact('reviews'));
    }

    public function create()
    {
        return view('admin.reviews.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_location' => 'nullable|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'review_text' => 'required|string|max:1000',
            'service_type' => 'nullable|string|max:100',
            'project_name' => 'nullable|string|max:255',
            'project_location' => 'nullable|string|max:255',
            'is_featured' => 'boolean',
            'is_verified' => 'boolean',
            'is_active' => 'boolean',
            'review_source' => 'nullable|string|max:50'
        ]);

        $data = $request->all();
        $data['is_featured'] = $request->has('is_featured');
        $data['is_verified'] = $request->has('is_verified');
        $data['is_active'] = $request->has('is_active');

        Review::create($data);

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review created successfully.');
    }

    public function show(Review $review)
    {
        return view('admin.reviews.show', compact('review'));
    }

    public function edit(Review $review)
    {
        return view('admin.reviews.edit', compact('review'));
    }

    public function update(Request $request, Review $review)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_location' => 'nullable|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'review_text' => 'required|string|max:1000',
            'service_type' => 'nullable|string|max:100',
            'project_name' => 'nullable|string|max:255',
            'project_location' => 'nullable|string|max:255',
            'is_featured' => 'boolean',
            'is_verified' => 'boolean',
            'is_active' => 'boolean',
            'review_source' => 'nullable|string|max:50'
        ]);

        $data = $request->all();
        $data['is_featured'] = $request->has('is_featured');
        $data['is_verified'] = $request->has('is_verified');
        $data['is_active'] = $request->has('is_active');

        $review->update($data);

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review updated successfully.');
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review deleted successfully.');
    }

    public function toggleStatus(Review $review)
    {
        $review->update(['is_active' => !$review->is_active]);
        
        return response()->json([
            'success' => true,
            'is_active' => $review->is_active,
            'message' => 'Review status updated successfully.'
        ]);
    }

    public function toggleFeatured(Review $review)
    {
        $review->update(['is_featured' => !$review->is_featured]);
        
        return response()->json([
            'success' => true,
            'is_featured' => $review->is_featured,
            'message' => 'Review featured status updated successfully.'
        ]);
    }

    public function toggleVerified(Review $review)
    {
        $review->update(['is_verified' => !$review->is_verified]);
        
        return response()->json([
            'success' => true,
            'is_verified' => $review->is_verified,
            'message' => 'Review verification status updated successfully.'
        ]);
    }
}
