<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\MonthlyStatement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Artisan;
use App\Mail\MonthlyStatementNotification;

class StatementController extends Controller
{
    public function adminUpdateStatementStatus($id)
    {
        try {
            MonthlyStatement::where('id', $id)->update(['statement_status' => 1]);

            $datas = DB::table('taskers as a')
                ->join('monthly_statements as b', 'a.id', '=', 'b.tasker_id')
                ->where('b.id', $id)
                ->get();

            foreach ($datas as $data) {
                Mail::to($data->email)->send(new MonthlyStatementNotification([
                    'name' => Str::headline($data->tasker_firstname . ' ' . $data->tasker_lastname),
                    'statement_status' => $data->statement_status,
                    'month_year' => Carbon::parse($data->start_date)->format('F Y'),
                    'date' => Carbon::now()->format('d F Y g:i A'),
                    'total_earnings' => $data->total_earnings,
                ]));
            }

            return back()->with('success', 'Amount released successfully. Make sure to double check if the amount is really released.');
        } catch (Exception $e) {
            return back()->with('error', 'Oops! Something went wrong. Please try again.');
        }
    }

    public function adminUpdateMultipleStatementStatus(Request $request)
    {
        try {
            $statementIds = $request->input('selected_statments');

            MonthlyStatement::whereIn('id', $statementIds)->update(['statement_status' => 1]);

            $datas = DB::table('taskers as a')
                ->join('monthly_statements as b', 'a.id', '=', 'b.tasker_id')
                ->whereIn('b.id', $statementIds)
                ->get();

            foreach ($datas as $data) {
                Mail::to($data->email)->send(new MonthlyStatementNotification([
                    'name' => Str::headline($data->tasker_firstname . ' ' . $data->tasker_lastname),
                    'statement_status' => $data->statement_status,
                    'month_year' => Carbon::parse($data->start_date)->format('F Y'),
                    'date' => Carbon::now()->format('d F Y g:i A'),
                    'total_earnings' => $data->total_earnings,
                ]));
            }

            return response()->json([
                'success' => 'Amount released successfully. Make sure to double check if the amount is really released.'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Oops! Something went wrong. Please try again.'
            ]);
        }
    }

    public function triggerGenerateButton()
    {
        try {
            Artisan::call('generate:monthly-statements');
            return back()->with('success', 'Monthly statements refresh successfully !');
        } catch (Exception $e) {
            return back()->with('error', 'Oops! Something went wrong. Please try again.');
        }
    }
}
