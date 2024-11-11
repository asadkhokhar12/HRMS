<?php

namespace Modules\EmployeeDocuments\Http\Controllers;

use App\Helpers\CoreApp\Traits\FileHandler;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Modules\EmployeeDocuments\Entities\UserDocumentType;
use Modules\EmployeeDocuments\Http\Requests\DocumentTypeRequest;
use Modules\EmployeeDocuments\Repositories\UserDocumentRepository;

class UserDocumentController extends Controller
{
    use FileHandler;
    private $userDocumentRepository;

    public function __construct(UserDocumentRepository $userDocumentRepository)
    {
        $this->userDocumentRepository = $userDocumentRepository;
    }

    // Display a listing of user documents
    public function index(Request $request)
    {

        $data['class'] = 'document_list';
        $data['title'] = _trans('common.Documents');
        $data['input'] = $request->all();
        $data['url'] = route('documents.tbody');
        return view('employeedocuments::user_documents.index', compact('data'));
    }
    public function types(Request $request)
    {
        $data['class'] = 'document_types';
        $data['title'] = _trans('common.Document Types');
        $data['input'] = $request->all();
        $data['url'] = route('documents.types.tbody');
        return view('employeedocuments::user_document_types.index', compact('data'));
    }
    public function typeTbody(Request $request)
    {
        // if ($request->ajax()) {
        $data['items'] = $this->userDocumentRepository->getDocumentTypes($request);
        return response()->json(['view' => view('employeedocuments::user_document_types.updateTbody', compact('data'))->render()]);
        // }
        return response()->json(['view' => ""], 200);
    }
    public function documentTbody(Request $request)
    {
        // if ($request->ajax()) {
        $data['items'] = $this->userDocumentRepository->getDocument($request);
        return response()->json(['view' => view('employeedocuments::user_documents.updateTbody', compact('data'))->render()]);
        // }
        return response()->json(['view' => ""], 200);
    }

    // Show the form for creating a new user document
    public function create()
    {
        $data['users'] = User::where('role_id', '!=', 1)->get();
        $data['title'] = _trans('common.Create Document');
        $data['url'] = route('documents.store');
        $data['types'] = UserDocumentType::all();
        return view('employeedocuments::user_documents.create', compact('data'));
    }


    // Store a newly created user document in the database
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_document_type_id' => 'required',
            'document_title' => 'required',
            'attachment' => 'required',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $inputs = $request->all();
        $uploadedFile = $request->file('attachment');
        if ($request->hasFile('attachment')) {
            $attachment_id = $this->uploadImage($uploadedFile, 'uploads/attachment')->id;
            $inputs['attachment_id'] = $attachment_id;
        }
        if (!isset($request->user_id) || $request->user_id == "") {
            $inputs['user_id'] = Auth::user()->id;
        }

        $this->userDocumentRepository->create($inputs);

        return redirect()->route('documents.index')->with('success', 'User document created successfully');
    }

    // Display the specified user document
    public function show($id)
    {
        $userDocument = $this->userDocumentRepository->find($id);
        return view('employeedocuments::user_documents.show', compact('userDocument'));
    }

    // Show the form for editing the specified user document
    public function edit($id)
    {
        $userDocument = $this->userDocumentRepository->find($id);
        return view('employeedocuments::user_documents.edit', compact('userDocument'));
    }

    // Update the specified user document in the database
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'document_type' => 'required',
            'document_number' => 'required',
            'document_expiration' => 'nullable|date',
        ]);

        $userDocument = $this->userDocumentRepository->find($id);
        $this->userDocumentRepository->update($userDocument, $validatedData);

        return redirect()->route('documents.index')->with('success', 'User document updated successfully');
    }

    // Remove the specified user document from the database
    public function destroy($id)
    {
        $userDocument = $this->userDocumentRepository->find($id);
        $this->userDocumentRepository->delete($userDocument);

        return redirect()->route('documents.index')->with('success', 'User document deleted successfully');
    }

// start type section

    public function typeCreate()
    {
        $data['title'] = _trans('common.Create Document Type');
        $data['url'] = route('documents.types.store');
        return view('employeedocuments::user_document_types.create', compact('data'));
    }

    public function typeEdit($id)
    {
        $data['title'] = _trans('common.Edit Document Type');
        $data['url'] = route('documents.types.update');
        $data['edit'] = UserDocumentType::find($id);
        return view('employeedocuments::user_document_types.edit', compact('data'));
    }

    public function typeStore(DocumentTypeRequest $request)
    {
        $inputs = $request->all();
        $this->userDocumentRepository->createType($inputs);
        return redirect()->route('documents.types.index')->with('success', _trans('common.User document type created successfully'));
    }

    public function typeUpdate(DocumentTypeRequest $request)
    {
        $inputs = $request->all();
        $this->userDocumentRepository->updateType($inputs);
        return redirect()->route('documents.types.index')->with('success', _trans('common.User document type created successfully'));
    }
    public function typeDelete($id)
    {
        $result = UserDocumentType::find($id)->delete();
        return redirect()->route('documents.types.index')->with('success', _trans('common.Item deleted successfully'));
    }
}
