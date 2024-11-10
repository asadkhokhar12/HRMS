<?php

namespace App\View\Components;

use App\Models\Settings\Language;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class LanguageDropdown extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $languages = Cache::rememberForever('languages', function () {
            return Language::where('status', 1)->get();
        });

        $data['languages'] = $languages;
        $data['user_language'] = $languages->where('code', userLocal())->first() ? $languages->where('code', userLocal())->first()->name : 'English';
        return view('components.language-dropdown', compact('data'));
    }
}
