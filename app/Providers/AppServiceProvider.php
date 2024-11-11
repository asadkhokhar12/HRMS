<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use App\Models\Settings\HrmLanguage;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use App\Models\coreApp\Setting\Setting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Redirect;
use App\Repositories\Team\TeamRepository;
use App\Helpers\CoreApp\Traits\DateHandler;
use App\Repositories\Interfaces\TeamInterface;
use App\Helpers\CoreApp\Traits\GeoLocationTrait;
use App\Helpers\CoreApp\Traits\TimeDurationTrait;
use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;
use App\Models\coreApp\Relationship\RelationshipTrait;
use App\Repositories\DailyLeave\EloquentDailyLeaveRepository;
use App\Repositories\DailyLeave\DailyLeaveRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    use ApiReturnFormatTrait, RelationshipTrait, TimeDurationTrait, GeoLocationTrait, DateHandler;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Repositories\Interfaces\TeamInterface::class,
            \App\Repositories\Team\TeamRepository::class
        );
        $this->app->bind(DailyLeaveRepositoryInterface::class, EloquentDailyLeaveRepository::class);

    }
    public function boot()
    {
        try {
            DB::connection()->getPdo();
            if (Schema::hasTable('settings')) {
                $settings = Setting::get()->pluck('value', 'name');
                foreach ($settings as $key => $value) {
                    config()->set("settings.app.{$key}", $value);
                }

                config([
                    'mail.mailers.smtp.host' => base_settings('mail_host'),
                    'mail.mailers.smtp.port' => base_settings('mail_port'),
                    'mail.mailers.smtp.encryption' => base_settings('mail_encryption'),
                    'mail.mailers.smtp.username' => base_settings('mail_username'),
                    'mail.mailers.smtp.password' => base_settings('mail_password'),
                    'mail.from.address' => base_settings('mail_from_address'),
                    'mail.from.name' => base_settings('mail_from_name'),
                ]);
            }

            if (Schema::hasTable('company_configs')) {
                config(['app.timezone' => settings('timezone')]);
            }

            //app singleton
            $this->app->singleton('settings', function () {
                return Setting::get()->pluck('value', 'name');
            });
            $this->app->singleton('hrm_languages', function () {
                return HrmLanguage::with('language')->where('status_id', 1)->get();
            });
            
            if (env('APP_HTTPS') == true) {
                URL::forceScheme('https');
                $this->app['request']->server->set('HTTPS', true);
            }

            Paginator::useBootstrapFive();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

    }
}
