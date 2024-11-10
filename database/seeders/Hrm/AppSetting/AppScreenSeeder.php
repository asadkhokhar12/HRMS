<?php

namespace Database\Seeders\Hrm\AppSetting;

use App\Models\Hrm\AppSetting\AppScreen;
use Illuminate\Database\Seeder;

class AppScreenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menus = [ 
            'notice', 
            'expense', 
            'approval', 
            'phonebook',
            'break'
        ];

        $input = session()->get('input');

        if ($input) {
            if (in_array('support', activeSubscriptionFeatures())) {
                $menus[] = 'support';
            }
            if (in_array('attendance', activeSubscriptionFeatures())) {
                $menus[] = 'attendance';
            }
            if (in_array('task', activeSubscriptionFeatures())) {
                $menus[] = 'task';
            }
            if (in_array('leave', activeSubscriptionFeatures())) {
                $menus[] = 'leave';
                $menus[] = 'daily_leave';
            }
            if (in_array('payroll', activeSubscriptionFeatures())) {
                $menus[] = 'payroll';
            }
            if (in_array('meeting', activeSubscriptionFeatures())) {
                $menus[] = 'meeting';
            }
            if (in_array('appointment', activeSubscriptionFeatures())) {
                $menus[] = 'appointments';
            }
            if (in_array('visit', activeSubscriptionFeatures())) {
                $menus[] = 'visit';
            }
            if (in_array('report', activeSubscriptionFeatures())) {
                $menus[] = 'report';
            }
        } else {
            $menus[] = 'support';
            $menus[] = 'attendance';
            $menus[] = 'task';
            $menus[] = 'leave';
            $menus[] = 'daily_leave';
            $menus[] = 'payroll';
            $menus[] = 'meeting';
            $menus[] = 'appointments';
            $menus[] = 'visit';
            $menus[] = 'report';
        }


        if (isModuleActive('VideoConference')) {
            if ($input) {
                if (in_array('conference', activeSubscriptionFeatures())) {
                    $menus[] = 'conference';
                    $menus[] = 'chat';
                }
            } else {
                $menus[] = 'conference';
                $menus[] = 'chat';
            }
        }
        
        foreach ($menus as $key => $menu) {
            $iconName = $menu . '.png';
            AppScreen::updateOrCreate(
                ['slug' => $menu],
                [
                    'name' => plain_text($menu),
                    'position' => $key + 1,
                    'icon' => "assets/appScreenIcons/{$iconName}",
                    'status_id' => 1,
                ]
            );

        }
    }
}
