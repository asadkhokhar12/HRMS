<?php

namespace App\Repositories\Api\V1;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Management\Project;
use App\Models\TaskManagement\Task;
use Illuminate\Support\Facades\Auth;
use App\Models\Hrm\AppSetting\AppScreen;
use App\Models\Management\DiscussionLike;
use App\Models\TaskManagement\TaskMember;
use App\Repositories\DashboardRepository;
use Illuminate\Support\Facades\Validator;
use App\Helpers\CoreApp\Traits\FileHandler;
use App\Repositories\DutyScheduleRepository;
use App\Models\coreApp\Setting\CompanyConfig;
use App\Models\TaskManagement\TaskDiscussion;
use App\Repositories\Settings\ApiSetupRepository;
use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;
use App\Models\coreApp\Relationship\RelationshipTrait;
use App\Repositories\Hrm\Content\AllContentRepository;
use App\Repositories\Settings\CompanyConfigRepository;

class HrmAppRepository
{
    use RelationshipTrait, ApiReturnFormatTrait, FileHandler;

    protected $companyConfig;
    protected $appScreen;
    protected $dashboardRepository;
    protected $dutyScheduleRepository;
    protected $allContents;
    protected $thirdPartyApiRepository;
    protected $config_repo;

    public function __construct(
        CompanyConfig $companyConfig,
        AppScreen $appScreen,
        DashboardRepository $dashboardRepository,
        CompanyConfigRepository $companyConfigRepo,
        DutyScheduleRepository $dutyScheduleRepository,
        AllContentRepository $allContents,
        ApiSetupRepository $thirdPartyApiRepository
    ) {
        $this->companyConfig = $companyConfig;
        $this->appScreen = $appScreen;
        $this->dashboardRepository = $dashboardRepository;
        $this->config_repo = $companyConfigRepo;
        $this->dutyScheduleRepository = $dutyScheduleRepository;
        $this->allContents = $allContents;
        $this->thirdPartyApiRepository = $thirdPartyApiRepository;
    }

    public function MemberListCollection($members)
    {
        return $members->map(function ($data) {
            return [
                'id' => $data->user->id,
                'name' => $data->user->name,
                'phone' => $data->user->phone,
                'email' => $data->user->email,
                'designation' => @$data->user->designation->title,
                'department' => @$data->user->department->title,
                'avatar' => uploaded_asset($data->user->avatar_id),
            ];
        });
    }


