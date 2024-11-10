<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class InstallHRMRegular extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hrm-regular:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'HRM Regular Install';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $startTime = microtime(true);
        exec('cp env.single.hrm .env');
        $this->info('Setup .env file successfully!');

        $this->setupENVCredentials('APP_MOOD', 'Regular');

        $this->call('config:cache');
        $this->setupAppDomain();
        $this->call('config:cache');
        $this->setupAppHttps();
        $this->call('config:cache');
        $this->setupDBCredentials();
        $this->call('config:cache');
        $this->runComposerUpdate();
        $this->call('config:cache');
        $this->runMigrationWithSeed();
        $this->call('config:cache');
        $this->generateAppKey();
        $this->call('config:cache');
        $this->call('optimize:clear');

        $endTime = microtime(true);
        $elapsedTime = round($endTime - $startTime, 2);

        $this->info("Total time: {$elapsedTime} seconds");

        $this->comment("Login Credentials:");
        $this->comment("Email: admin@onesttech.com");
        $this->comment("Password: 12345678");

        return Command::SUCCESS;
    }

    protected function setupAppHttps()
    {
        $confirmation = $this->confirm('Are you using a secure HTTPS connection?');

        if ($confirmation) {
            $this->setupENVCredentials('APP_HTTPS', 'true');
            $this->setupENVCredentials('APP_URL', 'https://${APP_DOMAIN}');
            $this->info('Great! Using HTTPS for a secure connection.');
        } else {
            $this->setupENVCredentials('APP_HTTPS', 'false');
            $this->setupENVCredentials('APP_URL', 'http://${APP_DOMAIN}');
            $this->info('Update APP HTTPS false.');
        }
    }

    protected function setupAppDomain()
    {
        $this->comment("Don't use http:// or https:// only use domain name");
        $appDomain = $this->ask('Enter your domain name here: e.g. example.com or abc.example.com');
        $this->setupENVCredentials('APP_DOMAIN', $appDomain);
    }

    protected function setupDBCredentials()
    {
        $databaseName = $this->ask('Enter the database name:');
        $this->setupENVCredentials('DB_DATABASE', $databaseName);

        $username = $this->ask('Enter the database username:');
        $this->setupENVCredentials('DB_USERNAME', $username);

        $password = $this->ask('Enter the database password:');
        $this->setupENVCredentials('DB_PASSWORD', $password);

        $this->info('Database credentials updated successfully!');
    }

    protected function generateAppKey()
    {
        $this->info("Application key generating...");
        $this->call('key:generate');
        $this->info("Application key generated");
    }

    protected function runMigrationWithSeed()
    {
        $this->info('Running... migration with seed');

        $this->call('db:wipe');

        $this->call('migrate:fresh', ['--seed' => true, '--path' => 'database/migrations/tenant']);

        $this->call('migrate');

        $this->info('Database refreshed and seeded successfully.');
        
    }

    protected function setupENVCredentials($key, $value)
    {
        $envFilePath        = base_path('.env');
        $envContent         = \File::get($envFilePath);
        $updatedEnvContent  = preg_replace('/'.$key.'=.+/', $key . '="' . $value . '"', $envContent);

        \File::put($envFilePath, $updatedEnvContent);
    }

    protected function getUpdatedValue($key)
    {
        $envFilePath = base_path('.env');
        $envContent = \File::get($envFilePath);

        if (preg_match("/{$key}=(.+)/", $envContent, $matches)) {
            return $matches[1];
        }

        return null;
    }

    public function runComposerUpdate()
    {
        $process = new Process(['composer', 'update', '--ignore-platform-reqs']);
        $process->start();

        $this->output->write('Composer updating ');

        while ($process->isRunning()) {
            $this->output->write('.');
            sleep(1);
        }

        $this->output->writeln('');

        if ($process->isSuccessful()) {
            $this->info('Composer update completed successfully.');
        } else {
            $this->error('Composer update failed: ' . $process->getErrorOutput());
        }
    }
}
