<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::all();
        return response([
            "reviews" => $reviews,
        ], 200);
    }

    public function show($id)
    {
        $review = Review::find($id);
        if (!$review) {
            return response([
                "message" => "Review not found"
            ], 404);
        }
        return response([
            "review" => $review,
        ], 200);
    }

    public function store(Request $request)
    {
        $fields = $request->validate([
            "UserID" => "required|exists:users,id",
            "ServiceID" => "required|exists:services,ServiceID",
            "Rating" => "required|integer|min:1|max:5",
            "Comment" => "string|nullable",
        ]);

        $review = Review::create($fields);

        return response([
            "review" => $review,
        ], 201);
    }
    public function update(Request $request, $id)
    {
        $review = Review::findOrFail($id);

        $fields = $request->validate([
            "UserID" => "exists:users,id",
            "ServiceID" => "exists:services,ServiceID",
            "Rating" => "integer|min:1|max:5",
            "Comment" => "string|nullable",
        ]);

        $review->update($fields);

        return response([
            "review" => $review,
        ], 200);
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return response([
            "message" => "Review deleted",
        ], 200);
    }
}