<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\MonthlyStatement;
use Illuminate\Support\Facades\Artisan;

class StatementController extends Controller
{
    public function adminUpdateStatementStatus($id)
    {
        try{
            MonthlyStatement::where('id', $id)->update(['statement_status' => 1]);

            return back()->with('success', 'Amount released successfully. Make sure to double check if the amount is really released.');

        }catch(Exception $e){
            return back()->with('error', 'Oops! Something went wrong. Please try again.');

        }
    }

    public function triggerGenerateButton()
    {
        try{
            Artisan::call('generate:monthly-statements');
            return back()->with('success', 'Monthly statements refresh successfully !');

        }catch(Exception $e){
            return back()->with('error', 'Oops! Something went wrong. Please try again.');

        }
    }
}
