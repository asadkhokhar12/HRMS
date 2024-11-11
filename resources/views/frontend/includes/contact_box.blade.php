<style>
    .contact-form-wrapper {
        display: none;
        bottom: 0px;
        transition: .7s;
        -webkit-transition: .7s;
        transform: translateX(101%);
        -webkit-transform: translateX(101%);
        background: rgb(255, 255, 255);
        z-index: 20;
        position: fixed;
        right: 0;
        box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.75) !important;

    }

    .contact-form-wrapper.show {
        transform: translateX(-0%) !important;
        -webkit-transform: translateX(-0%) !important;
    }

    .contact-form {
        padding: 30px 40px;
        background-color: #ffffff;
        border-radius: 12px;
        max-width: 400px;
    }

    .contact-form textarea {
        resize: none;
    }

    .contact-form .form-input,
    .form-text-area {
        background-color: #f0f4f5;
        height: 50px;
        padding-left: 16px;
    }

    .contact-form .form-text-area {
        background-color: #f0f4f5;
        height: auto;
        padding-left: 16px;
    }

    .contact-form .form-control::placeholder {
        color: #aeb4b9;
        font-weight: 500;
        opacity: 1;
    }

    .contact-form .form-control:-ms-input-placeholder {
        color: #aeb4b9;
        font-weight: 500;
    }

    .contact-form .form-control::-ms-input-placeholder {
        color: #aeb4b9;
        font-weight: 500;
    }

    .contact-form .form-control:focus,
    .contact-form .form-text-area:focus {
        border-color: #7f58fe;
        box-shadow: inset 0 1px 1px rgb(0 0 0 / 7%), 0 0 8px #7f58fe;
    }

    .contact-form .title {
        text-align: center;
        font-size: 24px;
        font-weight: 500;
    }

    .contact-form .description {
        color: #aeb4b9;
        font-size: 14px;
        text-align: center;
    }

    .contact-form .submit-button-wrapper {
        text-align: center;
    }

    .contact-form .submit-button-wrapper input {
        border: none;
        border-radius: 4px;
        background-color: #4466f2;
        color: white;
        text-transform: uppercase;
        padding: 10px 60px;
        font-weight: 500;
        letter-spacing: 2px;
    }

    .contact-form .submit-button-wrapper input:hover {
        background-color: rgb(68, 102, 242, .8);
    }


    #leaveMessageBtn {
        position: fixed;
        z-index: 20;
        bottom: 90px;
        right: 0;
        background-color: #0a5b83;
        border-top-left-radius: 15px;
        border-bottom-left-radius: 15px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    #leaveMessageBtn.hide {
        transition: .7s;
        -webkit-transition: .7s;
        transform: translateX(101%);
        -webkit-transform: translateX(101%);
    }

    #leaveMessageBtn .lmb-content {
        padding: 12px
    }

    #leaveMessageBtn .lmb-content p,
    #leaveMessageBtn .lmb-content i {
        color: #fff !important;
        margin-bottom: 0px;
        font-size: 22px
    }

    #closeContactBox {
        background: transparent;
        float: right;
        margin-top: 5px;
        margin-right: 5px;
        color: #d81324;
        font-size: 22px;
    }
</style>



<div class="contact-form-wrapper">
    <button id="closeContactBox">
        <i class="fa fa-times-circle" aria-hidden="true"></i>
    </button>
    <form action="#" class="contact-form" id="quickContactForm">
        <h5 class="title mb-1">{{ _trans('common.Any Query?') }}</h5>
        <p class="description">{{ _trans('frontend.Send us a quick message.') }}
        </p>
        <div>
            <input type="text" class="form-control rounded border-white mb-3 form-input" id="name"
                placeholder="{{ _trans('frontend.Name *') }}" required>
        </div>
        <div>
            <input type="email" class="form-control rounded border-white mb-3 form-input" id="email"
                placeholder="{{ _trans('frontend.Email *') }}" required>
        </div>
        <div>
            <textarea id="message" class="rounded border-white mb-3 form-text-area" rows="5" cols="30"
                placeholder="{{ _trans('frontend.Message *') }}" required></textarea>
        </div>
        <div class="submit-button-wrapper">
            <input class="gradient-btn" id="submitQuery" type="button" value="{{ _trans('frontend.Send') }}">
        </div>
    </form>
</div>


<button id="leaveMessageBtn" class="gradient-btn d-none">
    <div class="lmb-content d-flex align-items-center justify-content-center">
        <i class="fa fa-comments" aria-hidden="true"></i>
        <p class="ml-3">{{ _trans('frontend.Leave Message') }}</p>
    </div>
</button>
@push('script')
    <script src="{{ global_asset('frontend/js/v1/__mStype.js') }}"></script>
@endpush
