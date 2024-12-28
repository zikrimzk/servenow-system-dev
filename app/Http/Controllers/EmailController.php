<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\TaskerPerformanceReport;
use Carbon\Carbon;

class EmailController extends Controller
{
    public function adminSendPerformanceReport(Request $request)
    {
        $taskerIds = $request->input('selected_taskers'); 
        
        if (!empty($taskerIds)) {
            $taskers = DB::table('taskers')
                ->whereIn('taskers.id', $taskerIds)
                ->leftJoin('services', 'taskers.id', '=', 'services.tasker_id')
                ->leftJoin('bookings', 'services.id', '=', 'bookings.service_id')
                ->leftJoin('reviews', 'bookings.id', '=', 'reviews.booking_id')
                ->leftJoin('cancel_refund_bookings', 'bookings.id', '=', 'cancel_refund_bookings.booking_id')
                ->select(
                    'taskers.tasker_code',
                    'taskers.email',
                    DB::raw("CONCAT(taskers.tasker_firstname, ' ', taskers.tasker_lastname) AS name"),
                    DB::raw("AVG(reviews.review_rating) AS average_rating"),
                    DB::raw("
                    CASE 
                        WHEN AVG(reviews.review_rating) >= 4 THEN 'Happy'
                        WHEN AVG(reviews.review_rating) >= 3 THEN 'Neutral'
                        ELSE 'Unhappy'
                    END AS satisfaction_reaction
                "),
                    DB::raw("COUNT(CASE WHEN cancel_refund_bookings.cr_penalized = '1' THEN 1 END) AS total_self_cancel_refunds"),
                    DB::raw("COUNT(CASE WHEN bookings.booking_status = '6' THEN 1 END) AS total_completed_bookings"),
                    DB::raw("
                    ROUND(
                        (
                            (AVG(reviews.review_rating) / 5 * 60) -- Ratings contribute 60%
                            + (CASE WHEN AVG(reviews.review_rating) >= 4 THEN 15 ELSE 0 END) -- Satisfaction bonus (15%)
                            - LEAST(taskers.tasker_selfrefund_count * 2.5, 25) -- Refund penalty capped at 25%
                        ), 2
                    ) AS performance_score
                ")
                )
                ->groupBy('taskers.id')
                ->get();

            foreach ($taskers as $tasker) {
                // Send email
                Mail::to($tasker->email)->send(new TaskerPerformanceReport([
                    'name' => $tasker->name,
                    'average_rating' => round($tasker->average_rating, 2),
                    'satisfaction_reaction' => $tasker->satisfaction_reaction,
                    'total_self_cancel_refunds' => $tasker->total_self_cancel_refunds,
                    'total_completed_bookings' => $tasker->total_completed_bookings,
                    'performance_score' => $tasker->performance_score,
                    'date'=> Carbon::now()->format('d F Y g:i A'),
                ]));
            }
        }

        return response()->json(['success' => 'Emails sent successfully.', 'taskers' => $taskerIds]);
    }
}
