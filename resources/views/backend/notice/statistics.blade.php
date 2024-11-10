@extends('backend.layouts.app')
@section('title', @$data['title'])
@section('content')
    {!! breadcrumb([
        'title' => @$data['title'],
        route('admin.dashboard') => _trans('common.Dashboard'),
        '#' => @$data['title'],
    ]) !!}

    <style>
        .nav-link .active{
            border-bottom: 2px solid #6dd2fd;
        }
    </style>
    <div class="table-content table-basic">
        <div class="card">

            <div class="card-body">
                
                            <!-- Nav tabs -->
            <ul class="nav nav-tabs">
                <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#home">{{ _trans('common.Seen') }}</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#menu1">{{ _trans('common.Unseen') }}</a>
                </li>
            </ul>
            
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane container active" id="home">
                          <!-- toolbar table start -->
                <div class="table-toolbar d-flex flex-wrap gap-2 flex-xl-row justify-content-center justify-content-xxl-between align-content-center pb-3 mt-20">
                <div class="align-self-center">
                    <div class="d-flex flex-wrap gap-2  flex-lg-row justify-content-center align-content-center">
                        <!-- show per page -->
                        <div class="align-self-center">
                            <label>
                                <span class="mr-8">{{ _trans('common.Show') }}</span>
                                <select class="form-select d-inline-block" id="entries" onchange="noticeTable()">
                                    <option selected value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                                <span class="ml-8">{{ _trans('common.Entries') }}</span>
                            </label>
                        </div>

                        <div class="align-self-center d-flex flex-wrap gap-2">
                        </div>


                      

                        {{-- department --}}

                        <!-- search -->
                        <div class="align-self-center">
                            <div class="search-box d-flex">
                                <input class="form-control" placeholder="{{ _trans('common.Search') }}" name="search"
                                    onkeyup="noticeTable()" autocomplete="off">
                                <span class="icon"><i class="fa-solid fa-magnifying-glass"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- export -->
                @include('backend.partials.buttons')
            </div>
            <div class="table-responsive  min-height-500">
                <table class="table table-bordered" id="table">
                    <thead class="thead">
                        <tr>
                            @if (@$data['fields'])
                                @foreach (@$data['fields'] as $field)
                                    <th class="sorting_desc">{{ $field }}</th>
                                @endforeach
                                    <th class="sorting_desc">{{ _trans('common.Read At')}}</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (@$data['statistics']['seen'] as $seen)
                        {{-- @dd($seen) --}}
                            <tr>
                                <td>{{ $seen['id'] }}</td>
                                <td>{{ $seen['name'] }}</td>
                                <td>
                                    @if ($seen['avatar'])
                                        <img data-toggle="tooltip" data-placement="top" title="{{ $seen['name'] }}" src="{{ $seen['avatar'] }}" class="staff-profile-image-small" >
                                     @endif
                                </td>
                                <td>{{ $seen['department'] }}</td>
                                <td>{{ $seen['designation'] }}</td>
                                <td>{{ $seen['read_at'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
            </div>
            <!--  table end -->
                </div>
                <div class="tab-pane container fade" id="menu1">
                                  <!-- toolbar table start -->
                <div class="table-toolbar d-flex flex-wrap gap-2 flex-xl-row justify-content-center justify-content-xxl-between align-content-center pb-3 mt-20">
                    <div class="align-self-center">
                        <div class="d-flex flex-wrap gap-2  flex-lg-row justify-content-center align-content-center">
                            <!-- show per page -->
                            <div class="align-self-center">
                                <label>
                                    <span class="mr-8">{{ _trans('common.Show') }}</span>
                                    <select class="form-select d-inline-block" id="entries" onchange="noticeTable()">
                                        <option selected value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                    <span class="ml-8">{{ _trans('common.Entries') }}</span>
                                </label>
                            </div>
    
                            <div class="align-self-center d-flex flex-wrap gap-2">
                            </div>
    
    
                          
    
                            {{-- department --}}
    
                            <!-- search -->
                            <div class="align-self-center">
                                <div class="search-box d-flex">
                                    <input class="form-control" placeholder="{{ _trans('common.Search') }}" name="search"
                                        onkeyup="noticeTable()" autocomplete="off">
                                    <span class="icon"><i class="fa-solid fa-magnifying-glass"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- export -->
                    @include('backend.partials.buttons')
                </div>
                <div class="table-responsive  min-height-500">
                    <table class="table table-bordered" id="table">
                        <thead class="thead">
                            <tr>
                                @if (@$data['fields'])
                                    @foreach (@$data['fields'] as $field)
                                        <th class="sorting_desc">{{ $field }}</th>
                                    @endforeach
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (@$data['statistics']['unseen'] as $seen)
                            {{-- @dd($seen) --}}
                                <tr>
                                    <td>{{ $seen['id'] }}</td>
                                    <td>{{ $seen['name'] }}</td>
                                    <td>
                                        @if ($seen['avatar'])
                                            <img data-toggle="tooltip" data-placement="top" title="{{ $seen['name'] }}" src="{{ $seen['avatar'] }}" class="staff-profile-image-small" >
                                        @endif
                                        
                                    </td>
                                    <td>{{ $seen['department'] }}</td>
                                    <td>{{ $seen['designation'] }}</td>
                                    {{-- <td>{{ $seen->updated_at }}</td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                </div>
                </div>
            </div>
          
            </div>
        </div>
    </div>
@endsection
@section('script')
    @include('backend.partials.table_js')
@endsection
