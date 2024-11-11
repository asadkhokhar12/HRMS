<div class="login-dashboard-header responsive-homepage-menubar list-style-none p-0 h-70">
    <div class="container">
        <div class="navigation-wrap bg-light start-header start-style">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <nav class="navbar navbar-expand-md navbar-light">
                            <div class="landing_logo">
                                <img src="{{ url('assets/logo-dark.png') }}" alt="">
                            </div>
                            {{-- Button --}}
                            <button class="navbar-toggler navbar-toggler-custom collapsed" type="button"
                                data-toggle="collapse" data-target="#navbar" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-controls="navbar">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="navbar">
                                <ul class="navbar-nav navbar-nav-list ml-auto py-4 py-md-0 align-items-center">
                                    <li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4">
                                        <a class="nav-link" href="{{ url('/') }}">{{__('Home') }}</a>
                                    </li>
                                    <li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4">
                                        <a class="nav-link" href="{{ url('/features') }}">{{__('Features') }}</a>
                                    </li>
                                    <li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4">
                                        <a class="nav-link" href="#price">{{__('Pricing') }}</a>
                                    </li>
                                    <li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4 d-none">
                                        <a class="nav-link" href="">{{__('All Products') }}</a>
                                    </li>
                                    <li class="loginbtn pl-4 pl-md-0 ml-0 ml-md-4">
                                        <a class="login-panel-btn gradient-red-btn" target="_blank"
                                            href="#">{{__('Buy Now') }}</a>
                                    </li>
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
