<?php

namespace Database\Seeders;

use App\Models\coreApp\Setting\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->settings() as $key => $value) {
            Setting::firstOrCreate([
                'name'       => $key,
                'value'      => $value,
                'context'    => 'app',
                'company_id' => 1,
            ]);
        }
    }

    protected function settings()
    {
        $companyName = 'Onesttech';
        $email = 'info@onesttech.com';
        $phone = '+62 (0) 000 0000 00';
        $address = 'House #148, Road #13/B, Block-E, Banani, Dhaka, Bangladesh';

        $settings = [
            'company_name'              => $companyName,
            'company_domain'            => env('APP_DOMAIN'),
            'company_logo_backend'      => 'uploads/settings/logo/logo-white.png',
            'company_logo_frontend'     => 'uploads/settings/logo/logo-black.png',
            'company_icon'              => 'uploads/settings/logo/favicon.png',
            'android_url'               => 'https://play.google.com/store/apps/details?id=com.worx24hour.hrm',
            'android_icon'              => 'assets/favicon.png',
            'ios_url'                   => 'https://apps.apple.com/us/app/24hourworx/id1620313188',
            'ios_icon'                  => 'assets/favicon.png',
            'language'                  => 'en',
            'site_under_maintenance'    => '0',
            'company_description'       => $companyName . ' believes in painting the perfect picture of your idea while maintaining industry standards.',
            'default_theme'             => 'app_theme_1',
            'app_theme_1'               => 'static/app-screen/screen-1.png',
            'app_theme_2'               => 'static/app-screen/screen-2.png',
            'app_theme_3'               => 'static/app-screen/screen-3.png',
            'email'                     => $email,
            'phone'                     => $phone,
            'address'                   => $address,
            'twitter_link'              => 'https://twitter.com',
            'linkedin_link'             => 'https://linkedin.com',
            'facebook_link'             => 'https://facebook.com',
            'instagram_link'            => 'https://instagram.com',
            'dribbble_link'             => 'https://dribbble.com',
            'behance_link'              => 'https://behance.com',
            'pinterest_link'            => 'https://pinterest.com',
            'contact_title'             => 'Send A Message To Get Your Free Quote',
            'contact_short_description' => 'Lorem Ipsum Dolor Sit Amet Consectetur. Est Commodo Pharetra Ac Netus Enim A Eget. Tristique Malesuada Donec Condimentum Mi Quis Porttitor Non Vitae Ultrices.',
            'mail_mailer'               => 'smtp',
            'mail_host'                 => 'smtp.gmail.com',
            'mail_port'                 => '587',
            'mail_username'             => 'test@test.com',
            'mail_password'             => '1234512345',
            'mail_from_address'         => 'test@test.com',
            'mail_encryption'           => 'tls',
            'mail_from_name'            => $companyName,
        ];

        return $settings;
    }
}
