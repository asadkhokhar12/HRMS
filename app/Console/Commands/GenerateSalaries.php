<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Repositories\Hrm\Payroll\SalaryRepository;

class GenerateSalaries extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'salary:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate salaries for the previous month on the first day of the current month';

    /**
     * SalaryRepository instance.
     *
     * @var SalaryRepository
     */
    protected $salaryRepository;

    /**
     * Create a new command instance.
     *
     * @param SalaryRepository $salaryRepository
     */
    public function __construct(SalaryRepository $salaryRepository)
    {
        parent::__construct(); // Call parent constructor
        $this->salaryRepository = $salaryRepository;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Get the previous month in "Y-m" format
        $previousMonth = Carbon::now()->subMonth()->format('Y-m');

        // Prepare the request
        $request = new \Illuminate\Http\Request();
        $request->merge([
            'month' => $previousMonth,
            'department' => 0,
        ]);

        try {
            // Call the repository method
            $response = $this->salaryRepository->generateWithCronJob($request);

            // Check for successful response
            if ($response && method_exists($response, 'getStatusCode') && $response->getStatusCode() === 200) {
                $this->info("Salaries generated successfully for $previousMonth");
            } else {
                $this->error('Error generating salaries: ' . ($response->getContent() ?? 'Unknown error'));
            }
        } catch (\Exception $e) {
            // Log and display the error
            $this->error('An error occurred: ' . $e->getMessage());
        }

        return 0;
    }
}
