<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskerAPIController;
use App\Http\Controllers\AuthenticateController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::get('/testapi',function(){
    return response([
        'message' => 'Api is working'
    ],200 );
});

Route::middleware('auth:sanctum')->get('/testapi-token',function(){
    return response([
        'message' => 'Api is working'
    ],200 );
});


// Get State & Area 
Route::get('/get-state', [TaskerAPIController::class, 'getStateAPI']);
Route::get('/get-area-{state}', [TaskerAPIController::class, 'getAreasAPI']);

// Tasker - Auth Process
Route::post('/authenticate-tasker', [AuthenticateController::class, 'authenticateTaskerApi']);

// Tasker - Fetch Tasker Details
Route::middleware('auth:sanctum')->get('/get-tasker-details', [TaskerAPIController::class, 'getTaskerDetail']);

// Tasker - Profile Management API
Route::middleware('auth:sanctum')->post('/update-password-{id}', [TaskerAPIController::class, 'taskerUpdatePasswordAPI']);
Route::middleware('auth:sanctum')->post('/update-profile-{id}', [TaskerAPIController::class, 'taskerUpdateProfileAPI']);

// Tasker - Service Type Fetch
Route::middleware('auth:sanctum')->get('/get-service-type', [TaskerAPIController::class, 'getAllServiceType']);

// Tasker - Service Management API
Route::middleware('auth:sanctum')->post('/create-service', [TaskerAPIController::class, 'createServiceAPI']);
Route::middleware('auth:sanctum')->get('/get-service-list', [TaskerAPIController::class, 'getAllServiceAPI']);
Route::middleware('auth:sanctum')->get('/get-service-{id}', [TaskerAPIController::class, 'getSingleServiceAPI']);
Route::middleware('auth:sanctum')->post('/update-service-{id}', [TaskerAPIController::class, 'updateServiceAPI']);
Route::middleware('auth:sanctum')->get('/delete-service-{id}', [TaskerAPIController::class, 'deleteServiceAPI']);

// Tasker - Visibility & Location API
Route::middleware('auth:sanctum')->post('/update-tasker-location', [TaskerAPIController::class, 'taskerUpdateLocationAPI']);
/* 
NOTE: URL /update-tasker-location akan Post details :
ex http://127.0.0.1:8000/api/update-tasker-location?tasker_workingloc_state=melaka&tasker_workingloc_area=Melaka Tengah&working_radius=20
*/

Route::middleware('auth:sanctum')->get('/change-tasker-visibility', [TaskerAPIController::class, 'taskerVisibleToggleAPI']);

// Tasker - Time Slot Setting API
Route::middleware('auth:sanctum')->post('/tasker-working-type-change', [TaskerAPIController::class, 'taskerTypeToggleAPI']);
Route::middleware('auth:sanctum')->get('/create-time-slot-{date}', [TaskerAPIController::class, 'taskerCreateTimeSlotAPI'])->name('taskerTimeSlotCreateAPI');
Route::middleware('auth:sanctum')->get('/get-tasker-time-slot-{date}', [TaskerAPIController::class, 'getTaskerTimeSlotAPI'])->name('getTaskerTimeSlot');
Route::middleware('auth:sanctum')->post('/update-time-slot-{id}', [TaskerAPIController::class, 'taskerUpdateTimeSlotAPI'])->name('tasker-timeslot-update');
/* 
NOTE: URL /update-time-slot-{id} akan Post details :

/update-time-slot-{id}?slot_status=1/2
ex http://127.0.0.1:8000/api/update-time-slot-37?slot_status=0

id - ID Slot
slot_status - 1 - Available | 0 - Unavailable 

*/

// Tasker - Booking Management API
Route::middleware('auth:sanctum')->get('/get-bookings-details', [TaskerAPIController::class, 'getBookingsDetailsAPI']);
Route::middleware('auth:sanctum')->get('/get-unavailable-time', [TaskerAPIController::class, 'getTaskerUnavailableSlotAPI']);
Route::middleware('auth:sanctum')->post('/booking-reschedule', [TaskerAPIController::class, 'rescheduleBookingTimeFunctionAPI']);

/* 
NOTE: URL /booking-reschedule akan Post details :

/booking-reschedule?id=?&date=?&start=?&end=?
ex http://127.0.0.1:8000/api/booking-reschedule?id=4&date=2024-12-16&start=17:00:00&end=18:00:00

id - ID BOOKING
date - date reschedule yang baru
start - start time baru
end- end time baru

*/

Route::middleware('auth:sanctum')->post('/change-booking-status', [TaskerAPIController::class, 'taskerChangeBookingStatusAPI']);
/* 
NOTE: URL /change-booking-status akan Post details :

/change-booking-status?id=?&option=?
ex http://127.0.0.1:8000/api/change-booking-status?id=4&option=2

id - ID BOOKING
option - 1 = Confirmed booking
         2 = Cancel booking

*/

Route::middleware('auth:sanctum')->get('/get-booking-list', [TaskerAPIController::class, 'getBookingListAPI']);
Route::middleware('auth:sanctum')->get('/get-refund-list', [TaskerAPIController::class, 'getRefundListAPI']);
Route::middleware('auth:sanctum')->get('/get-review-list', [TaskerAPIController::class, 'getReviewListAPI']);

Route::middleware('auth:sanctum')->post('/update-review-{id}', [TaskerAPIController::class, 'taskerReviewUpdateStatusAPI']);
/* 
NOTE: URL /update-review akan Post details :

/update-review-1?review_status=1/2
ex http://127.0.0.1:8000/api/update-review-1?review_status=1

id - ID REVIEW
review_status - 1 = Active
                2 = Hide

*/

Route::middleware('auth:sanctum')->post('/tasker-reply-review/{id}', [TaskerAPIController::class, 'taskerReplyReviewAPI']);
/* 
NOTE: URL /tasker-reply-review akan Post details :

/update-review-1?review_status=1/2
/tasker-reply-review/1?reply_message=AnyMessageHere
ex http://127.0.0.1:8000/api/tasker-reply-review/1?reply_message=AnyMessageHere

id - ID REVIEW
reply_message - Apa apa mesej nak reply

*/

Route::middleware('auth:sanctum')->get('/get-performance-analysis', [TaskerAPIController::class, 'getPerformanceAnalysisAPI']);

Route::middleware('auth:sanctum')->get('/get-e-statement', [TaskerAPIController::class, 'geteStatementAPI']);

Route::middleware('auth:sanctum')->get('/get-tasker-dashboard', [TaskerAPIController::class, 'taskerGetDashboardAPI']);





















