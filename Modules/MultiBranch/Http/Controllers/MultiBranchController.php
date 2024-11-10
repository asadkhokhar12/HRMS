<?php

namespace Modules\MultiBranch\Http\Controllers;

use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;
use App\Models\Branch;
use App\Models\coreApp\Relationship\RelationshipTrait;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\MultiBranch\Http\Requests\BranchRequest;
use Modules\MultiBranch\Http\Requests\BranchRequestStore;
use Modules\MultiBranch\Repositories\BranchRepository;

class MultiBranchController extends Controller
{

    use RelationshipTrait, ApiReturnFormatTrait;

    protected $branchRepository;
    protected $model;

    public function __construct(BranchRepository $branchRepository, Branch $model)
    {
        $this->branchRepository = $branchRepository;
        $this->model = $model;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->branchRepository->table($request);
        }
        $data['title'] = _trans('common.Branch');
        $data['class'] = 'branch_table';
        $data['fields'] = $this->branchRepository->fields();
        $data['checkbox'] = true;
        return view('MultiBranch::index', compact('data'));
    }

    public function create()
    {
        $data['title'] = _trans('common.Add Branch');
        return view('backend.branch.create', compact('data'));
    }

    public function dataTable(Request $request): object
    {
        return $this->branchRepository->dataTable($request);
    }

    public function show($id)
    {
        return $this->branchRepository->show($id);
    }

    public function edit(Branch $branch)
    {
        try {
            $data['title'] = _trans('common.Edit Branch');
            $data['url'] = route('branch.update', $branch->id);
            $data['attributes'] = $this->branchRepository->editAttributes($branch);
            @$data['button'] = _trans('common.Update');
            return view('backend.modal.create', compact('data'));
        } catch (\Throwable $th) {
            return response()->json('fail');
        }
    }

    public function update(BranchRequest $request, Branch $branch)
    {
        // return $this->branchRepository->update($request,$branch);
        try {
            if (!$request->ajax()) {
                Toastr::error(_trans('response.Please click on button!'), 'Error');
                return redirect()->back();
            }

            return $this->branchRepository->update($request, $branch);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    public function destroy($id)
    {

        try {
            $this->branchRepository->destroy($id);
            return redirect()->route('branches.index');
        } catch (\Exception $e) {
            Toastr::error(_trans('response.Something went wrong.'), 'Error');
            return redirect()->back();
        }
    }

    public function changeBranch(Request $request)
    {

        try {
            session(['session_branch_id' => $request->branch_id]);
            return response()->json([
                'success' => true,
                'message' => _trans('response.Branch changed successfully.'),
                'result' => null,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => _trans('response.Something went wrong.'),
                'result' => null,
            ]);
        }
    }

    // new functions for

    public function createModal()
    {
        try {
            $data['title'] = _trans('common.Create Branch');
            $data['url'] = route('branches.store');
            $data['attributes'] = $this->branchRepository->createAttributes();
            @$data['button'] = _trans('common.Save');
            return view('backend.modal.create', compact('data'));
        } catch (\Throwable $th) {
            return response()->json('fail');
        }
    }

    public function store(BranchRequestStore $request)
    {

        try {
            if (!$request->ajax()) {
                Toastr::error(_trans('response.Please click on button!'), 'Error');
                return redirect()->back();
            }

            return $this->branchRepository->newStore($request);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }
}
