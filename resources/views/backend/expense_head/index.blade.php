@extends('backend.layouts.app')
@section('title', 'Expense Head')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">{{ _trans('common.Expense Head') }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a
                                    href="{{ route('admin.dashboard') }}">{{ _trans('common.Dashboard') }}</a></li>
                            <li class="breadcrumb-item active">{{ _trans('common.Expense Head') }}</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <table id="table" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>{{ _trans('common.SL') }}</th>
                                    <th>{{ _trans('common.Name') }}</th>
                                    <th>{{ _trans('common.Date') }}</th>
                                    <th>{{ _trans('common.Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data['expense_head'] as $key => $item)
                                    <tr>
                                        <td>{{ __(@$key + 1) }}</td>
                                        <td>{{ __(Str::limit(@$item->name, 25, '...')) }}</td>
                                        <td>{{ main_date_format(@$item->created_at) }}</td>
                                        <td>
                                            <div class="flex-nowrap">
                                                <div class="dropdown">
                                                    <button class="btn btn-white dropdown-toggle align-text-top"
                                                        data-boundary="viewport"
                                                        data-toggle="dropdown">{{ _trans('common.Actions') }}</button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <button class="dropdown-item"
                                                            onclick="ViewNotice('{{ $item->id }}',`/dashboard/expense-head/`)">
                                                            {{ _trans('common.View') }}
                                                        </button>
                                                        <a class="dropdown-item"
                                                            href="{{ route('expense-head.edit', $item->id) }}">
                                                            {{ _trans('common.Edit') }}
                                                        </a>
                                                        <button class="dropdown-item"
                                                            onclick="__globalDelete('{{ $item->id }}',`dashboard/expense-heads/delete/`);">
                                                            {{ _trans('common.Delete') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@push('js')
    @include('backend.partials.datatable')
@endpush

@section('scripts')
    <script src="{{ global_asset('backend/js/_payment.js') }}"></script>
@endsection
