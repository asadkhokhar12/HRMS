<?php

namespace Modules\VideoConference\Repositories;

use Carbon\Carbon;
use App\Http\Resources\Hrm\ConferenceCollection;
use Modules\VideoConference\Entities\Conference;
use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;
use App\Models\coreApp\Relationship\RelationshipTrait;
use Modules\VideoConference\Entities\ConferenceMember;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class ConferenceRepository.
 */
class ConferenceRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    use ApiReturnFormatTrait, RelationshipTrait;
    
    public function model()
    {
        return Conference::class;
    }

    function fields(){
        return [
            _trans('common.ID'),
            _trans('common.Title'),
            _trans('common.Start Time'),
            _trans('common.End Time'),
            // _trans('common.Room ID'),
            _trans('common.Members'),
            _trans('common.Status'),
            _trans('common.Action')
        ];
    }

    public function table($request)
    {
        $award =  $this->model->query()->with('members')->where(['company_id' => auth()->user()->company_id]);
      
        if ($request->from && $request->to) {
            $award = $award->whereBetween('created_at', start_end_datetime($request->from, $request->to));
        }
        $award = $award->paginate($request->limit ?? 10);


        return [
            'data' => $award->map(function ($data) {
                $action_button = '';

                if (hasPermission('conference_view')) {
                    $action_button .= '<a href="' . route('conference.view', [$data->id]) . '" class="dropdown-item"> ' . _trans('common.View') . '</a>';
                }
                
                if (hasPermission('conference_update')) {
                    $action_button .= '<a href="' . route('conference.edit', [$data->id]) . '" class="dropdown-item"> ' . _trans('common.Edit') . '</a>';
                }
                if (hasPermission('conference_delete')) {
                    $action_button .= actionButton('Delete', '__globalDelete(' . $data->id . ',`video-conference/conference/delete/`)', 'delete');
                }
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
                    'id' => $data->id,
                    'title' => $data->name,
                    'start_time' => showDate($data->start_at),
                    'end_time' => showDate($data->end_at),
                    // 'room_id' => $data->room_id,
                    'members' => $data->members->count(),
                    'status' => '<small class="badge badge-' . @$data->status->class . '">' . @$data->status->name . '</small>',
                    'action'   => $button
                ];
            }),
            'pagination' => [
                'total' => $award->total(),
                'count' => $award->count(),
                'per_page' => $award->perPage(),
                'current_page' => $award->currentPage(),
                'total_pages' => $award->lastPage(),
                'pagination_html' =>  $award->links('backend.pagination.custom')->toHtml(),
            ],
        ];
    }

    function addConferenceMember($request,$conference_id){
        try {
            foreach ($request->user_id as $key => $member_id) {
                $member=new ConferenceMember();
                $member->user_id=$member_id;
                $member->conference_id=$conference_id;
                $member->is_host=$member_id==auth()->user()->id?1:0;
                $member->save();
            }
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
    function addConferencehost($conference_id){
        try {
            $member=new ConferenceMember();
                $member->user_id=auth()->user()->id;
                $member->conference_id=$conference_id;
                $member->is_host=1;
                $member->save();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    function find($id){
        return $this->model->with('members','members.user','status')
        ->find($id);
    }
    function distroy($id){
        try {
            $conference=$this->model->find($id);
            $conference->members()->delete();
            $conference->delete();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
    function store($request){
        try {
            $conference=new $this->model();
            $conference->name=$request->title;
            $conference->description=$request->content;
            $conference->start_at=$request->date.' '.$request->start_at.':00';
            $conference->end_at=$request->date.' '.$request->end_at.':00';
            $conference->created_by=auth()->user()->id;
            $conference->company_id=auth()->user()->company_id;
            $conference->save();

            $this->addConferenceMember($request,$conference->id);
            if (!in_array(auth()->user()->id,$request->user_id)){
                $this->addConferencehost($conference->id);
            }
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
    function update($request){
        try {
            $conference=$this->model->find($request->id);
            $conference->name=$request->title;
            $conference->description=$request->content;
            $conference->start_at=$request->date.' '.$request->start_at.':00';
            $conference->end_at=$request->date.' '.$request->end_at.':00';
            $conference->created_by=auth()->user()->id;
            $conference->company_id=auth()->user()->company_id;
            $conference->save();

            $conference->members()->delete();

            $this->addConferenceMember($request,$conference->id);
            if (!in_array(auth()->user()->id,$request->user_id)){
                $this->addConferencehost($conference->id);
            }

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
    function myMeeting(){
        return $this->model->query()->with('members')
        ->where(['company_id' => auth()->user()->company_id])
        // ->where('start_at','>',date('Y-m-d H:i:s'))
        // ->where('end_at','<',date('Y-m-d H:i:s'))
        //skip if end_at not equal to current date
        ->whereRaw('DATE(end_at) = CURDATE()')


        ->whereHas('members',function($q){
            $q->where('user_id',auth()->user()->id);
        })->orderBy('id','desc')->get();
    }

    // conference api
    public function conferenceList(): \Illuminate\Http\JsonResponse
    {
        $conference = $this->model->query()
            ->join('conference_members', 'conference_members.conference_id','=', 'conferences.id')
            ->where(function ($query) {
                $query->where(['conferences.company_id' => $this->companyInformation()->id]);
            })
            ->select('conferences.*','conferences.id as id')
            ->orderByDesc('conferences.id')
            ->distinct()
            ->get();
        $data = new ConferenceCollection($conference);
        return $this->responseWithSuccess('Conference list', $data, 200);
    }

    public function conferenceShowAPI($id){
        $conference = $this->model->query()->where('id', $id)->get();
        if($conference->count() === 0){
            return $this->responseWithError('Conference Data not found', [], 422);
        }
        $data = new ConferenceCollection($conference);
        return $this->responseWithSuccess('Conference list', $data, 200);
    }
}