    public function taskPriorityColor($priority)
    {
        switch ($priority) {
            case 29:
                return '0xff5B58FF';
                break;
            case 30:
                return '0xffFC990F';
                break;
            case 31:
                return '0xffE96161';
                break;
            default:
                return '0xff5B58FF';
                break;
        }
    }
    public function UserListCollection($employees)
    {
        return $employees->map(function ($data) {
            return [
                'id' => $data->id,
                'name' => $data->name,
                'phone' => $data->phone,
                'email' => $data->email,
                'designation' => @$data->designation->title,
                'department' => @$data->department->title,
                'avatar' => uploaded_asset($data->avatar_id),
            ];
        });
    }
    public function TasksCollection($tasks)
    {


        return $tasks->map(function ($data) {

            return [
                'id' => @$data->task->id,
                'title' => @$data->task->name,
                'date_range' => Carbon::parse($data->task->start_date)->format('d M') . '-' . Carbon::parse($data->task->end_date)->format('d M'),
                'start_date' => $data->task->start_date,
                'end_date' => $data->task->end_date,
                'priority' => $data->task->priority,
                'status' => $data->task->status,
                'is_creator' => $data->task->created_by == Auth::id() ? true : false,
                'users_count' => listCountStatus($data->task->members->count()),
                'actual_count' => $data->task->members->count(),
                'members' => $this->MemberListCollection($data->task->members_short),
                'color' => $this->taskPriorityColor($data->task->priority),
            ];
        });
    }
    public function TaskListCollectionWithPagination($tasks)
    {
        // dd($tasks);
        return [
            'tasks' => $tasks->map(function ($data) {
                return [
                    'id' => @$data->task->id,
                    'title' => @$data->task->name,
                    'date_range' => Carbon::parse($data->task->start_date)->format('d M') . '-' . Carbon::parse($data->task->end_date)->format('d M'),
                    'start_date' => $data->task->start_date,
                    'end_date' => $data->task->end_date,
                    'priority' => $data->task->priority,
                    'status' => $data->task->status,
                    'is_creator' => $data->task->created_by == Auth::id() ? true : false,
                    'users_count' => listCountStatus($data->task->members->count()),
                    'actual_count' => $data->task->members->count(),

                    'members' => $this->MemberListCollection($data->task->members_short),
                    'color' => $this->taskPriorityColor($data->task->priority),
                ];
            }),
            'pagination' => [
                'total' => $tasks->total(),
                'count' => $tasks->count(),
                'per_page' => $tasks->perPage(),
                'current_page' => $tasks->currentPage(),
                'total_pages' => $tasks->lastPage(),
            ],
        ];
    }
    //Tasks Api
    public function AppTaskDetails($request, $task_id)
    {
        try {
            $task = Task::find($task_id);
            if ($task) {

                $priorities = [
                    [
                        'title' => _trans('common.' . $task->priorityStatus->name),
                        'id' => $task->priorityStatus->id,
                    ],
                ];

                $collection = [
                    'id' => $task->id,
                    'title' => $task->name,
                    'db_start_date' => $task->start_date,
                    'start_date' => Carbon::parse($task->start_date)->format('d M Y'),
                    'db_end_date' => $task->end_date,
                    'end_date' => Carbon::parse($task->end_date)->format('d M Y'),
                    'date' => Carbon::parse($task->end_date)->format('d M'),
                    'supervisor' => @$task->createdBy->name,

                    'users_count' => listCountStatus($task->members->count()),
                    'actual_count' => $task->members->count(),

                    'discussions_count' => $task->discussions->count(),
                    'files_count' => $task->files->count(),
                    'progress' => intval($task->progress),
                    'is_completed' => $task->status_id == 27 ? true : false,
                    'priority_id' => $task->priorityStatus->id,
                    'priority' => _trans('common.' . $task->priorityStatus->name),
                    'status_id' => $task->status->id,
                    'status' => _trans('common.' . $task->status->name),
                    'color' => $this->taskPriorityColor($task->priority),
                    'description' => $task->description,

                    'files' => $task->files->map(function ($file) {
                        return [
                            'id' => $file->id,
                            'attachment' => uploaded_asset($file->attachment),
                            'file_logo' => file_logo(pathinfo(uploaded_asset($file->attachment), PATHINFO_EXTENSION)),
                            'title' => Str::replace(' ', '-', $file->subject) . '.' . pathinfo(uploaded_asset($file->attachment), PATHINFO_EXTENSION),
                            'type' => getFileType(pathinfo(uploaded_asset($file->attachment), PATHINFO_EXTENSION)),
                            'created_by' => $file->user->name,
                        ];
                    }),
                    'discussion' => $task->discussions->map(function ($discussion) {
                        return [
                            'id' => $discussion->id,
                            'subject' => $discussion->subject,
                            'description' => $discussion->description,
                            'created_by' => $discussion->user->name,
                            'avatar' => @uploaded_asset($discussion->user->avatar_id),
                            'created_at' => Carbon::parse($discussion->created_at)->diffForHumans(),
                            'already_liked' => $discussion->likes->contains('user_id', Auth::id()),
                            'likes_count' => $discussion->likes->count(),
                            'own_created' => $discussion->user_id == auth()->user()->id ? true : false,
                            'file' => $discussion->file_id ? @uploaded_asset($discussion->file_id) : '',
                        ];
                    }),
                ];
                $data = [
                    'members' => $this->MemberListCollection($task->members),
                    'priorities' => $priorities,
                    'task_details' => $collection,
                ];
                return $this->responseWithSuccess('Task Details', $data, 200);
            } else {
                return $this->responseWithError('Task not found', [], 404);
            }
        } catch (\Throwable $th) {
            return $this->responseWithError('Something went wrong', [], 500);
        }
    }
    public function AppTaskCreate()
    {
        try {
            $projects = Project::whereIn('status_id', [24, 25, 26, 27, 28])->select('id', 'name', 'status_id')->latest()->get();
            $users = User::where('status_id', 1)
                ->whereNotIn('id', [1, auth()->user()->id])
                ->select('id', 'name', 'avatar_id', 'email', 'phone', 'designation_id')
                ->get();

            $projects_collection = $projects->map(function ($data) {
                return [
                    'id' => $data->id,
                    'name' => $data->name,
                    'status' => $data->status->name,
                    'status_id' => $data->status_id,
                ];
            });
            $users_collection = $users->map(function ($data) {
                return [
                    'id' => $data->id,
                    'name' => $data->name,
                    'avatar' => uploaded_asset($data->avatar_id),
                    'email' => $data->email,
                    'phone' => $data->phone,
                    'designation' => $data->designation->title,
                ];
            });

            $priorities = [
                [
                    'title' => _trans('tasks.Urgent'),
                    'id' => 29,
                ],
                [
                    'title' => _trans('tasks.High'),
                    'id' => 30,
                ],
                [
                    'title' => _trans('tasks.Medium'),
                    'id' => 31,
                ],
            ];
            $data = [
                'projects' => $projects_collection,

                'members' => $this->UserListCollection($users),
                // 'members' => $users_collection,
                'priorities' => $priorities,
            ];
            return $this->responseWithSuccess('App Task Create', $data, 200);
        } catch (\Exception $e) {
        }
    }
    public function AppTaskStore($request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'priority' => 'required',
            'status' => 'required',
            'members' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->responseWithError(_trans('validation.Validation field required'), $validator->errors(), 422);
        }
        try {
            $task = new Task();
            $task->name = $request->name;
            $task->date = $request->start_date;
            $task->start_date = $request->start_date;
            $task->end_date = $request->end_date;
            $task->priority = $request->priority;
            $task->project_id = $request->project;
            $task->description = $request->description;
            $task->status_id = $request->status;
            $task->created_by = auth()->user()->id;
            $task->save();
            
            $members = $request->members;
            $members = explode(',', $members);
            
            // Remove duplicate entries and filter out the authenticated user ID
            $members = array_diff(array_unique($members), [auth()->user()->id]);
            
            // Creator member
            $creator_member = new TaskMember();
            $creator_member->task_id = $task->id;
            $creator_member->user_id = auth()->user()->id;
            $creator_member->added_by = auth()->user()->id;
            $creator_member->save();
            
            foreach ($members as $member) {
                $task_member = new TaskMember();
                $task_member->task_id = $task->id;
                $task_member->user_id = $member;
                $task_member->added_by = auth()->user()->id;
                $task_member->save();
            }
            

            return $this->responseWithSuccess('App Task Store', $task, 200);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), 422);
        }
    }
    public function AppTaskUpdate($request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'priority' => 'required',
            'status' => 'required',
            'progress' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->responseWithError(_trans('validation.Validation field required'), $validator->errors(), 422);
        }
        try {
            $task = Task::find($request->id);
            $task->priority = $request->priority;
            $task->status_id = $request->status;
            $task->progress = $request->progress;
            $task->save();


            return $this->responseWithSuccess('App Task Store', $task, 200);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), 422);
        }
    }
    public function AppTaskStoreComment($request)
    {
        $validator = Validator::make($request->all(), [
            'task_id' => 'required',
            'subject' => 'required',
            'comment' => 'required',
            'file' => 'mimes:jpeg,jpg,png,pdf,doc,docx,xls,xlsx,txt|max:2048',
        ]);
        if ($validator->fails()) {
            return $this->responseWithError(_trans('validation.Validation field required'), $validator->errors(), 422);
        }
        try {
            $task = new TaskDiscussion();
            $task->company_id = getCurrentCompany();
            $task->subject = $request->subject;
            $task->description = $request->comment;
            $task->task_id = $request->task_id;
            $task->user_id = auth()->user()->id;
            $task->save();
            if ($request->hasFile('file')) {
                $filePath = $this->uploadImage($request->file, 'uploads/employeeDocuments');
                $task->file_id = $filePath ? $filePath->id : null;
                $task->save();
            }
            return $this->responseWithSuccess('Task Discussion Store', $task, 200);
        } catch (\Throwable $th) {
            dd($th);
            return $this->responseWithError($th->getMessage(), 422);
        }
    }
    public function AppTaskDeleteComment($id)
    {

        try {
            $task = TaskDiscussion::find($id);
            $task->delete();
            return $this->responseWithSuccess('Task Discussion Deleted', [], 200);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), 422);
        }
    }
    public function AppTaskUpdateComment($request)
    {
        $validator = Validator::make($request->all(), [
            'comment_id' => 'required',
            // 'subject' => 'required',
            'comment' => 'required',
            'file' => 'mimes:jpeg,jpg,png,pdf,doc,docx,xls,xlsx,txt|max:2048',
        ]);
        if ($validator->fails()) {
            return $this->responseWithError(_trans('validation.Validation field required'), $validator->errors(), 422);
        }
        try {
            $task = TaskDiscussion::find($request->comment_id);
            $task->company_id = getCurrentCompany();
            $task->subject = $request->subject;
            $task->description = $request->comment;
            $task->user_id = auth()->user()->id;
            $task->save();
            if ($request->hasFile('file')) {
                $filePath = $this->uploadImage($request->file, 'uploads/employeeDocuments');
                $task->file_id = $filePath ? $filePath->id : null;
                $task->save();
            }
            return $this->responseWithSuccess('Task Discussion Updated', $task, 200);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), 422);
        }
    }
    public function AppTaskLikeFeedback($request)
    {
        $validator = Validator::make($request->all(), [
            'discussion_id' => 'required',
            'type' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->responseWithError(_trans('validation.Validation field required'), $validator->errors(), 422);
        }
        try {
            $discussion = DiscussionLike::where('discussion_id', $request->discussion_id)->where('user_id', auth()->user()->id)->first();
            if ($discussion) {
                return $this->responseWithError('You have already liked this discussion', [], 422);
            }
            $task = new DiscussionLike();
            $task->discussion_id = $request->discussion_id;
            $task->user_id = auth()->user()->id;
            if ($request->type == 'like') {
                $task->like = 1;
            } else {
                $task->dislike = 1;
            }
            $task->save();
            return $this->responseWithSuccess('Discussion Reaction Store', $task, 200);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), 422);
        }
    }
    public function GetAppTaskScreen($request)
    {
        $in_progress = 0;
        $completed = 0;
        $due = 0;
        $task_members = TaskMember::with('task')->where('user_id', auth()->user()->id)
            ->get();
        foreach ($task_members as $key => $task_member) {
            if ($task_member->task->status_id == 26) {
                $in_progress++;
            }
            if ($task_member->task->status_id == 27) {
                $completed++;
            }
            if ($task_member->task->end_date < date('Y-m-d')) {
                $due++;
            }
        }
        $staticstics = [
            [
                'count' => $task_members->count(),
                'text' => _trans('tasks.Total Task'),
                'status' => "0",
                'image' => static_asset('assets/app/tasks/1.png'),

            ],
            [
                'count' => $in_progress,
                'text' => _trans('tasks.Task in Progress'),
                'status' => "26",
                'image' => static_asset('assets/app/tasks/2.png'),
            ],

            [
                'count' => $completed,
                'text' => _trans('tasks.Completed Task'),
                'status' => "27",
                'image' => static_asset('assets/app/tasks/3.png'),
            ],

            [
                'count' => $due,
                'text' => _trans('tasks.Due Task'),
                'status' => 'due',
                'image' => static_asset('assets/app/tasks/4.png'),
            ],
        ];

        $user_tasks1 = TaskMember::join('tasks', 'tasks.id', 'task_members.task_id')->with('task', 'task.members')->where('user_id', auth()->user()->id)
            ->when(isset(request()->priority), function ($query) {
                return $query->where('tasks.priority', request()->priority);
            })
            ->when(isset(request()->keyword), function ($query) {
                return $query->where('name', 'LIKE', '%' . request()->keyword . '%');
            })->where('tasks.status_id', 26)
            ->take(5)
            ->get();

        $user_tasks2 = TaskMember::join('tasks', 'tasks.id', 'task_members.task_id')->with('task', 'task.members')->where('user_id', auth()->user()->id)
            ->when(isset(request()->priority), function ($query) {
                return $query->where('tasks.priority', request()->priority);
            })
            ->when(isset(request()->keyword), function ($query) {
                return $query->where('name', 'LIKE', '%' . request()->keyword . '%');
            })->where('tasks.status_id', 27)
            ->take(5)
            ->get();

        $tasks_in_collection = $this->TasksCollection($user_tasks1);
        $complete_tasks_collection = $this->TasksCollection($user_tasks2);


        $collection = [
            'staticstics' => $staticstics,
            // 'priorities' => $priorities,
            'tasks_in_collection' => $tasks_in_collection,
            'complete_tasks_collection' => $complete_tasks_collection,
        ];

        return $this->responseWithSuccess('App Project Screen', $collection, 200);
    }
    public function AppTaskChangeStatus($request)
    {
        $validator = Validator::make($request->all(), [
            'task_id' => 'required',
            'type' => 'required',
            'change_to' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->responseWithError(_trans('validation.Validation field required'), $validator->errors(), 422);
        }
        try {
            $task = Task::find($request->task_id);
            if ($request->type == '1') {
                $task->status_id = $request->change_to;
            } else {
                $task->priority = $request->change_to;
            }
            $task->save();
            return $this->responseWithSuccess('Task Status Changed', [], 200);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), 422);
        }
    }
    public function AppTaskDelete($request)
    {
        $validator = Validator::make($request->all(), [
            'task_id' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->responseWithError(_trans('validation.Validation field required'), $validator->errors(), 422);
        }
        try {
            $task = Task::where('id', $request->task_id)->where('created_by', auth()->user()->id)->first();
            if ($task) {
                $task->delete();
                return $this->responseWithSuccess('Task Deleted', [], 200);
            } else {
                return $this->responseWithSuccess('This not your tasks', [], 200);
            }
            return $this->responseWithSuccess('Task Not Found', [], 200);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), 422);
        }
    }
    public function AppTaskList($request)
    {
        //updated code from hrp api 2.0
        // Check if 'status' is not set or empty, set a default value.
        if (!isset($request->status) || $request->status == "") {
            $request['status'] = 26;
        }
        // Initialize the base query for TaskMember with required joins and relationships.
        $taskMemberQuery = TaskMember::join('tasks', 'tasks.id', 'task_members.task_id')
            ->with('task', 'task.members')
            ->where('user_id', auth()->user()->id);

        // Additional conditions based on the 'status' parameter.
        if ($request->status == 'due') {
            // Tasks that are overdue.
            $taskMemberQuery->where('tasks.end_date', '<', date('Y-m-d'));
        } else {
            // Tasks with other statuses.
            $taskMemberQuery->when(isset(request()->priority), function ($query) {
                return $query->where('tasks.priority', request()->priority);
            })
                ->when(isset(request()->keyword), function ($query) {
                    return $query->where('name', 'LIKE', '%' . request()->keyword . '%');
                })
                ->where('tasks.status_id', $request->status);
        }
        // Order the tasks and paginate the results.
        $task_lists = $taskMemberQuery->orderBy('tasks.id', 'DESC')->paginate(10);
        // Prepare the task list collection with pagination.
        $task_list_collection = $this->TaskListCollectionWithPagination($task_lists);
        // Initialize counters for task status statistics.
        $in_progress = 0;
        $completed = 0;
        $due = 0;
        // Retrieve all task members for the user.
        $task_members = TaskMember::with('task')->where('user_id', auth()->user()->id)->get();
        // Calculate task status statistics.
        foreach ($task_members as $key => $task_member) {
            if ($task_member->task->status_id == 26) {
                $in_progress++;
            }
            if ($task_member->task->status_id == 27) {
                $completed++;
            }
            if ($task_member->task->end_date < date('Y-m-d')) {
                $due++;
            }
        }
        // Define task status statistics.
        $statistics = [
            [
                'count' => $task_members->count(),
                'text' => _trans('tasks.Total Task'),
                'status' => "0",
                'image' => static_asset('assets/app/tasks/1.png'),
            ],
            [
                'count' => $in_progress,
                'text' => _trans('tasks.Task in Progress'),
                'status' => "26",
                'image' => static_asset('assets/app/tasks/2.png'),
            ],
            [
                'count' => $completed,
                'text' => _trans('tasks.Completed Task'),
                'status' => "27",
                'image' => static_asset('assets/app/tasks/3.png'),
            ],
            [
                'count' => $due,
                'text' => _trans('tasks.Due Task'),
                'status' => 'due',
                'image' => static_asset('assets/app/tasks/4.png'),
            ],
        ];
        // Prepare the final response data.
        $collection = [
            'statistics' => $statistics,
            // 'priorities' => $priorities,
            'all_tasks_collection' => $task_list_collection
        ];

        // Return a success response with the data.
        return $this->responseWithSuccess('Task Lists', $collection, 200);
        //updated code from hrp api 2.0 end





        // $validator = Validator::make($request->all(), [
        //     'status' => 'required',
        // ]);
        // if ($validator->fails()) {
        //     return $this->responseWithError(_trans('validation.Validation field required'), $validator->errors(), 422);
        // }
        // $tasks = TaskMember::join('tasks', 'tasks.id', 'task_members.task_id')
        //     ->with('task', 'task.members')
        //     ->where('user_id', auth()->user()->id)
        //     ->get();

        // if ($request->status == 26) {
        //     $task_lists = TaskMember::join('tasks', 'tasks.id', 'task_members.task_id')
        //         ->with('task', 'task.members')->where('user_id', auth()->user()->id)
        //         ->when(isset(request()->priority), function ($query) {
        //             return $query->where('tasks.priority', request()->priority);
        //         })
        //         ->when(isset(request()->keyword), function ($query) {
        //             return $query->where('name', 'LIKE', '%' . request()->keyword . '%');
        //         })
        //         ->where('tasks.status_id', 26)
        //         ->orderBy('tasks.id', 'DESC')
        //         ->paginate(10);

        // } elseif ($request->status == 24) {
        //     $task_lists = TaskMember::join('tasks', 'tasks.id', 'task_members.task_id')->with('task', 'task.members')->where('user_id', auth()->user()->id)
        //         ->when(isset(request()->priority), function ($query) {
        //             return $query->where('tasks.priority', request()->priority);
        //         })
        //         ->when(isset(request()->keyword), function ($query) {
        //             return $query->where('name', 'LIKE', '%' . request()->keyword . '%');
        //         })
        //         ->where('tasks.status_id', 24)
        //         ->orderBy('tasks.id', 'DESC')
        //         ->paginate(10);
        // } elseif ($request->status == 25) {
        //     $task_lists = TaskMember::join('tasks', 'tasks.id', 'task_members.task_id')->with('task', 'task.members')->where('user_id', auth()->user()->id)
        //         ->when(isset(request()->priority), function ($query) {
        //             return $query->where('tasks.priority', request()->priority);
        //         })
        //         ->when(isset(request()->keyword), function ($query) {
        //             return $query->where('name', 'LIKE', '%' . request()->keyword . '%');
        //         })
        //         ->where('tasks.status_id', 25)
        //         ->orderBy('tasks.id', 'DESC')
        //         ->paginate(10);
        // }
        // elseif ($request->status == 27) {
        //     $task_lists = TaskMember::join('tasks', 'tasks.id', 'task_members.task_id')->with('task', 'task.members')->where('user_id', auth()->user()->id)
        //         ->when(isset(request()->priority), function ($query) {
        //             return $query->where('tasks.priority', request()->priority);
        //         })
        //         ->when(isset(request()->keyword), function ($query) {
        //             return $query->where('name', 'LIKE', '%' . request()->keyword . '%');
        //         })
        //         ->where('tasks.status_id', 27)
        //         ->orderBy('tasks.id', 'DESC')
        //         ->paginate(10);
        // } elseif ($request->status == 28) {
        //     $task_lists = TaskMember::join('tasks', 'tasks.id', 'task_members.task_id')->with('task', 'task.members')->where('user_id', auth()->user()->id)
        //         ->when(isset(request()->priority), function ($query) {
        //             return $query->where('tasks.priority', request()->priority);
        //         })
        //         ->when(isset(request()->keyword), function ($query) {
        //             return $query->where('name', 'LIKE', '%' . request()->keyword . '%');
        //         })
        //         ->where('tasks.status_id', 28)
        //         ->orderBy('tasks.id', 'DESC')
        //         ->paginate(10);
        // }elseif ($request->status == 'due') {
        //     $task_lists = TaskMember::join('tasks', 'tasks.id', 'task_members.task_id')->with('task', 'task.members')->where('user_id', auth()->user()->id)
        //         ->when(isset(request()->priority), function ($query) {
        //             return $query->where('tasks.priority', request()->priority);
        //         })
        //         ->when(isset(request()->keyword), function ($query) {
        //             return $query->where('name', 'LIKE', '%' . request()->keyword . '%');
        //         })->where('tasks.end_date', '<', date('Y-m-d'))
        //         ->orderBy('tasks.id', 'DESC')
        //         ->paginate(10);
        // } else {
        //     $task_lists = TaskMember::join('tasks', 'tasks.id', 'task_members.task_id')->with('task', 'task.members')->where('user_id', auth()->user()->id)
        //         ->when(isset(request()->priority), function ($query) {
        //             return $query->where('tasks.priority', request()->priority);
        //         })
        //         ->when(isset(request()->keyword), function ($query) {
        //             return $query->where('name', 'LIKE', '%' . request()->keyword . '%');
        //         })
        //         ->orderBy('tasks.id', 'DESC')
        //         ->withCount()
        //         ->paginate(10);
        // }

        // $task_list_collection = $this->TaskListCollectionWithPagination($task_lists);

        // $priorities = [
        //     [
        //         'title' => _trans('tasks.High'),
        //         'id' => 30,
        //         'count' => $tasks->where('priority', 30)->count(),
        //         'color' => $this->taskPriorityColor(30),
        //     ],
        //     [
        //         'title' => _trans('tasks.Medium'),
        //         'id' => 31,
        //         'count' => $tasks->where('priority', 31)->count(),
        //         'color' => $this->taskPriorityColor(31),
        //     ],
        //     [
        //         'title' => _trans('tasks.Urgent'),
        //         'id' => 29,
        //         'count' => $tasks->where('priority', 29)->count(),
        //         'color' => $this->taskPriorityColor(29),
        //     ],
        // ];

        // $collection = [
        //     'priorities' => $priorities,
        //     'task_list_collection' => $task_list_collection,
        // ];

        // return $this->responseWithSuccess('Task Lists', $collection, 200);
    }
}
