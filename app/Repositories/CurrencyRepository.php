<?php

namespace App\Repositories;

use App\Models\Settings\Currency;
use Mail;
use App\Models\Traits\CompanyTrait;
use App\Helpers\CoreApp\Traits\FileHandler;
use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

class CurrencyRepository extends BaseRepository
{
    use FileHandler, CompanyTrait, ApiReturnFormatTrait;

    public function model()
    {
        return Currency::class;
    }

    function fields()
    {
        return [
            _trans('common.Name'),
            _trans('common.Code'),
            _trans('common.Symbol'),
            _trans('common.Action')
        ];
    }

    function table($request)
    {
        // Log::info($request->all());
        $data = $this->model->query();
        if ($request->search) {
            $data = $data->where('name', 'like', '%' . $request->search . '%');
        }
        $data = $data->paginate($request->limit ?? 2);
        return [
            'data' => $data->map(function ($data) {
                $action_button = '';
                    $action_button .= '<a href="' . route('manage.settings.edit_currency', $data->id) . '" class="dropdown-item"> ' . _trans('common.Edit') . '</a>';

                $button = ' <div class="dropdown dropdown-action">
                                       <button type="button" class="btn-dropdown" data-bs-toggle="dropdown"
                                           aria-expanded="false">
                                           <i class="fa-solid fa-ellipsis"></i>
                                       </button>
                                       <ul class="dropdown-menu dropdown-menu-end">
                                       ' . $action_button . '
                                       </ul>
                                   </div>';

                return [
//                    'id' => $data->id,
                    'name' => @$data->name,
                    'code' => @$data->code,
                    'symbol' => @$data->symbol,
                    'action'   => $button
                ];
            }),
            'pagination' => [
                'total' => $data->total(),
                'count' => $data->count(),
                'per_page' => $data->perPage(),
                'current_page' => $data->currentPage(),
                'total_pages' => $data->lastPage(),
                'pagination_html' =>  $data->links('backend.pagination.custom')->toHtml(),
            ],
        ];
    }
}
