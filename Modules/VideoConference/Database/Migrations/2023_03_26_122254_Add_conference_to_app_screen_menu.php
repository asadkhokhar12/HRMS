<?php

use Illuminate\Support\Facades\Schema;
use App\Models\Hrm\AppSetting\AppScreen;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddConferenceToAppScreenMenu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
           try {
            // AppScreen::create([
            //     'name' => 'Video Conference',
            //     'slug' => 'video_conference',
            //     'position' => 10,
            //     'icon' => "assets/appScreenIcons/video-conference.png",
            //     'status_id' => 1
            // ]);
           } catch (\Throwable $th) {
            //throw $th;
           }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
