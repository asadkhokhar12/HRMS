<?php

namespace App\View\Components;

use App\Models\Settings\Language;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class FrontendLanguageDropdown extends Component
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
        $languages = Cache::rememberForever('frontendLanguages', function () {
            return Language::where('status', 1)->get();
        });

        $data['languages'] = $languages;
        $data['frontend_language'] = @$languages->where('code', session()->get('frontendLocal'))->first()->name ?? @Language::where('is_default', 1)->first()->name;

        return view('components.frontend-language-dropdown', compact('data'));
    }
}
