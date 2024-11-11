<?php

namespace App\Http\Controllers\Frontend\Contact;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Repositories\Hrm\Contact\ContactRepository;

class ContactController extends Controller
{
    
    protected $contact;

    public function __construct(ContactRepository $contact)
    {
        $this->contact = $contact;
    }

    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                return $this->contact->table($request);
            }
            $data['fields'] = $this->contact->fields();
            $data['title'] = _trans('common.Languages');
            $data['url_id']    = 'contact_table_url';
            $data['class']     = 'table_class';
            $data['title'] = _trans('common.Contact');
            return view('backend.contact.index',compact('data'));
        } catch (\Throwable $th) {
            dd($th);
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }

    public function datatable(Request $request)
    {
        try {
            return $this->contact->datatable($request);
        } catch (\Throwable $th) {
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }

    public function create(){
        try {
            $data['title'] = _trans('common.Add Contact');
            return view('backend.contact.create', compact('data'));
        } catch (\Exception $exception) {
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {

        try {
            $data = $this->contact->store($request);
            if ($data->original['result']) {
                Toastr::success(_trans('response.Contact added successfully'), 'Success');
            } else {
                Toastr::error('No contact added', 'Error');
            }
            return redirect()->route('contact.index');
        } catch (\Exception $exception) {
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
