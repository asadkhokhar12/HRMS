<?php

namespace Modules\MultiTheme\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\coreApp\Setting\Setting;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function __construct()
    {
        if (!isModuleActive('MultiTheme')) {
            abort('404');
        }
    }

    public function appThemeSetup(Request $request)
    {
        if (config('app.style') === 'demo' || env('APP_STYLE') === "demo") {
            Toastr::warning('You are not allowed to perform the delete action in demo mode.', 'Warning');
            return redirect()->back();
        }
        
        try {
            Setting::where('name', 'default_theme')->update(['value' => $request->app_theme]);
            Toastr::success(_trans('settings.App theme updated successfully'), 'Success');
            return redirect('/admin/settings/?app_theme_setup=true');
        } catch (\Exception $e) {
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }
}
