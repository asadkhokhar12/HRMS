<?php

namespace Modules\EmployeeDocuments\Repositories;

use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;
use Illuminate\Support\Facades\DB;
use Modules\EmployeeDocuments\Entities\UserDocument;
use Modules\EmployeeDocuments\Entities\UserDocumentType;

class UserDocumentRepository
{
    use ApiReturnFormatTrait;
    public function getDocument($request)
    {
        try {
            $limit = $request->input('entries', 10); // Default entries per page is 10
            $page = $request->input('page', 1); // Default page is 1

            $document = UserDocument::query();

            // Apply search filter if 'search' parameter is provided
            if ($request->has('search')) {
                $search = $request->input('search');
                $document->where('name', 'LIKE', '%' . $search . '%');
            }

            // Apply date range filter if 'from' and 'to' parameters are provided
            if ($request->has('from') && $request->has('to')) {
                $from = $request->input('from');
                $to = $request->input('to');
                $document->whereBetween('created_at', [$from, $to]);
            }

            // Paginate the results with the specified limit and page number
            $documents = $document->paginate($limit, ['*'], 'page', $page);

            return $documents;
        } catch (\Throwable $th) {
            dd($th);
        }
    }
    public function getDocumentTypes($request)
    {
        try {
            $limit = $request->input('entries', 10); // Default entries per page is 10
            $page = $request->input('page', 1); // Default page is 1

            $document = UserDocumentType::query();

            // Apply search filter if 'search' parameter is provided
            if ($request->has('search')) {
                $search = $request->input('search');
                $document->where('name', 'LIKE', '%' . $search . '%');
            }

            // Apply date range filter if 'from' and 'to' parameters are provided
            if ($request->has('from') && $request->has('to')) {
                $from = $request->input('from');
                $to = $request->input('to');
                $document->whereBetween('created_at', [$from, $to]);
            }

            // Paginate the results with the specified limit and page number
            $documents = $document->paginate($limit, ['*'], 'page', $page);

            return $documents;
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function find($id)
    {
        return UserDocument::findOrFail($id);
    }

    public function create(array $data)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        UserDocument::create($data);
        return $this->responseWithSuccess(_trans('message.Store successfully.'), 200);
    }
    public function createType(array $data)
    {
        UserDocumentType::create($data);
        return $this->responseWithSuccess(_trans('message.Store successfully.'), 200);
    }

    public function update(UserDocument $userDocument, array $data)
    {
        $userDocument->update($data);
        return $this->responseWithSuccess(_trans('message.Updated successfully.'), 200);
    }


    // updateType
    public function updateType(array $data)
    {
        $update = UserDocumentType::find($data['id']);
        $update->name = $data['name'];
        $update->status_id = $data['status_id'];
        $update->save();
        return $this->responseWithSuccess(_trans('message.Updated successfully.'), 200);
    }

    public function delete(UserDocument $userDocument)
    {
        $userDocument->delete();
        return $this->responseWithSuccess(_trans('message.Deleted successfully.'), 200);
    }
}
