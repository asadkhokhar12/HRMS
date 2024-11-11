<?php

namespace App\View\Components;

use App\Models\Branch;
use Illuminate\View\Component;

class BranchDropdown extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $branches = Branch::where('status_id',1)->get();
        return view('components.branch-dropdown',compact('branches'));
    }
}
