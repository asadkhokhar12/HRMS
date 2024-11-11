<div class="login-dashboard-header responsive-homepage-menubar list-style-none">
    <div class="container">
        <div class="navigation-wrap bg-light start-header start-style">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <nav class="navbar navbar-expand-lg navbar-light">
                            @include('backend.auth.hrm_logo')

                            <button class="navbar-toggler navbar-toggler-custom collapsed" type="button"
                                data-toggle="collapse" data-target="#navbar" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-controls="navbar">
                                <span class="navbar-toggler-icon"></span>
                            </button>

                            <div class="collapse navbar-collapse" id="navbar">
                                <ul class="navbar-nav navbar-nav-list ml-auto py-4 py-md-0 align-items-center">
                                    @if (config('app.mood') === 'Saas' && isModuleActive('Saas'))
                                        @foreach (DB::table('all_contents')->where('status_id', 1)->get() as $key => $value)
                                            <li class="loginbtn pl-4 pl-md-0 ml-0 ml-md-4">
                                                <a
                                                    href="{{ route('front.content', $value->slug) }}">{{ $value->title }}</a>
                                            </li>
                                        @endforeach
                                        @if (auth()->check())
                                            <li class="loginbtn pl-4 pl-md-0 ml-0 ml-md-4">
                                                <a class="login-panel-btn gradient-btn"
                                                    href="{{ route('admin.dashboard') }}">{{ _trans('common.Dashboard') }}</a>
                                            </li>
                                        @else
                                            <li class="loginbtn pl-4 pl-md-0 ml-0 ml-md-4">
                                                <a href="{{ url('sign-in') }}">{{ _trans('common.Sign In') }}</a>
                                            </li>
                                        @endif
                                    @endif
                                </ul>
                            </div>

                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
