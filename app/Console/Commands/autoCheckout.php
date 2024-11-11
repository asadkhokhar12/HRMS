<?php

namespace App\Console\Commands;

use App\Traits\AutoCheckoutTrait;
use Illuminate\Console\Command;

class autoCheckout extends Command
{
    use AutoCheckoutTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:checkout';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This Command will auto checkout the users who have not checked out';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
       return $this->autoCheckout();
    }
}
