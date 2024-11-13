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
                    'mail.mailers.smtp.mailer' => env('MAIL_MAILER'),
                    'mail.mailers.smtp.host' => env('MAIL_HOST'),
                    'mail.mailers.smtp.port' => env('MAIL_PORT'),
                    'mail.mailers.smtp.encryption' => env('MAIL_ENCRYPTION'),
                    'mail.mailers.smtp.username' => env('MAIL_USERNAME'),
                    'mail.mailers.smtp.password' => env('MAIL_PASSWORD'),
                    'mail.from.address' => env('MAIL_FROM_ADDRESS'),
                    'mail.from.name' => env('mail_from_name'),
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
