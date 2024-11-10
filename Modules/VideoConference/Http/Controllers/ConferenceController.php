<?php

namespace Modules\VideoConference\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\Support\Renderable;
use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;
use Modules\VideoConference\Entities\ConferenceMember;
use Modules\VideoConference\Http\Requests\CreateConferenceRequest;
use Modules\VideoConference\Repositories\ConferenceRepository;

class ConferenceController extends Controller
{

    use ApiReturnFormatTrait;
    
    protected $conferenceRepository;

    public function __construct(ConferenceRepository $conferenceRepository)
    {
        $this->conferenceRepository = $conferenceRepository;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        try {
            // return \Modules\VideoConference\Entities\Conference::with('members')->first();
            // return  route('conference.getList');

            $data['title'] = _trans('videoconference.Conference List');
            $data['conferences'] = $this->conferenceRepository->all();
            $data['fields'] = $this->conferenceRepository->fields();
            $data['url_id'] = 'conference_table_url';
            $data['table'] = route('conference.getList');
            $data['class'] = 'conference_table_class';
            // dd($data['table']);
            return view('videoconference::index', compact('data'));
        } catch (\Throwable $th) {
            dd($th);
        }
    }
    public function getList(Request $request)
    {
        return $this->conferenceRepository->table($request);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
     
        try {
            $data['title']     = _trans('videoconference.Create Conference');
            $data['url']      = (hasPermission('conference_store')) ? route('conference.store') : '';
            return view('videoconference::create', compact('data'));
        } catch (\Throwable $th) {
            Toastr::error(_trans('response.Something went wrong.'), 'Error');
            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        try {
            $result = $this->conferenceRepository->store($request);
            if ($result) {
                Toastr::success(_trans('response.Operation Done Succesfully'), 'Success');
                return redirect()->route('conference.index');
            } else {
                Toastr::error(_trans('response.Something went wrong.'), 'Error');
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            dd($th);
            Toastr::error(_trans('response.Something went wrong.'), 'Error');
            return redirect()->back();
        }
    }

    public function myMeeting()
    {
        try {
            $meetings= $this->conferenceRepository->myMeeting();
            $meeting_collection=$meetings->map(function($meeting){
                return [
                    'title'=>$meeting->name,
                    'start'=>$meeting->start_at,
                    'end'=>$meeting->end_at,
                    //php timestamp formate like wed 13 feb, 4pm -5pm
                    'time_text'=>date('D d M, h:i a',strtotime($meeting->start_at))."".date(' - h:i a',strtotime($meeting->end_at)),
                    'room_id'=>$meeting->room_id,
                    'external_link'=>$meeting->getJoinAttribute()['link'],
                    'internal_link'=>route('joinMeeting',$meeting->id),
                    'button'=>$meeting->getJoinAttribute()['button'],
                    'members'=>$meeting->members->map(function($member){
                        return [
                            'id'=>$member->user->id,
                            'name'=>$member->user->name,
                            'email'=>$member->user->email,
                            'avatar'=>uploaded_asset($member->user->avatar_id),
                        ];
                    }),
                ];
            });
            // return $meeting_collection;
            return $this->responseWithSuccess('Video Conference Details Details', $meeting_collection, 200);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 500);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        try {
            $data['title']     = _trans('videoconference.View Conference Details');
            $data['conference'] = $this->conferenceRepository->find($id);
            $data['url']      = (hasPermission('conference_update')) ? route('conference.update') : '';
            return view('videoconference::show', compact('data'));
        } catch (\Throwable $th) {
            Toastr::error(_trans('response.Something went wrong.'), 'Error');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        try {
            $data['title']     = _trans('videoconference.Edit Conference');
            $data['conference'] = $this->conferenceRepository->find($id);
            $data['url']      = (hasPermission('conference_update')) ? route('conference.update') : '';
            return view('videoconference::edit', compact('data'));
        } catch (\Throwable $th) {
            Toastr::error(_trans('response.Something went wrong.'), 'Error');
            return redirect()->back();
        }
    }
    public function delete($id)
    {

        try {
            $result = $this->conferenceRepository->distroy($id);
            if ($result) {
                Toastr::success(_trans('response.Operation Done Succesfully'), 'Success');
                return redirect()->route('conference.index');
            } else {
                Toastr::error(_trans('response.Something went wrong.'), 'Error');
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            Toastr::error(_trans('response.Something went wrong.'), 'Error');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request)
    {
        try {
            $result = $this->conferenceRepository->update($request);
            if ($result) {
                Toastr::success(_trans('response.Operation Done Succesfully'), 'Success');
                return redirect()->route('conference.index');
            } else {
                Toastr::error(_trans('response.Something went wrong.'), 'Error');
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            Toastr::error(_trans('response.Something went wrong.'), 'Error');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function join($id)
    {
        $is_member=ConferenceMember::where('user_id',auth()->user()->id)->with('conference')->where('conference_id',$id)->first();
        if ($is_member) {
            $data['link']='https://meet.jit.si/'.$is_member->conference->room_id;
            $data['title']=$is_member->conference->name;
            return view('videoconference::join',compact('data'));
        } else {
            Toastr::error(_trans('response.Link is invalid.'), 'Error');
            return redirect()->back();
        }
        
    }
    public function joinMeeting($id)
    {
        $is_member=ConferenceMember::with('conference')->where('conference_id',$id)->first();
        if ($is_member) {
            $data['link']='https://meet.jit.si/'.$is_member->conference->room_id;
            $data['title']=$is_member->conference->name;
            return view('videoconference::join',compact('data'));
        } else {
            Toastr::error(_trans('response.Link is invalid.'), 'Error');
            return redirect()->back();
        }
        
    }

    // Conference CRUD API
    public function conferenceAPIList(Request $request){
        try {
            return $this->conferenceRepository->conferenceList($request);
        } catch (\Throwable $exception) {
            return $this->responseWithError($exception->getMessage(), 400);
        }
    }

    public function storeAPI(CreateConferenceRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $request['user_id'] = explode(',', $request->user_id);
            $this->conferenceRepository->store($request);
            return $this->responseWithSuccess('Conference created successfully', 200);
        } catch (\Throwable $exception) {
            return $this->responseWithError($exception->getMessage(), 400);
        }
    }

    public function showAPI($id){
        try {
            return $this->conferenceRepository->conferenceShowAPI($id);
        } catch (\Throwable $exception) {
            return $this->responseWithError($exception->getMessage(), 400);
        }
    }
}
