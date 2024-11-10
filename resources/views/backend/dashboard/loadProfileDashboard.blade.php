@if (@$data['dashboardMenus']['today'])
    <div class="row" id="profile_statistic">
        <div class="col-xl-12">
            <h5 class="fm-poppins text-dark mb-3">{{ _trans('common.Today') }}</h5>
            <div class=" row gutters-10">
                @foreach ($data['dashboardMenus']['today'] as $key => $item)
                    <div class="col-xl-3 col-sm-6 col-12 ">

                        <div class="card-admin">
                            <div class="card-header spacing-header">
                                <div
                                    class="media flex-wrap justify-content-center justify-content-md-between justify-content-lg-between justify-content-xl-between">
                                    <div class="media-aside align-self-start">
                                        <div class="b-avatar badge-light-primary rounded-circle">
                                            <span class="b-avatar-custom">
                                                <img src="{{ url($item['image']) }}" alt="">
                                            </span>
                                            <!---->
                                        </div>
                                    </div>
                                    <div class="text-center text-md-right text-lg-right text-xl-right text-align-center">
                                        <h4 class="font-weight-bolder mb-1 fs-30" id="totalSaleAmount">
                                            {{ $item['number'] }}</h4>
                                        <p class="card-text font-small-3 mb-0"> {{ @$item['title'] }} </p>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                @endforeach
            </div>

            <h5 class="fm-poppins text-dark mb-3">{{ _trans('dashboard.Current Month') }} </h5>
            <div class="row gutters-10">
                @php
                    $assets = [['#e90d622b', 'images/late.png'], ['#65e5012b', 'images/logout.png'], ['#00dde52b', 'images/time.png'], ['#c010102e', 'images/absent.png'], ['#28c76f2b', 'images/building.png'], ['#7300e92b', 'images/badge.png']];

                @endphp
                @foreach ($data['dashboardMenus']['current_month'] as $key => $item)
                    <div class="col-xl-3 col-sm-6 col-12 ">
                        <div class="card-admin">
                            <div class="card-header spacing-header">
                                <div
                                    class="media flex-wrap justify-content-center justify-content-md-between justify-content-lg-between justify-content-xl-between">
                                    <div class="media-aside align-self-start">
                                        <div class="b-avatar badge-light-primary rounded-circle">
                                            <span class="b-avatar-custom">
                                                <img src="{{ url($item['image']) }}" alt="">
                                            </span>
                                            <!---->
                                        </div>
                                    </div>
                                    <div class="text-center text-md-right text-lg-right text-xl-right text-align-center">
                                        <h4 class="font-weight-bolder mb-1 fs-30" id="totalSaleAmount">
                                            {{ $item['number'] }} </h4>
                                        <p class="card-text font-small-3 mb-0"> {{ @$item['title'] }} </p>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif
