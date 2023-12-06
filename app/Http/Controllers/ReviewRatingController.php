<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReviewRatingController extends Controller
{
    public function reviewbuku(Request $request){
        // Validate the incoming request data
        $request->validate([
            'buku_id' => 'required', // Add any other validation rules you need
            'rating' => 'required|numeric|min:1|max:5', // Adjust the validation rules for the rating field
        ]);
    
        // Create a new ReviewRating instance
        $review = new ReviewRating();
    
        // Assign values from the request to the ReviewRating instance
        $review->buku_id = $request->buku_id;
        $review->star_rating = $request->rating;
    
        // Save the review to the database
        $review->save();
    
        // Redirect back with a success message
        return redirect()->back()->with('flash_msg_success', 'Your review has been submitted successfully.');
    }
    
}
