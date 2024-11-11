<footer class="bg-footer-dark ">
    <div class="container">
        <div class="footer-section pt-100">
            <div class="row">
                <div class="col-md-4">
                    <div class="logo-content">
                        <div class="footer-section-logo">
                            @include('frontend.partials.white_logo')
                        </div>
                        <div class="company-details">
                            <p>{{ @base_settings('company_description') }}</p>
                        </div>
                    </div>

                </div>
                <div class="col-md-4 ">
                    <div class="middle-section">
                        <p class="mb-20 text-white">{{ _trans('frontend.Helpful Links') }}</p>
                        <ul class="helplink-list">
                            @foreach (menu(2) as $key => $value)
                                <li>
                                    @if ($value->all_content_id != null && @$value->page)
                                        <a
                                            href="{{ route('front.content', $value->page->slug) }}">{{ $value->name }}</a>
                                    @else
                                        <a href=" {{ @$value->url }} ">{{ @$value->name }}</a>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="apps">
                        @if (@base_settings('android_url'))
                            <a href="{{ @base_settings('android_url') }}">
                                <img src="{{ url('assets/images/playstore.png') }}" alt="">
                            </a>
                        @endif
                        @if (@base_settings('ios_url'))
                            <a href="{{ @base_settings('ios_url') }}">
                                <img src="{{ url('assets/images/appstore.png') }}" alt="">
                            </a>
                        @endif
                    </div>

                </div>
            </div>
            <div class="copyright">
                <p>{{ _trans('frontend.Copyright') }} {{ '@' . date('Y') }} <a
                        href="{{ url('/') }}">{{ @base_settings('company_name') }}.</a>
                    {{ _trans('frontend.All Rights Reserved.') }}</p>
            </div>
        </div>
    </div>

</footer>

<script src="{{ global_asset('backend/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ global_asset('backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ global_asset('/') }}public/frontend/js/__header.js"></script>
<script src="{{ global_asset('/') }}public/frontend/js/__accordion.js"></script>
<script src="{{ global_asset('/') }}public/frontend/js/__scrollUp.js"></script>
<script src="{{ global_asset('/') }}public/frontend/js/__sideMenuLang.js"></script>
<script src="{{ global_asset('/') }}public/frontend/js/__mobileViewNavMenu.js"></script>


<div id="fb-root"></div>
<!-- Your customer chat code -->



@include('backend.partials.message')
<script src="{{ global_asset('js/toastr.js') }}"></script>
{!! Toastr::message() !!}

</body>



</html>
