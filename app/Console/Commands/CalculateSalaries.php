<?php

namespace App\Console\Commands;

use Illuminate\Http\Request;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
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
        try {
            // Get all users
            $users = DB::table('users')->get();

            // Iterate over each user and process their salary
            foreach ($users as $user) {
                // Fetch the latest salary record for the user
                $latestSalaryGenerate = DB::table('salary_generates')
                    ->where('user_id', $user->id)
                    ->latest()
                    ->first();

                // If no salary found for the user, skip this iteration (optional)
                if (!$latestSalaryGenerate) {
                    $this->info("No salary record found for user: {$user->id}");
                    continue;
                }

                // Prepare the parameters for the salary calculation
                $params = [
                    'id' => $latestSalaryGenerate->id ?? 0,
                    'company_id' => 1,
                ];

                // Handle the response properly
                $response = $this->salaryRepository->calculateWithCronjob($params);

                // Check if the response is a JsonResponse
                if ($response instanceof \Illuminate\Http\JsonResponse) {
                    
                    $content = $response->getData(true); // Decode JSON response into an array
                    if ($response->getStatusCode() === 200) {
                        $this->info("Salaries calculated successfully for user: {$user->id}");
                    } else {
                        $this->error("Error calculating salary for user {$user->id}: " . $content['message']);
                    }
                } else {
                    $this->error("Unexpected response format for user {$user->id}");
                }
            }
        } catch (\Exception $e) {
            $this->error('An error occurred: ' . $e->getMessage());
        }

        return 0;
    }
}
