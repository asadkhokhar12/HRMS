<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Company\Company;
use App\Repositories\Company\CompanyRepository;

class CompanyDropdown extends Component
{
    protected $company;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(CompanyRepository $companyRepository)
    {
        $this->company = $companyRepository;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $companies = $this->company->index();
        return view('components.company-dropdown',compact('companies'));
    }
}
