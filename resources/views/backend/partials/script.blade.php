    <!-- jQuery -->
    <script src="{{ global_asset('vendors/') }}/jquery/jquery-3.6.0.min.js"></script>
    <!--  Bootstrap 5 -->
    <script src="{{ global_asset('vendors/') }}/bootstrap/js/popper.min.js"></script>
    <script src="{{ global_asset('vendors/') }}/bootstrap/js/bootstrap.min.js"></script>
    <!-- RTL -->
    <script src="{{ global_asset('vendors/') }}/rtlcss/js/semantic.min.js"></script>
    <!-- Metis Menu -->
    <script src="{{ global_asset('vendors/') }}/metis-menu/js/metis-menu.min.js"></script>
    <!-- date ranger -->
    <script src="{{ global_asset('vendors/') }}/daterangepicker/js/moment.min.js"></script>
    <script src="{{ global_asset('vendors/') }}/daterangepicker/js/daterangepicker.min.js"></script>
    <!-- Swwet alert -->
    <script src="{{ global_asset('vendors/') }}/sweet-alert/js/sweetalert2@11.min.js"></script>
    <script src="{{ global_asset('vendors/') }}/select2/js/select2.min.js"></script>
    {{-- Js --}}
    <script src="{{ global_asset('backend/') }}/js/jquery-ui.js"></script>
    {{-- toastr --}}
    <script src="{{ global_asset('js/toastr.js') }}"></script>
    {!! Toastr::message() !!}
   @if (Session::has('toastr'))
        @dd(Session::get('toastr'))
    @endif 
    {{-- toastr --}}
    <script src="{{ global_asset('js/') }}/tooltip.js"></script>
    <script src="{{ global_asset('js/') }}/newmain.js"></script>
    <script src="{{ global_asset('js/') }}/theme.js" async></script>
    <!-- Input Tags -->
    <script src="{{ global_asset('vendors/') }}/inputtags/tagsinput.js"></script>
    <script src="{{ global_asset('backend/js/main.js') }}"></script>
    <script src="{{ global_asset('js/') }}/select2-init.js"></script>
    @stack('scripts')
    {{-- axios load --}}
    <script src="{{ global_asset('js/axios.js') }}"></script>
    {{-- axios load --}}
    <script>
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
    </script>
    <script src="{{ global_asset('backend/js/fs_d_ecma/configuration/configuration.js') }}"></script>