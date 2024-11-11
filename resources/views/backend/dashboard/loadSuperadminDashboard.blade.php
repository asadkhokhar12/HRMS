<div class="">
    <div class="col-lg-12 __superadmin_dashboard_box card-admin ">
        <div class="card-header-admin">
            <h4 class="card-title-admin">
                {{ _trans('dashboard.Statistics') }}
            </h4>
            <p class="card-text font-small-2 mr-25 mb-0"> {{ _trans('dashboard.Updated 1 month ago') }} </p>
        </div>
        <div class="card-body new-card-body">
            <div class="row">
                <div class="col-sm-4 col-xl-2 mb-2 mb-xl-0">
                    <div class="media">
                        <div class="media-aside mr-4 align-self-start">
                            <div class="b-avatar badge-light-primary rounded-circle">
                                <span class="b-avatar-custom">
                                    <img src="{{ url('images/location.png') }}" alt="">
                                </span>
                                <!---->
                            </div>
                        </div>
                        <div class="media-body my-auto">
                            <h4 class="font-weight-bolder mb-0"> {{ _trans('dashboard.230k') }} </h4>
                            <p class="card-text font-small-3 mb-0"> {{ _trans('dashboard.Total Companies') }} </p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-xl-2 mb-2 mb-xl-0">
                    <div class="media">
                        <div class="media-aside mr-4 align-self-start">
                            <div class="b-avatar badge-light-info rounded-circle">
                                <span class="b-avatar-custom">
                                    <img src="{{ url('images/salary.png') }}" alt="">
                                </span>
                                <!---->
                            </div>
                        </div>
                        <div class="media-body my-auto">
                            <h4 class="font-weight-bolder mb-0"> {{ _trans('dashboard.230k') }} </h4>
                            <p class="card-text font-small-3 mb-0"> {{ _trans('dashboard.Total Income') }} </p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-xl-2 mb-2 mb-xl-0">
                    <div class="media">
                        <div class="media-aside mr-4 align-self-start">
                            <div class="b-avatar badge-light-danger rounded-circle">
                                <span class="b-avatar-custom">
                                    <img src="{{ url('images/people.png') }}" alt="">
                                </span>
                                <!---->
                            </div>
                        </div>
                        <div class="media-body my-auto">
                            <h4 class="font-weight-bolder mb-0"> {{ _trans('dashboard.230k') }} </h4>
                            <p class="card-text font-small-3 mb-0"> {{ _trans('dashboard.Total Users') }} </p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-xl-2 mb-2 mb-xl-0">
                    <div class="media">
                        <div class="media-aside mr-4 align-self-start">
                            <div class="b-avatar badge-light-success rounded-circle">
                                <span class="b-avatar-custom">
                                    <img src="{{ url('images/building.png') }}" alt="">
                                </span>
                                <!---->
                            </div>
                        </div>
                        <div class="media-body my-auto">
                            <h4 class="font-weight-bolder mb-0"> {{ _trans('dashboard.230k') }} </h4>
                            <p class="card-text font-small-3 mb-0"> {{ _trans('dashboard.Visits') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-xl-2 mb-2 mb-xl-0">
                    <div class="media">
                        <div class="media-aside mr-4 align-self-start">
                            <div class="b-avatar badge-light-purple rounded-circle">
                                <span class="b-avatar-custom">
                                    <img src="{{ url('images/add.png') }}" alt="">
                                </span>
                                <!---->
                            </div>
                        </div>
                        <div class="media-body my-auto">
                            <h4 class="font-weight-bolder mb-0"> {{ _trans('dashboard.230k') }} </h4>
                            <p class="card-text font-small-3 mb-0"> {{ _trans('dashboard.New Registration') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-xl-2 mb-2 mb-xl-0">
                    <div class="media">
                        <div class="media-aside mr-4 align-self-start">
                            <div class="b-avatar badge-light-pink rounded-circle">
                                <span class="b-avatar-custom">
                                    <img src="{{ url('images/comment.png') }}" alt="">
                                </span>
                                <!---->
                            </div>
                        </div>
                        <div class="media-body my-auto">
                            <h4 class="font-weight-bolder mb-0"> {{ _trans('dashboard.230k') }} </h4>
                            <p class="card-text font-small-3 mb-0"> {{ _trans('dashboard.New Message') }}</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card-admin">
                        <div class="card-header">
                            <h6 class="card-title-admin">
                                {{ _trans('dashboard.Users') }}
                            </h6>
                            <h4 class="font-weight-bolder mb-1"> {{ _trans('dashboard.230k') }} </h4>
                            <div id="barChart">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card-admin">
                        <div class="card-header">
                            <h6 class="card-title-admin">
                                {{ _trans('dashboard.Profits') }}
                            </h6>
                            <h4 class="font-weight-bolder mb-1"> {{ _trans('dashboard.230k') }} </h4>
                            <div id="lineChart">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card-admin">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-lg-7">
                                    <h4 class="card-title-admin">
                                        {{ _trans('dashboard.Earnings') }}
                                    </h4>
                                    <p class="card-text font-small-2 mr-25 mb-0"> {{ _trans('dashboard.This Month') }}
                                    </p>
                                    <h5 class="mb-3"> {{ _trans('dashboard.$4055.56') }} </h5>
                                    <p class="card-text text-muted font-small-2">
                                        <span class="font-weight-bolder">{{ _trans('dashboard.68.2%') }}</span>
                                        <span> {{ _trans('dashboard.more earnings than last month.') }}</span>
                                    </p>
                                </div>
                                <div class="col-lg-5">
                                    <div id="pieChart"></div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>



        </div>
        <div class="col-lg-8">
            <div class="card-admin">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="revenue-border-right">
                            <div class="card-header">
                                <h4 class="card-title-admin">
                                    {{ _trans('dashboard.Revenue Report') }}
                                </h4>
                                <div id="revenueChart"></div>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card-admin-header">
                            <div class="card-body">
                                <div class="dropdown text-center mb-4">
                                    <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        {{ _trans('dashboard.2022') }}
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="#">{{ _trans('dashboard.2021') }}</a>
                                        <a class="dropdown-item" href="#">{{ _trans('dashboard.2020') }}</a>
                                        <a class="dropdown-item" href="#">{{ _trans('dashboard.2019') }}</a>
                                    </div>
                                </div>
                                <h4 class="text-center"> {{ _trans('dashboard.$25,852') }} </h4>
                                <div class="d-flex justify-content-center">
                                    <span class="font-weight-bolder mr-1">{{ _trans('dashboard.Budget:') }}</span>
                                    <span>{{ _trans('dashboard.56,800') }}</span>
                                </div>
                            </div>
                            <div id="dashDotted">

                            </div>
                            <div class="text-center">
                                <div class="btn btn-primary btn-sm ">
                                    {{ _trans('dashboard.Increase Budget') }}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- start row -->
<div class="row">
    <div class="col-lg-4">
        <div class="card user-card">
            <div class="card-title">
                <h4 class="pt-4 pl-3">{{ _trans('dashboard.Recent Users') }}</h4>
            </div>
            <div class="card-body">
                <div class="card-details">
                    <div class="row">
                        <div class="col-lg-8 mb-2">
                            <div class="d-flex user-details">
                                <div class="sl-circle">
                                    <div class="user-week">
                                        <p>{{ _trans('dashboard.Sun') }}</p>

                                    </div>
                                    <div class="user-date">
                                        <h6>{{ _trans('dashboard.18') }}</h6>

                                    </div>
                                </div>
                                <div class="card-user-info ml-4">
                                    <div class="card-user-name">
                                        <h6>{{ _trans('dashboard.John Doe') }}</h6>

                                    </div>
                                    <div class="user-timing  d-flex align-items-center">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <p class="ml-2">{{ _trans('dashboard.house 148 road 13b banani') }}</p>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="user-status">
                                <ul>
                                    <li class="li-danger">
                                        <div class="d-flex icon-align align-items-center">
                                            <i class="fas fa-circle mr-2"></i>
                                            {{ _trans('common.Inactive') }}
                                        </div>
                                    </li>

                                </ul>
                                <div class="user-timing d-flex align-items-center">
                                    <i class="fas fa-clock"></i>
                                    <p class="ml-2 ">{{ _trans('dashboard.08 Am - 12 Pm') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="d-flex user-details">
                                <div class="sl-circle green">
                                    <div class="user-week week-green">
                                        <p>{{ _trans('dashboard.Sun') }}</p>

                                    </div>
                                    <div class="user-date date-green">
                                        <h6>{{ _trans('dashboard.18') }}</h6>

                                    </div>
                                </div>
                                <div class="card-user-info ml-4">
                                    <div class="card-user-name">
                                        <h6>{{ _trans('dashboard.John Doe') }}</h6>

                                    </div>
                                    <div class="user-timing  d-flex align-items-center">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <p class="ml-2">{{ _trans('dashboard.house 148 road 13b banani') }}</p>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="user-status">
                                <ul>
                                    <li class="li-success">
                                        <div class="d-flex icon-align align-items-center">
                                            <i class="fas fa-circle mr-2"></i>
                                            {{ _trans('common.Active') }}
                                        </div>
                                    </li>

                                </ul>
                                <div class="user-timing d-flex align-items-center">
                                    <i class="fas fa-clock"></i>
                                    <p class="ml-2 ">{{ _trans('dashboard.08 Am - 12 Pm') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card user-card">
            <div class="card-title">
                <h4 class="pt-4 pl-3">{{ _trans('dashboard.Recent Users') }}</h4>
            </div>
            <div class="card-body">
                <div class="card-details">
                    <div class="row">
                        <div class="col-lg-8 mb-2">
                            <div class="d-flex user-details">
                                <div class="sl-circle">
                                    <div class="user-week">
                                        <p>{{ _trans('dashboard.Sun') }}</p>

                                    </div>
                                    <div class="user-date">
                                        <h6>{{ _trans('dashboard.18') }}</h6>

                                    </div>
                                </div>
                                <div class="card-user-info ml-4">
                                    <div class="card-user-name">
                                        <h6>{{ _trans('dashboard.John Doe') }}</h6>

                                    </div>
                                    <div class="user-timing  d-flex align-items-center">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <p class="ml-2">{{ _trans('dashboard.house 148 road 13b banani') }}</p>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="user-status">
                                <ul>
                                    <li class="li-danger">
                                        <div class="d-flex icon-align align-items-center">
                                            <i class="fas fa-circle mr-2"></i>
                                            {{ _trans('common.Inactive') }}
                                        </div>
                                    </li>

                                </ul>
                                <div class="user-timing d-flex align-items-center">
                                    <i class="fas fa-clock"></i>
                                    <p class="ml-2 ">{{ _trans('dashboard.08 Am - 12 Pm') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="d-flex user-details">
                                <div class="sl-circle green">
                                    <div class="user-week week-green">
                                        <p>{{ _trans('dashboard.Sun') }}</p>

                                    </div>
                                    <div class="user-date date-green">
                                        <h6>{{ _trans('dashboard.18') }}</h6>

                                    </div>
                                </div>
                                <div class="card-user-info ml-4">
                                    <div class="card-user-name">
                                        <h6>{{ _trans('dashboard.John Doe') }}</h6>

                                    </div>
                                    <div class="user-timing  d-flex align-items-center">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <p class="ml-2">{{ _trans('dashboard.house 148 road 13b banani') }}</p>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="user-status">
                                <ul>
                                    <li class="li-success">
                                        <div class="d-flex icon-align align-items-center">
                                            <i class="fas fa-circle mr-2"></i>
                                            {{ _trans('dashboard.Active') }}
                                        </div>
                                    </li>

                                </ul>
                                <div class="user-timing d-flex align-items-center">
                                    <i class="fas fa-clock"></i>
                                    <p class="ml-2 ">{{ _trans('dashboard.08 Am - 12 Pm') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card user-card">
            <div class="card-title">
                <h4 class="pt-4 pl-3">{{ _trans('dashboard.Recent Users') }}</h4>
            </div>
            <div class="card-body">
                <div class="card-details">
                    <div class="row">
                        <div class="col-lg-8 mb-2">
                            <div class="d-flex user-details">
                                <div class="sl-circle">
                                    <div class="user-week">
                                        <p>{{ _trans('dashboard.Sun') }}</p>

                                    </div>
                                    <div class="user-date">
                                        <h6>{{ _trans('dashboard.18') }}</h6>

                                    </div>
                                </div>
                                <div class="card-user-info ml-4">
                                    <div class="card-user-name">
                                        <h6>{{ _trans('dashboard.John Doe') }}</h6>

                                    </div>
                                    <div class="user-timing  d-flex align-items-center">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <p class="ml-2">{{ _trans('dashboard.house 148 road 13b banani') }}</p>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="user-status">
                                <ul>
                                    <li class="li-danger">
                                        <div class="d-flex icon-align align-items-center">
                                            <i class="fas fa-circle mr-2"></i>
                                            {{ _trans('common.Inactive') }}
                                        </div>
                                    </li>

                                </ul>
                                <div class="user-timing d-flex align-items-center">
                                    <i class="fas fa-clock"></i>
                                    <p class="ml-2 ">{{ _trans('dashboard.08 Am - 12 Pm') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="d-flex user-details">
                                <div class="sl-circle green">
                                    <div class="user-week week-green">
                                        <p>{{ _trans('dashboard.Sun') }}</p>

                                    </div>
                                    <div class="user-date date-green">
                                        <h6>{{ _trans('dashboard.18') }}</h6>

                                    </div>
                                </div>
                                <div class="card-user-info ml-4">
                                    <div class="card-user-name">
                                        <h6>{{ _trans('dashboard.John Doe') }}</h6>

                                    </div>
                                    <div class="user-timing  d-flex align-items-center">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <p class="ml-2">{{ _trans('dashboard.house 148 road 13b banani') }}</p>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="user-status">
                                <ul>
                                    <li class="li-success">
                                        <div class="d-flex icon-align align-items-center">
                                            <i class="fas fa-circle mr-2"></i>
                                            {{ _trans('dashboard.Active') }}
                                        </div>
                                    </li>

                                </ul>
                                <div class="user-timing d-flex align-items-center">
                                    <i class="fas fa-clock"></i>
                                    <p class="ml-2 ">{{ _trans('dashboard.08 Am - 12 Pm') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
<!-- end row -->
<script src="{{ global_asset('/') }}public/frontend/js/__apexChart.js"></script>
<script>
    // Bar Chart
    var optionBar = {
        series: [{
            data: [40, 50, 60, 30, 70]
        }],
        chart: {
            toolbar: {
                show: false,
            },
            type: "bar",
            height: 150
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '20%',
                distributed: true,
                startingShape: "rounded",
                endingShape: "rounded",
                colors: {
                    backgroundBarColors: ["#eee"],
                    backgroundBarOpacity: 1,
                    backgroundBarRadius: 7
                }
            }
        },
        dataLabels: {
            enabled: false
        },
        legend: {
            show: false,
        },
        grid: {
            yaxis: {
                lines: {
                    show: false
                }
            }
        },
        xaxis: {
            show: false,
            labels: {
                show: false,
            },
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false,
            },

        },
        yaxis: {
            show: false,
            labels: {
                show: false,
            },
            axisBorder: {
                show: false,
            },
            axisTicks: {
                show: false,
            },
            crosshairs: {
                show: false,
            },
            tooltip: {
                enabled: false,
            },

        },
        colors: [

            "#fad388"

        ],

    };
    var chart = new ApexCharts(document.querySelector("#barChart"), optionBar);
    chart.render();
    // end
    // Line Chart
    var optionBar = {
        series: [{
            data: [40, 50, 60, 30, 70]
        }],
        stroke: {
            width: 4
        },
        chart: {
            toolbar: {
                show: false,
            },
            type: "line",
            height: 150
        },

        dataLabels: {
            enabled: false
        },
        legend: {
            show: false,
        },

        grid: {
            yaxis: {
                lines: {
                    show: false
                }
            }
        },
        xaxis: {
            show: false,
            labels: {
                show: false,
            },
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false,
            },

        },
        yaxis: {
            show: false,
            labels: {
                show: false,
            },
            axisBorder: {
                show: false,
            },
            axisTicks: {
                show: false,
            },
            crosshairs: {
                show: false,
            },
            tooltip: {
                enabled: false,
            },

        },
        colors: [

            "#4CD6EB"

        ],
        markers: {
            size: 5
        }

    };
    var chart = new ApexCharts(document.querySelector("#lineChart"), optionBar);
    chart.render();
    // end

    var option = {
        series: [{

            data: [44, 55, 57, 56, 61, 58, 63, 60, 66]
        }],
        chart: {
            toolbar: {
                show: false,
            },
            type: "bar",
            height: 350
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '20%',
                distributed: true,
                startingShape: "rounded",
                endingShape: "rounded",
            }
        },
        dataLabels: {
            enabled: false
        },
        legend: {
            show: false,
            position: 'top'
        },
        grid: {
            yaxis: {
                lines: {
                    show: false
                }
            }
        },
        xaxis: {
            categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
            labels: {
                show: true,
            },
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false,
            },
        },
        yaxis: {
            show: true,
            labels: {
                show: true,
            },
            axisBorder: {
                show: false,
            },
            axisTicks: {
                show: false,
            },
            crosshairs: {
                show: false,
            },
            tooltip: {
                enabled: false,
            },

        },
        colors: [

            "#fad388"

        ],

    };
    var chart = new ApexCharts(document.querySelector("#revenueChart"), option);
    chart.render();

    // start
    var optionBar = {
        series: [{
                data: [45, 52, 38, 24, 33, 26, 21, 20, 6, 8, 15, 10]
            },
            {
                data: [35, 41, 62, 42, 13, 18, 29, 37, 36, 51, 32, 35]
            }
        ],
        stroke: {
            width: 4
        },
        chart: {
            toolbar: {
                show: false,
            },
            type: "line",
            height: 150
        },

        dataLabels: {
            enabled: false
        },
        legend: {
            show: false,
        },

        grid: {
            yaxis: {
                lines: {
                    show: false
                }
            }
        },
        xaxis: {
            show: false,
            labels: {
                show: false,
            },
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false,
            },

        },
        yaxis: {
            show: false,
            labels: {
                show: false,
            },
            axisBorder: {
                show: false,
            },
            axisTicks: {
                show: false,
            },
            crosshairs: {
                show: false,
            },
            tooltip: {
                enabled: false,
            },

        }

    };
    var chart = new ApexCharts(document.querySelector("#dashDotted"), optionBar);
    chart.render();
    // end 
    // end
    // start
    var options = {
        series: [44, 55, 41, 60],
        labels: ["Transport", "Shopping", "Energy use", "Food"],
        dataLabels: {
            enabled: false
        },
        chart: {
            type: 'donut',
            height: 150
        },
        plotOptions: {
            pie: {
                donut: {
                    labels: {
                        show: true,
                        total: {
                            show: true,
                            fontSize: '12px',
                            color: '#000',
                            formatter: () => '55'
                        }
                    },
                    value: {
                        show: true,
                        fontSize: '10px',
                        fontFamily: 'Helvetica, Arial, sans-serif',
                        fontWeight: 400,
                        color: undefined,
                        offsetY: 16,
                        formatter: function(val) {
                            return val
                        }
                    },
                }
            }
        },
        tooltip: {
            style: {
                fontSize: '10px',
                fontFamily: undefined
            }
        },
        legend: {
            show: false,
        },
        fill: {
            colors: ['#28c76f', '#28c76f66', '#28c76f33']
        }
    };

    var chart = new ApexCharts(document.querySelector("#pieChart"), options);
    chart.render();
    // end
</script>
