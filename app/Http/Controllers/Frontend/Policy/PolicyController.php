<?php

namespace App\Http\Controllers\Frontend\Policy;

use App\Http\Controllers\Controller;
use App\Models\Content\AllContent;

class PolicyController extends Controller
{

    public function pagesContent($slug)
    {

        $query = AllContent::where('slug', $slug)->first();
        $data['show'] = $query;
        $data['title'] = @$query->title ?? 'Company Policy';
        return view('frontend.content.page', compact('data'));
    }

    public function privacyPolicy()
    {
        $data['title'] = _trans('common.Privacy Policy');
        $data['show'] = AllContent::where('slug', 'privacy-policy')->first();
        return view('frontend.policy.privacyPolicy', compact('data'));
    }
    public function termsAndConditions()
    {
        $data['title'] = _trans('common.Terms And Conditions');
        $data['show'] = AllContent::where('slug', 'terms-of-use')->first();
        return view('frontend.termsConditions.termsAndConditions', compact('data'));
    }
    public function supportTwentyFour()
    {
        $data['title'] = _trans('common.Support 24/7');
        $data['show'] = AllContent::where('slug', 'support-24-7')->first();
        return view('frontend.support.supportTwentyFour', compact('data'));
    }
}
