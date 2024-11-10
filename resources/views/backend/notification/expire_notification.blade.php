@extends('backend.layouts.app')
@section('title', @$data['title'])
@section('content')
    {!! breadcrumb([
        'title' => @$data['title'],
        route('admin.dashboard') => _trans('common.Dashboard'),
        '#' => @$data['title'],
    ]) !!}
    <div class="table-content table-basic">
        <div class="card">
            <div class="card-body">
                <!-- toolbar table end -->
                <!--  table start -->
                <div class="table-responsive  min-height-500">
                    <table class="table table-bordered {{ @$data['class'] }}" id="table">
                        <thead class="thead">
                            <tr>
                                <th class="sorting_desc">{{ _trans('common.SL') }}</th>
                                <th class="sorting_desc">{{ _trans('common.Message') }}</th>
                                <th class="sorting_desc">{{ _trans('common.Employee') }}</th> 
                                <th class="sorting_desc">{{ _trans('common.Created at') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data['notifications'] as $key=>$notification)
                                <tr class="border-bottom" data-notification_row_id="{{ $notification->id }}">
                                    <td>{{ $key+1 }}</td>
                                    <td width="50%">
                                        <a href="{{  route('notification-read', [$notification->id, $notification->employee_id]) }}" class="d-flex  align-items-center text-decoration-none text-secondary unread_notification_from_all">
                                            <div class="notification-content">
                                                <h6 class="notification-title font-weight-bold">{{ @$notification->title }}</h6>
                                                <small class="muted">{!! @$notification->description !!}</small>
                                            </div>
                                        </a>
                                    </td>
                                    <td>
                                        <div class="notification-time text-left">
                                            {{ @$notification->user->name }} <br>
                                            @if(@$notification->user->designation->title != "" &&  @$notification->user->department->title != "")
                                            [{{ @$notification->user->designation->title }} , {{ @$notification->user->department->title }} ]
                                           @endif 

                                        </div>
                                    </td>
                               
                                    <td>
                                        <div class="notification-time text-left">
                                            {{ @$notification->created_at->diffForHumans() }}
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tbody>
                                    <tr class="odd">
                                        <td valign="top" colspan="4" class="dataTables_empty">
                                            <div class="no-data-found-wrapper text-center ">
                                                <img src="{{ asset('assets/images/empty.png') }}" alt="" class="mb-primary empty_table" width="200">
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!--  table end -->
            </div>
        </div>
    </div>
@endsection
@section('script')
    @include('backend.partials.table_js')
@endsection
