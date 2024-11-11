@extends('backend.layouts.app')
@section('title', @$data['title'])
@section('content')
    {!! breadcrumb([
        'title' => @$data['title'],
        route('admin.dashboard') => _trans('common.Dashboard'),
        '#' => @$data['title'],
    ]) !!}
    <div class="table-content table-basic ">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-10">
                        <b>{{ _trans('conference.Title') }}</b> : {{ $data['conference']->name }} <span
                            class="badge badge-{{ $data['conference']->status->class }}">{{ $data['conference']->status->name }}</span>
                    </div>
                    <div class="col-lg-2">
                        @php
                            //current time between start and end time
                            $current_time = date('Y-m-d H:i:s');
                            $start_time = $data['conference']->start_at;
                            $end_time = $data['conference']->end_at;
                            $current_time = strtotime($current_time);
                            $start_time = strtotime($start_time);
                            $end_time = strtotime($end_time);
                            // $link=route('conference.join',$data['conference']->id);
                            $link = 'https://meet.jit.si/' . $data['conference']->room_id . '-' . $data['conference']->id . '-' . time() . '#config.startWithAudioMuted=true&config.startWithVideoMuted=true';
                            if ($current_time > $start_time && $current_time < $end_time) {
                                echo '<a target="_blank" href="' . $link . '" class="btn btn-primary">Join</a>';
                            } elseif ($current_time < $start_time) {
                                echo '<span class="badge badge-warning">Upcoming</span>';
                            } elseif ($current_time > $end_time) {
                                echo '<span class="badge badge-danger">Ended</span>';
                            }
                        @endphp

                    </div>
                    <div class="col-lg-12 mt-10">
                        <b>{{ _trans('conference.Start and End Time') }}</b> :
                        {{ showTimeFromTimeStamp($data['conference']->start_at) }} -
                        {{ showTimeFromTimeStamp($data['conference']->end_at) }} At
                        {{ showDate(separateDateAndTime(@$data['conference']->start_at, 'date')) }}
                    </div>
                    <div class="col-lg-12 mt-10 d-flex mb-10">
                        <div class="col-lg-2">
                            <b>{{ _trans('conference.Members') }}</b> :
                        </div>
                        <div class="col-lg-6">
                            <ul class="list-group">
                                @foreach ($data['conference']->members as $key => $member)
                                    <li class="mt-2 list-group-item">
                                        <img src="{{ uploaded_asset($member->user->avatar_id) }}" class="rounded"
                                            width="50px" height="auto" alt="{{ $member->user->name }}">
                                        {{ $member->user->name }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-lg-1">
                        </div>
                        {{-- <div class="col-lg-2">
                            <b>{{_trans('conference.Status')}}</b> : <span class="badge badge-{{$data['conference']->status->class}}">{{$data['conference']->status->name}}</span>
                           </div> --}}
                    </div>
                    <hr>
                    <div class="col-lg-12 mt-10">
                        <b>
                            {{ _trans('conference.Description') }}:
                        </b>

                        {!! $data['conference']->description !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="get_user_url" value="{{ route('user.getUser') }}">
@endsection
@section('script')
    <script src="{{ global_asset('backend/js/pages/__award.js') }}"></script>
    <script src="{{ global_asset('frontend/assets/js/iziToast.js') }}"></script>
    <script src="{{ global_asset('backend/js/image_preview.js') }}"></script>
    <script src="{{ global_asset('ckeditor/ckeditor.js') }}"></script>
    <script src="{{ global_asset('ckeditor/config.js') }}"></script>
    <script src="{{ global_asset('ckeditor/styles.js') }}"></script>
    <script src="{{ global_asset('ckeditor/build-config.js') }}"></script>
    <script src="{{ global_asset('backend/js/global_ckeditor.js') }}"></script>
@endsection
