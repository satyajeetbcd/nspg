<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of reviews.
     */
    public function index()
    {
        $reviews = Review::active()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Calculate review statistics using the model's static methods
        $stats = [
            'total_reviews' => Review::getTotalReviews(),
            'average_rating' => Review::getAverageRating() ? round(Review::getAverageRating(), 1) : 0,
            'rating_counts' => Review::getRatingCounts()
        ];

        return view('frontend.reviews.index', compact('reviews', 'stats'));
    }

    /**
     * Store a newly created review.
     */
    public function store(Request $request)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|max:1000',
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'service_type' => 'nullable|string|max:255',
        ]);

        Review::create([
            'name' => $request->name,
            'location' => $request->location,
            'rating' => $request->rating,
            'review' => $request->review,
            'service_type' => $request->service_type,
            'is_active' => false, // Reviews need to be approved
            'is_featured' => false,
            'is_verified' => false,
        ]);

        return redirect()->back()->with('success', 'Review submitted successfully! It will be published after approval.');
    }

    /**
     * Get reviews via API.
     */
    public function getReviews(Request $request)
    {
        $reviews = Review::active()
            ->orderBy('created_at', 'desc')
            ->limit($request->get('limit', 10))
            ->get();

        // Include stats if requested
        if ($request->get('include_stats', false)) {
            $stats = [
                'total_reviews' => Review::getTotalReviews(),
                'average_rating' => Review::getAverageRating() ? round(Review::getAverageRating(), 1) : 0,
                'rating_counts' => Review::getRatingCounts()
            ];

            return response()->json([
                'reviews' => $reviews,
                'stats' => $stats
            ]);
        }

        return response()->json($reviews);
    }
}
