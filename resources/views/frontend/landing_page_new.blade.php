<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Theme style -->
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="{{ global_asset('frontend/css/frontend.css') }}">
    <link rel="stylesheet" href="{{ global_asset('/') }}public/frontend/assets/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="{{ global_asset('/') }}public/frontend/assets/animate.min.css">
    <!-- plugins css -->
    <link rel="stylesheet" href="{{ global_asset('/') }}public/frontend/css/plugins.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- Responsive css -->
    <link rel="stylesheet" href="{{ global_asset('/') }}public/frontend/css/responsive.css">
    {{-- move to --}}
    <link rel="stylesheet" href="{{ global_asset('/') }}public/frontend/assets/css/header.css">


    @yield('style')
    <title>Landing Page</title>
</head>

<body>
    @include('frontend.includes.landing_menu_new')
    <div class="bg-for-landingpage">
        <div class="container">
            <div class="content-container">
                <div class="row mt-50">
                    <div class="col-lg-6 align-self-center">
                        <div class="banner-info">
                            <h4>Get Best Innovation Softwaret</h4>
                            <p>Integrated market before enterprise wide e-commerce. Competently actualize bleeding-edge
                                testing.</p>
                            <div class="d-flex gap-4 pt-40">
                                <div class="btn-playstore">
                                    <a href="#" class=" store-btn"> <img class="mr-2"
                                            src="{{ url('assets/images/playstorelogo.png') }}" alt="">
                                        Playstore</a>
                                </div>
                                <div class="btn-appstore">
                                    <a href="#" class="store-btn"><img class="mr-2"
                                            src="{{ url('assets/images/logoappstore.png') }}"
                                            alt="">Appstore</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="user-img">
                            <img src="{{ url('assets/images/user.png') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <div class="container">
        <section class="mt-5 mb-5 works-section">
            <div class="row">
                <div class="col-md-6">
                    <div class="about-img">
                        <img src="{{ url('assets/images/welcome-double-exposure-business-man-partner-handshake 1.png') }}"
                            alt="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="aboutus-info">
                        <div class="aboutus-keyword">
                            <p>One Goal, One Passion</p>
                        </div>
                        <div class="aboutus-title">
                            <h4>About Us</h4>
                        </div>
                        <div class="aboutus-content">
                            <p class="mb-15">Onesttech believes in painting the perfect picture of your idea while
                                maintaining industry
                                standards and following upcoming trends. It is a professional software development
                                company
                                managed by tech-heads, engineers who are highly qualified in creating and solving issues
                                of
                                all kinds. </p>
                            <p class="mb-15"> This software development company was established in Dhaka, Bangladesh
                                on September 1, 2017
                                and since then, it has developed a relentless focus on technical achievement both
                                nationally
                                and internationally.</p>
                            <p class="mb-0">
                                So, you can certainly bet the farm as our expertise uses every muscle to provide
                                dogmatic
                                solutions, that results in best user experience with us.
                            </p>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <section class="bg-for-landingpage sectionbg-color1">
        <div class="container">
            <div class="service-info">
                <div class="service-keyword">
                    <p>Find more creative ideas for your projects</p>
                </div>
                <div class="service-title">
                    <h4>Our Serivces</h4>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="card-transparent">
                            <div class="card-service-title">
                                <h5>Web Developement</h5>
                            </div>
                            <div class="card-service-content">
                                <p>Develop robust online applications to suit your business needs and cater to your
                                    clients faithfully.</p>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card-transparent">
                            <div class="card-service-title">
                                <h5>Web Developement</h5>
                            </div>
                            <div class="card-service-content">
                                <p>Develop robust online applications to suit your business needs and cater to your
                                    clients faithfully.</p>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card-transparent">
                            <div class="card-service-title">
                                <h5>Web Developement</h5>
                            </div>
                            <div class="card-service-content">
                                <p>Develop robust online applications to suit your business needs and cater to your
                                    clients faithfully.</p>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card-transparent">
                            <div class="card-service-title">
                                <h5>Web Developement</h5>
                            </div>
                            <div class="card-service-content">
                                <p>Develop robust online applications to suit your business needs and cater to your
                                    clients faithfully.</p>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card-transparent">
                            <div class="card-service-title">
                                <h5>Web Developement</h5>
                            </div>
                            <div class="card-service-content">
                                <p>Develop robust online applications to suit your business needs and cater to your
                                    clients faithfully.</p>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card-transparent">
                            <div class="card-service-title">
                                <h5>Web Developement</h5>
                            </div>
                            <div class="card-service-content">
                                <p>Develop robust online applications to suit your business needs and cater to your
                                    clients faithfully.</p>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>
    <section class=" mt-5 mb-5 ">
        <div class="container">
            <div class="portfolio-keyword">
                <p>What we have done so far</p>
            </div>
            <div class="portfolio-title">
                <h5>Our Portfolio</h5>
            </div>

            <div class="btns">
                <button type="button" data-menu="all">All</button>
                <button type="button" data-menu="finance">Finance </button>
                <button type="button" data-menu="enu">Energy & Utility</button>
                <button type="button" data-menu="education">education</button>
                <button type="button" data-menu="engineers">health</button>
                <button type="button" data-menu="media">media</button>
            </div>
            <div class="row">
                <div data-menu="finance" class="single col-lg-3 col-md-4 p-2 col-sm-6">
                    <div class="portfolio-card pb-15">
                        <div class="portfolio-img">
                            <img src="{{ url('assets/images/portfolio1.png') }}" alt="">
                        </div>
                        <div class="portfolio-content">
                            <h6>Web & Software Dev</h6>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                        </div>
                    </div>
                </div>
                <div data-menu="enu" class="single col-lg-3 col-md-4 p-2 col-sm-6">
                    <div class="portfolio-card pb-15">
                        <div class="portfolio-img">
                            <img src="{{ url('assets/images/portfolio2.png') }}" alt="">
                        </div>
                        <div class="portfolio-content">
                            <h6>Web & Software Dev</h6>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                        </div>
                    </div>
                </div>
                <div data-menu="health" class="single col-lg-3 col-md-4 p-2 col-sm-6">
                    <div class="portfolio-card pb-15">
                        <div class="portfolio-img">
                            <img src="{{ url('assets/images/portfolio3.png') }}" alt="">
                        </div>
                        <div class="portfolio-content">
                            <h6>Web & Software Dev</h6>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                        </div>
                    </div>
                </div>
                <div data-menu="enu" class="single col-lg-3 col-md-4 p-2 col-sm-6">
                    <div class="portfolio-card pb-15">
                        <div class="portfolio-img">
                            <img src="{{ url('assets/images/portfolio4.png') }}" alt="">
                        </div>
                        <div class="portfolio-content">
                            <h6>Web & Software Dev</h6>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                        </div>
                    </div>
                </div>
                <div data-menu="finance" class="single col-lg-3 col-md-4 p-2 col-sm-6">
                    <div class="portfolio-card pb-15">
                        <div class="portfolio-img">
                            <img src="{{ url('assets/images/portfolio5.png') }}" alt="">
                        </div>
                        <div class="portfolio-content">
                            <h6>Web & Software Dev</h6>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                        </div>
                    </div>
                </div>
                <div data-menu="health" class="single col-lg-3 col-md-4 p-2 col-sm-6">
                    <div class="portfolio-card pb-15">
                        <div class="portfolio-img">
                            <img src="{{ url('assets/images/portfolio6.png') }}" alt="">
                        </div>
                        <div class="portfolio-content">
                            <h6>Web & Software Dev</h6>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                        </div>
                    </div>
                </div>
                <div data-menu="enu" class="single col-lg-3 col-md-4 p-2 col-sm-6">
                    <div class="portfolio-card pb-15">
                        <div class="portfolio-img">
                            <img src="{{ url('assets/images/portfolio7.png') }}" alt="">
                        </div>
                        <div class="portfolio-content">
                            <h6>Web & Software Dev</h6>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                        </div>
                    </div>
                </div>
                <div data-menu="education" class="single col-lg-3 col-md-4 p-2 col-sm-6">
                    <div class="portfolio-card pb-15">
                        <div class="portfolio-img">
                            <img src="{{ url('assets/images/portfolio8.png') }}" alt="">
                        </div>
                        <div class="portfolio-content">
                            <h6>Web & Software Dev</h6>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                        </div>
                    </div>
                </div>
                <div data-menu="finance" class="single col-lg-3 col-md-4 p-2 col-sm-6">
                    <div class="portfolio-card pb-15">
                        <div class="portfolio-img">
                            <img src="{{ url('assets/images/portfolio2.png') }}" alt="">
                        </div>
                        <div class="portfolio-content">
                            <h6>Web & Software Dev</h6>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                        </div>
                    </div>
                </div>
                <div data-menu="education" class="single col-lg-3 col-md-4 p-2 col-sm-6">
                    <div class="portfolio-card pb-15">
                        <div class="portfolio-img">
                            <img src="{{ url('assets/images/portfolio4.png') }}" alt="">
                        </div>
                        <div class="portfolio-content">
                            <h6>Web & Software Dev</h6>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                        </div>
                    </div>
                </div>
                <div data-menu="media" class="single col-lg-3 col-md-4 p-2 col-sm-6">
                    <div class="portfolio-card pb-15">
                        <div class="portfolio-img">
                            <img src="{{ url('assets/images/portfolio5.png') }}" alt="">
                        </div>
                        <div class="portfolio-content">
                            <h6>Web & Software Dev</h6>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <section class=" mt-5 mb-5 ">
        <div class="container">
            <div class="portfolio-keyword">
                <p>What we have done so far</p>
            </div>
            <div class="portfolio-title">
                <h5>Our Portfolio</h5>
            </div>

            <div class="btns_management">
                <button type="button" data-menu="all_management">All</button>
                <button type="button" data-menu="management">Management </button>
                <button type="button" data-menu="team_leads">Team Leads</button>
                <button type="button" data-menu="managers">Manager</button>
                <button type="button" data-menu="hr">HR</button>
                <button type="button" data-menu="accounts">Accounts</button>
                <button type="button" data-menu="engineers">Engineers</button>

            </div>
            <div class="row g-0">
                <div data-menu="management" class="single_management col-lg-3 col-md-4 p-2 col-sm-6">
                    <div class="portfolio-card">
                        <div class="portfolio-bg-pink">
                            <div class="portfolio-img-management">
                                <img src="{{ url('assets/images/memeber1.png') }}" alt="">
                            </div>
                            <div class="text-center">
                                <span class="member-name bg-pink-member">Ahsan Ahmed</span>
                            </div>

                            <div class="member-designation">
                                <span>Software Engineer</span>
                            </div>
                            <div class="portfolio-content-management ">
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div data-menu="team_leads" class="single_management col-lg-3 col-md-4 p-2 col-sm-6">
                    <div class="portfolio-card">
                        <div class="portfolio-bg-blue">
                            <div class="portfolio-img-management">
                                <img src="{{ url('assets/images/member2.png') }}" alt="">
                            </div>
                            <div class="text-center">
                                <span class="member-name bg-blue-member">Jobbar Ali</span>

                            </div>
                            <div class="member-designation">
                                <span>Software Engineer</span>
                            </div>
                            <div class="portfolio-content-management ">
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div data-menu="engineers" class="single_management col-lg-3 col-md-4 p-2 col-sm-6">
                    <div class="portfolio-card">
                        <div class="portfolio-bg-pink">
                            <div class="portfolio-img-management">
                                <img src="{{ url('assets/images/member3.png') }}" alt="">
                            </div>
                            <div class="text-center">

                                <span class="member-name bg-pink-member">Johan Evan</span>
                            </div>
                            <div class="member-designation">
                                <span>Designer</span>
                            </div>
                            <div class="portfolio-content-management ">
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div data-menu="team_leads" class="single_management col-lg-3 col-md-4 p-2 col-sm-6">
                    <div class="portfolio-card">
                        <div class="portfolio-bg-blue">
                            <div class="portfolio-img-management">
                                <img src="{{ url('assets/images/member4.png') }}" alt="">
                            </div>
                            <div class="text-center">

                                <span class="member-name bg-blue-member">Akram Khan</span>
                            </div>
                            <div class="member-designation">
                                <span>Mechanical Engineer</span>
                            </div>
                            <div class="portfolio-content-management ">
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div data-menu="management" class="single_management col-lg-3 col-md-4 p-2 col-sm-6">
                    <div class="portfolio-card">
                        <div class="portfolio-bg-pink">
                            <div class="portfolio-img-management">
                                <img src="{{ url('assets/images/member5.png') }}" alt="">
                            </div>
                            <div class="text-center">

                                <span class="member-name bg-pink-member">Ahsan Ahmed</span>
                            </div>
                            <div class="member-designation">
                                <span>Software Engineer</span>
                            </div>
                            <div class="portfolio-content-management ">
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div data-menu="hr" class="single_management col-lg-3 col-md-4 p-2 col-sm-6">
                    <div class="portfolio-card">
                        <div class="portfolio-bg-blue">
                            <div class="portfolio-img-management">
                                <img src="{{ url('assets/images/member6.png') }}" alt="">
                            </div>
                            <div class="text-center">

                                <span class="member-name bg-blue-member">Jobbar Ali</span>
                            </div>
                            <div class="member-designation">
                                <span>Software Engineer</span>
                            </div>
                            <div class="portfolio-content-management ">
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div data-menu="team_leads" class="single_management col-lg-3 col-md-4 p-2 col-sm-6">
                    <div class="portfolio-card">
                        <div class="portfolio-bg-pink">
                            <div class="portfolio-img-management">
                                <img src="{{ url('assets/images/member7.png') }}" alt="">
                            </div>
                            <div class="text-center">

                                <span class="member-name bg-pink-member">Ahsan Ahmed</span>
                            </div>
                            <div class="member-designation">
                                <span>Software Engineer</span>
                            </div>
                            <div class="portfolio-content-management ">
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div data-menu="managers" class="single_management col-lg-3 col-md-4 p-2 col-sm-6">
                    <div class="portfolio-card">
                        <div class="portfolio-bg-blue">
                            <div class="portfolio-img-management">
                                <img src="{{ url('assets/images/member8.png') }}" alt="">
                            </div>
                            <div class="text-center">

                                <span class="member-name bg-blue-member">Jobbar Ali</span>
                            </div>
                            <div class="member-designation">
                                <span>Software Engineer</span>
                            </div>
                            <div class="portfolio-content-management ">
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div data-menu="management" class="single_management col-lg-3 col-md-4 p-2 col-sm-6">
                    <div class="portfolio-card">
                        <div class="portfolio-bg-blue">
                            <div class="portfolio-img-management">
                                <img src="{{ url('assets/images/member6.png') }}" alt="">
                            </div>
                            <div class="text-center">

                                <span class="member-name bg-blue-member">Jobbar Ali</span>
                            </div>
                            <div class="member-designation">
                                <span>Software Engineer</span>
                            </div>
                            <div class="portfolio-content-management ">
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div data-menu="managers" class="single_management col-lg-3 col-md-4 p-2 col-sm-6">
                    <div class="portfolio-card">
                        <div class="portfolio-bg-blue">
                            <div class="portfolio-img-management">
                                <img src="{{ url('assets/images/member4.png') }}" alt="">
                            </div>
                            <div class="text-center">

                                <span class="member-name bg-blue-member">Akram Khan</span>
                            </div>
                            <div class="member-designation">
                                <span>Mechanical Engineer</span>
                            </div>
                            <div class="portfolio-content-management ">
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div data-menu="accounts" class="single_management col-lg-3 col-md-4 p-2 col-sm-6">
                    <div class="portfolio-card">
                        <div class="portfolio-bg-pink">
                            <div class="portfolio-img-management">
                                <img src="{{ url('assets/images/member5.png') }}" alt="">
                            </div>
                            <div class="text-center">

                                <span class="member-name bg-pink-member">Ahsan Ahmed</span>
                            </div>
                            <div class="member-designation">
                                <span>Software Engineer</span>
                            </div>
                            <div class="portfolio-content-management ">
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div data-menu="hr" class="single_management col-lg-3 col-md-4 p-2 col-sm-6">
                    <div class="portfolio-card">
                        <div class="portfolio-bg-blue">
                            <div class="portfolio-img-management">
                                <img src="{{ url('assets/images/member2.png') }}" alt="">
                            </div>
                            <div class="text-center">

                                <span class="member-name bg-blue-member">Jobbar Ali</span>
                            </div>
                            <div class="member-designation">
                                <span>Software Engineer</span>
                            </div>
                            <div class="portfolio-content-management ">
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div data-menu="accounts" class="single_management col-lg-3 col-md-4 p-2 col-sm-6">
                    <div class="portfolio-card">
                        <div class="portfolio-bg-pink">
                            <div class="portfolio-img-management">
                                <img src="{{ url('assets/images/member5.png') }}" alt="">
                            </div>
                            <div class="text-center">

                                <span class="member-name bg-pink-member">Ahsan Ahmed</span>
                            </div>
                            <div class="member-designation">
                                <span>Software Engineer</span>
                            </div>
                            <div class="portfolio-content-management ">
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    @include('frontend.includes.footer_new')
</body>

</html>
