<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Tasker;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use App\Models\MonthlyStatement;
use Illuminate\Support\Facades\DB;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Mail\MonthlyStatementNotification;

class GenerateMonthlyStatements extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'app:generate-monthly-statements';

    /**
     * The console command description.
     *
     * @var string
     */
    // protected $description = 'Command description';

    /**
     * Execute the console command.
     */

    protected $signature = 'generate:monthly-statements';
    protected $description = 'Generate monthly statements for all taskers and save them in the database';

    public function handle()
    {
        $taskers = Tasker::whereIn('tasker_status', [2, 3])->get(); // Fetch all taskers
        $startDate = Carbon::now()->startOfMonth()->toDateString();
        $endDate = Carbon::now()->endOfMonth()->toDateString();
        $todayDate = Carbon::now()->format('d/m/Y');

        foreach ($taskers as $tasker) {
            // Fetch booking data for the tasker
            $dataBooking = DB::table('taskers as a')
                ->join('services as b', 'a.id', '=', 'b.tasker_id')
                ->join('bookings as c', 'b.id', '=', 'c.service_id')
                ->join('clients as d', 'c.client_id', '=', 'd.id')
                ->where('a.id', $tasker->id)
                ->whereBetween('c.booking_date', [$startDate, $endDate])
                ->whereIn('c.booking_status',[5,6,7,8])
                ->get();

            $totalCredit = $dataBooking->where('booking_status', 6)->sum('booking_rate');
            $totalUnCredit = $dataBooking->whereIn('booking_status', [5, 7, 8])->sum('booking_rate');
            $statementFileDate = Carbon::now()->format('F_Y');
            $statementDate = Carbon::now()->format('F Y');
            $system_charges_rate = 3;
            $system_charges = $totalCredit * ($system_charges_rate / 100);
            $totalToBeCredited = $totalCredit - $system_charges;

            $totalTransaction = $dataBooking->whereIn('booking_status', [6, 7, 8])->count();


            $html = view('tasker.eStatement.statement-template', [
                'title' => 'Tasker Monthly Statement',
                'tasker' => $tasker,
                'dataBooking' => $dataBooking,
                'totalCredit' => $totalCredit,
                'totalUnCredit' => $totalUnCredit,
                'statement_dateMY' => $statementDate,
                'todayDate' => $todayDate,
                'system_charges_rate' => $system_charges_rate,
                'system_charges' => $system_charges,
                'totalToBeCredited' => $totalToBeCredited,
                'totalTransaction' => $totalTransaction
            ])->render();

            // Define the directory and file path
            $directory = 'statements';
            $fileName = "{$tasker->tasker_code}_{$statementFileDate}.pdf";
            $filePath = "{$directory}/{$fileName}";

            // Ensure the directory exists
            if (!Storage::exists($directory)) {
                Storage::makeDirectory($directory);
            }

            // Generate PDF using Browsershot
            Browsershot::html($html)
                ->setNodeBinary('/usr/bin/node') // Set the path to the Node.js binary
                ->setChromePath(storage_path('puppeteer/chrome/chrome')) // Set the path to Chrome
                ->margins(10, 10, 10, 10)
                ->format('A4')
                ->save(storage_path("app/public/{$filePath}"));

            $check = MonthlyStatement::where('tasker_id', $tasker->id)->where('start_date', $startDate)->where('end_date', $endDate)->exists();
            // Save statement details to the database
            if (!$check) {
                MonthlyStatement::create([
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'file_name' => $filePath,
                    'statement_status' => 0,
                    'total_earnings' => $totalToBeCredited,
                    'tasker_id' => $tasker->id,
                ]);

                Mail::to($tasker->email)->send(new MonthlyStatementNotification([
                    'name' => Str::headline($tasker->tasker_firstname . ' ' . $tasker->tasker_lastname),
                    'statement_status' => 0,
                    'month_year' => Carbon::parse($startDate)->format('F Y'),
                    'date' => Carbon::now()->format('d F Y g:i A'),
                    'total_earnings' => $totalToBeCredited,
                ]));
            }

            $this->info("Monthly statement generated for Tasker ID: {$tasker->id}");
        }
    }
}
