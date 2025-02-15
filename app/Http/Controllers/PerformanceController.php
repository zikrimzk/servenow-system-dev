<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Review;
use App\Models\ReviewReply;
use Illuminate\Http\Request;

class PerformanceController extends Controller
{
    public function adminReviewUpdateStatus(Request $request, $id)
    {
        try{
            $review = Review::find($id);
            $review->review_status = $request->review_status;
            $review->save();
            return back()->with('success', 'Review status updated successfully');
        }catch(Exception $e){
            return back()->with('error', 'Opps, something went wrong. Please try again !');
        }
    }

    public function adminReplyReview(Request $request, $id)
    {
        try{
            $validated = $request->validate([
                'reply_message' => 'required',
            ],[],[
                'reply_message' => 'Reply Message',
            ]);
            $validated['review_id'] = $id;
            $validated['reply_by'] = 1;
            $validated['reply_date_time'] = date('Y-m-d H:i:s');

            ReviewReply::create($validated);
            return back()->with('success', 'Review reply sent successfully');
        }catch(Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function taskerReviewUpdateStatus(Request $request, $id)
    {
        try{
            $review = Review::find($id);
            $review->review_status = $request->review_status;
            $review->save();
            return back()->with('success', 'Review status updated successfully !');
        }catch(Exception $e){
            return back()->with('error', 'Opps, something went wrong. Please try again !');
        }
    }


    public function taskerReplyReview(Request $request, $id)
    {
        try{
            $validated = $request->validate([
                'reply_message' => 'required',
            ],[],[
                'reply_message' => 'Reply Message',
            ]);
            $validated['review_id'] = $id;
            $validated['reply_by'] = 2;
            $validated['reply_date_time'] = date('Y-m-d H:i:s');

            ReviewReply::create($validated);
            return back()->with('success', 'Review reply sent successfully !');
        }catch(Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }


}
