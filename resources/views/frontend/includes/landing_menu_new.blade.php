<div class="login-dashboard-header responsive-homepage-menubar list-style-none p-0 h-70">
    <div class="container">
        <div class="navigation-wrap bg-light start-header start-style">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <nav class="navbar navbar-expand-lg navbar-light">
                            <div class="landing_logo">
                                @include('backend.auth.hrm_logo')
                            </div>

                            <button class="navbar-toggler navbar-toggler-custom collapsed" type="button"
                                data-toggle="collapse" data-target="#navbar" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-controls="navbar">
                                <span class="navbar-toggler-icon"></span>
                            </button>

                            <div class="collapse navbar-collapse" id="navbar">
                                <ul class="navbar-nav navbar-nav-list ml-auto py-4 py-md-0 align-items-center">

                                    @if (config('app.mood') === 'Saas' && isModuleActive('Saas'))
                                        @foreach (menu(1) as $key => $value)
                                            <li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4">
                                                @if ($value->all_content_id != null && @$value->page)
                                                    <a class="nav-link" href="{{ route('front.content', $value->page->slug) }}">{{ $value->name }}</a>
                                                @else
                                                <a class="nav-link nav-link-new" href=" {{ @$value->url }} ">{{ @$value->name }}</a>
                                                @endif
                                            </li>
                                        @endforeach
                                        @if (auth()->check())
                                            <li class="loginbtn nav-item pl-4 pl-md-0 ml-0 ml-md-4">
                                                <a class="login-panel-btn gradient-btn "
                                                    href="{{ route('admin.dashboard') }}">{{ _trans('common.Dashboard') }}</a>
                                            </li>
                                        @else
                                            <li class="nav-link pl-4 pl-md-0 ml-0 ml-md-4">
                                                <a class="login-panel-btn gradient-blue-btn" href="{{ url('sign-in') }}">{{ _trans('common.Sign In') }}</a>
                                            </li>
                                        @endif
                                    @endif

                                </ul>
                            </div>
                            <div class="flex-end d-none">
                                <div class="pl-4 pl-md-0 ml-0 ml-md-4 circle-button-blue">
                                    <a href="" target="_blank" class=" ">
                                        <span>
                                            <span class="btn-icon"><i class="fa fa-life-ring"></i></span>
                                        </span>
                                    </a>
                                </div>
                            </div>
                            <div class="pl-4 pl-md-0 ml-0 ml-md-4 circle-button-green d-none">
                                <a href="" target="_blank" class=" ">
                                    <span>
                                        <span class="btn-icon text-white"><i class="fas fa-cart-arrow-down"></i></span>
                                    </span>
                                </a>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

