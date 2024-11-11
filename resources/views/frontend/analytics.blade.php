@extends('frontend.includes.master')
@section('title', @$data['title'])
@section('content')
    <div class="container new-main-content">
        <div class="text-center">
            <h1 class="analytics">{{ $data['title'] }}</h1>
        </div>
        <form action="{{ route('analytics') }}" method="get" onchange="submit()">
            <select class="form-select text-center form-control-lg mb-3" aria-label="" name="frequency">
                <option disabled>{{ _trans('common.Select Frequency') }}</option>
                <option value="daily" {{ $data['frequency'] == 'daily' ? 'selected' : '' }}>{{ _trans('common.Daily') }}
                </option>
                <option value="weekly" {{ $data['frequency'] == 'weekly' ? 'selected' : '' }}>{{ _trans('common.Weekly') }}
                </option>
                <option value="monthly" {{ $data['frequency'] == 'monthly' ? 'selected' : '' }}>{{ _trans('common.Monthly') }}
                </option>
                <option value="yearly" {{ $data['frequency'] == 'yearly' ? 'selected' : '' }}>{{ _trans('common.Yearly') }}
                </option>
            </select>
        </form>

        {{-- Vistor Data --}}
        <h3 class="text-center">{{ _trans('common.Visitors') }}</h3>
        <div class="container d-flex justify-align-around mb-5">
            <table class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>{{ _trans('common.#') }}</th>
                        <th>{{ _trans('common.Visitors') }}</th>
                        <th>{{ _trans('common.Sessions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 0;
                    @endphp
                    @foreach ($data['visitors'] as $visitors)
                        <tr>
                            <td>{{ ++$no }}</td>
                            <td>{{ $visitors['type'] }}</td>
                            <td>{{ $visitors['sessions'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


        {{-- Most Vistied Pages Rank --}}
        <h3 class="text-center">{{ _trans('common.Most Vistied Pages') }}</h3>
        <div class="container d-flex justify-align-around mb-5">
            <table class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>{{ _trans('common.#') }}</th>
                        <th>{{ _trans('common.URL') }}</th>
                        <th>{{ _trans('common.Page Title') }}</th>
                        <th>{{ _trans('common.Page Views') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 0;
                    @endphp
                    @foreach ($data['most_visited_pages'] as $mostVisited)
                        <tr>
                            <td>{{ ++$no }}</td>
                            <td>{{ $mostVisited['url'] }}</td>
                            <td>{{ $mostVisited['pageTitle'] }}</td>
                            <td>{{ $mostVisited['pageViews'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


        {{-- Page views --}}
        <h3 class="text-center">{{ _trans('common.Page Views and Visitors') }}</h3>
        <div class="container d-flex justify-align-around mb-5">
            <table class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>{{ _trans('common.#') }}</th>
                        <th>{{ _trans('common.Date') }}</th>
                        <th>{{ _trans('common.Visitors') }}</th>
                        <th>{{ _trans('common.Page Title') }}</th>
                        <th>{{ _trans('common.Page Views') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 0;
                    @endphp
                    @foreach ($data['pageviews'] as $pageviews)
                        <tr>
                            <td>{{ ++$no }}</td>
                            <td>{{ $pageviews['date'] }}</td>
                            <td>{{ $pageviews['visitors'] }}</td>
                            <td>{{ $pageviews['pageTitle'] }}</td>
                            <td>{{ $pageviews['pageViews'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


        {{-- Refferers --}}
        <h3 class="text-center">{{ _trans('common.Refferers') }}</h3>
        <div class="container d-flex justify-align-around mb-5">
            <table class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>{{ _trans('common.#') }}</th>
                        <th>{{ _trans('common.URL') }}</th>
                        <th>{{ _trans('common.Page Views') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 0;
                    @endphp
                    @foreach ($data['refferers'] as $refferers)
                        <tr>
                            <td>{{ ++$no }}</td>
                            <td>{{ $refferers['url'] }}</td>
                            <td>{{ $refferers['pageViews'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Country wise Data --}}
        <h3 class="text-center">{{ _trans('common.Country') }}</h3>
        <div class="container d-flex justify-align-around mb-5">
            <table class="table table-dark table-striped">
                <thead class="">
                    <tr>
                        <th>{{ _trans('common.#') }}</th>
                        <th>{{ _trans('common.Country') }}</th>
                        <th>{{ _trans('common.Sessions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 0;
                    @endphp
                    @foreach ($data['country'] as $country)
                        <tr>
                            <td>{{ ++$no }}</td>
                            <td>{{ $country['country'] }}</td>
                            <td>{{ $country['sessions'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Browser wise Data --}}
        <h3 class="text-center">{{ _trans('common.Browsers') }}</h3>
        <div class="container d-flex justify-align-around mb-5">
            <table class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>{{ _trans('common.#') }}</th>
                        <th>{{ _trans('common.Browsers') }}</th>
                        <th>{{ _trans('common.Sessions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 0;
                    @endphp
                    @foreach ($data['topbrowsers'] as $topbrowsers)
                        <tr>
                            <td>{{ ++$no }}</td>
                            <td>{{ $topbrowsers['browser'] }}</td>
                            <td>{{ $topbrowsers['sessions'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ global_asset('frontend/js/analytics.js') }}"></script>
@endsection
