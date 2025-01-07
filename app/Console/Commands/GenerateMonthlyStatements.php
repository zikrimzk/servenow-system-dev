<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Tasker;
use Illuminate\Console\Command;
use App\Models\MonthlyStatement;
use Illuminate\Support\Facades\DB;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Storage;

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
    // public function handle()
    // {
    //     $taskers = Tasker::all();
    //     $startDate = Carbon::now()->startOfMonth()->toDateString();
    //     $endDate = Carbon::now()->endOfMonth()->toDateString();

    //     foreach ($taskers as $tasker) {
    //         // Fetch booking data for the tasker
    //         $dataBooking = DB::table('taskers as a')
    //             ->join('services as b', 'a.id', '=', 'b.tasker_id')
    //             ->join('bookings as c', 'b.id', '=', 'c.service_id')
    //             ->where('a.id', $tasker->id)
    //             ->whereBetween('c.booking_date', [$startDate, $endDate])
    //             ->get();

    //         $totalCredit = $dataBooking->where('booking_status', 6)->sum('booking_rate');
    //         $totalUnCredit = $dataBooking->whereIn('booking_status', [5, 8])->sum('booking_rate');

    //         $statementDate = Carbon::now()->format('F Y');

    //         // Generate PDF
    //         $pdf = Pdf::loadView('tasker.eStatement.statement-template', [
    //             'title' => 'Tasker Monthly Statement',
    //             'tasker' => $tasker,
    //             'dataBooking' => $dataBooking,
    //             'totalCredit' => $totalCredit,
    //             'totalUnCredit' => $totalUnCredit,
    //             'statement_dateMY' => $statementDate,
    //         ]);

    //         $fileName = "statements/{$tasker->id}_{$statementDate}.pdf";
    //         Storage::put($fileName, $pdf->output());

    //         // Save statement details to database
    //         MonthlyStatement::create([
    //             'start_date' => $startDate,
    //             'end_date' => $endDate,
    //             'file_name' => $fileName,
    //             'statement_status' => 0,
    //             'tasker_id' => $tasker->id,
    //         ]);

    //         $this->info("Monthly statement generated for Tasker ID: {$tasker->id}");
    //     }

    // }

    public function handle()
    {
        $taskers = Tasker::all(); // Fetch all taskers
        $startDate = Carbon::now()->startOfMonth()->toDateString();
        $endDate = Carbon::now()->endOfMonth()->toDateString();

        foreach ($taskers as $tasker) {
            // Fetch booking data for the tasker
            $dataBooking = DB::table('taskers as a')
                ->join('services as b', 'a.id', '=', 'b.tasker_id')
                ->join('bookings as c', 'b.id', '=', 'c.service_id')
                ->where('a.id', $tasker->id)
                ->whereBetween('c.booking_date', [$startDate, $endDate])
                ->get();

            $totalCredit = $dataBooking->where('booking_status', 6)->sum('booking_rate');
            $totalUnCredit = $dataBooking->whereIn('booking_status', [5, 8])->sum('booking_rate');

            $statementDate = Carbon::now()->format('F_Y');

            $html = view('tasker.eStatement.statement-template', [
                'title' => 'Tasker Monthly Statement',
                'tasker' => $tasker,
                'dataBooking' => $dataBooking,
                'totalCredit' => $totalCredit,
                'totalUnCredit' => $totalUnCredit,
                'statement_dateMY' => $statementDate,
            ])->render();

            // File path
            // $fileName = "public/statements/{$tasker->tasker_code}_{$statementDate}.pdf";
            // $filePath = storage_path("app/{$fileName}");
            // $fileName = "{$tasker->tasker_code}_{$statementDate}.pdf";
            // $filePath = "statements/{$fileName}";

            // Define the directory and file path
            $directory = 'statements';
            $fileName = "{$tasker->tasker_code}_{$statementDate}.pdf";
            $filePath = "{$directory}/{$fileName}";

            // Ensure the directory exists
            if (!Storage::exists($directory)) {
                Storage::makeDirectory($directory);
            }

            // Generate PDF using Browsershot
            Browsershot::html($html)
                ->margins(10, 20, 10, 20)
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
                    'total_earnings' => $totalCredit,
                    'tasker_id' => $tasker->id,
                ]);
            }
            else{
                MonthlyStatement::where('tasker_id', $tasker->id)->where('start_date', $startDate)->where('end_date', $endDate)->update([
                    'file_name' => $filePath,
                ]);
            }


            $this->info("Monthly statement generated for Tasker ID: {$tasker->id}");
        }
    }
}
