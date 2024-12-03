<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Payroll\SalaryGenerate;
use App\Repositories\Hrm\Payroll\SalaryRepository;

class CalculateSalaries extends Command
{
    protected $salaryRepository;

    public function __construct(SalaryRepository $salaryRepository)
    {
        parent::__construct();
        $this->salaryRepository = $salaryRepository;
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'salary:calculate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate salary adjustments, deductions, and advances for the previous month';

    /**
     * Execute the console command.
     *
     * @return int
     */

    public function handle()
    {
        $hasErrors = false;

        // Get all users
        $users = User::all();

        foreach ($users as $user) {
            // Fetch the latest salary_generate record for this user
            $latestSalaryGenerate = DB::table('salary_generates')->where('user_id', $user->id)
                ->latest('id') // Sort by 'id' to get the latest record
                ->first();

                Log::info($user->company_id); // or use dd($info);

            if (!$latestSalaryGenerate) {
                $this->info("No salary record found for user: {$user->id}");
                continue;
            }

            // Prepare parameters for the salary calculation
            $params = [
                'id' => $latestSalaryGenerate->id,
                'company_id' => $latestSalaryGenerate->company_id ?? 1, // Use the company_id from the record, fallback to 1
            ];

            // Call the calculateWithCronJob method and handle the response
            $response = $this->salaryRepository->calculateWithCronJob($params);

            if (is_array($response) && isset($response['message'])) {
                if ($response['message'] === 'success') {
                    $this->info("Salary calculated successfully for user: {$user->id}");
                } else {
                    $this->error("Error calculating salary for user {$user->id}: " . ($response['error'] ?? 'Unknown error'));
                    $hasErrors = true;
                }
            } else {
                $this->error("Unexpected response for user {$user->id}: " . json_encode($response));
                $hasErrors = true;
            }
        }

        // Return 0 for success or 1 for failure based on errors
        return $hasErrors ? 1 : 0;
    }
}
