        {{-- middle-section --}}
        <div class="bg-lightt">
            <div class="container">
                <div class="row py-5 align-items-center mx-text-md-center">
                    <div class="col-lg-6 mx-mb-md mx-md-order-2">
                        <div class="upcoming-feature-box d-flex flex-column flex-lg-row flex-md-row flex-xl-row">
                            <div class="feature-box-group d-flex flex-column mt-lg-5 mt-xl-5">
                                <div
                                    class="feature-box white-box d-flex flex-column align-items-center justify-content-center mx-md-order-2">
                                    <img src="{{ url('images/hr-analytics.svg') }}" alt="">
                                    <h2>Live Track</h2>
                                </div>
                                <div
                                    class="feature-box blue-box d-flex flex-column align-items-center justify-content-center mx-md-order-1">
                                    <img src="{{ url('images/managed-payroll.svg') }}" alt="">
                                    <h2>Outgo Expense</h2>
                                </div>
                            </div>
                            <div class="feature-box-group d-flex flex-column">
                                <div
                                    class="feature-box blue-box d-flex flex-column align-items-center justify-content-center">
                                    <img src="{{ url('images/payroll-time-management.svg') }}" alt="">
                                    <h2>{{__('Programme of appointment/meeting') }} </h2>
                                </div>
                                <div
                                    class="feature-box  white-box d-flex flex-column align-items-center justify-content-center">
                                    <img src="{{ url('images/payroll_items-administration.svg') }}"
                                        alt="">
                                    <h2>Ticket</h2>
                                </div>
                            </div>
                        </div>
                        <div class="d-lg-none d-xl-none mt-5">
                            <a class="login-panel-btn gradient-btn" href="/">{{__('Shop Now') }}</a>
                        </div>
                    </div>
                    <div class="col-lg-6 mx-md-order-1">
                        <div class="side-content">
                            <h2>{{__('Latest Features') }}</h2>
                            <p>24hourworx is upgraded with the most amazing features that includes Live track, Outgo
                                expense, Programme of appointment/meeting and Ticket. <br> <br>
                                <b>Live Track - </b> Enables you to track your employees’ whereabouts while they are out
                                to attend meetings or for any official field trip. <br> <br>
                                <b>Outgo Expense - </b> Expenditure made by individuals for official reasons or any
                                other, can be easily tracked down by the end of every month <br> <br>
                                <b>Programme of appointment/meeting - </b> Notify team members and mark your time-slots
                                for using conference rooms or transportation to attend crucial/bi-monthly/semi-monthly
                                meetings.<br> <br>
                                <b> Ticket -</b> Become the first to instantiate for company’s rectification with your
                                conviction via sending tickets to management.
                            </p>
                            <a class="login-panel-btn gradient-btn d-none d-lg-inline-block d-xl-inline-block"
                                href="/">Shop
                                Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      
        {{-- middle-section --}}
        <div class="my-5 mx-3">
            <div class="container bg-gradient-frontend statictics-upper-container">
                <div
                    class="row statictics-container py-5 align-items-center mx-text-md-center align-items-center justify-content-center">
                    <div class="col-6 col-md-3 col-lg-3 col-xl-3 statictics-item mb-2">
                        <img src="{{ url('images/hired-1.svg') }}" alt="">
                        <h3>260+</h3>
                        <p>people hired</p>
                    </div>
                    <div class="col-6 col-md-3 col-lg-3 col-xl-3 statictics-item mb-2">
                        <img src="{{ url('images/feedback-1.svg') }}" alt="">
                        <h3>320+</h3>
                        <p>satisfied hired</p>
                    </div>
                    <div class="col-6 col-md-3 col-lg-3 col-xl-3  statictics-item mt-2">
                        <img src="{{ url('images/client-1.svg') }}" alt="">
                        <h3>170+</h3>
                        <p>company using</p>
                    </div>
                    <div class="col-6 col-md-3 col-lg-3 col-xl-3  statictics-item mt-2">
                        <img src="{{ url('images/support-1.svg') }}" alt="">
                        <h3>90+</h3>
                        <p>dedicated supports</p>
                    </div>
                </div>
            </div>
        </div>
        @section('script')
        @endsection
