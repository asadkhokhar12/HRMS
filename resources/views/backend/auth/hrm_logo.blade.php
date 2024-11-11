<div class="sidebar-top-side ">
    <a href="{{ url('/') }}" class="img-tag">
        @if(env('FILESYSTEM_DRIVER') == 'server')
            <img src="{{ Storage::disk('s3')->url(config('settings.app')['company_logo_frontend']) }}"
                 class="hourworx-logo-img"
                 alt="{{ config('app.name') }}" width="">
        @elseif(env('FILESYSTEM_DRIVER') == 's3')
            <img src="{{ Storage::disk('s3')->url(config('settings.app')['company_logo_frontend']) }}"
                 class="hourworx-logo-img"
                 alt="{{ config('app.name') }}" width="">
        @elseif(env('FILESYSTEM_DRIVER') == 'local')
                <img src="{{  Storage::url(config('settings.app')['company_logo_frontend']) }}"
                 class="hourworx-logo-img"
                 alt="{{ config('app.name') }}" width="">
        @else
        <img src="{{ Storage::url(config('settings.app')['company_logo_frontend']) }}"
                 class="hourworx-logo-img"
                 alt="{{ config('app.name') }}" width="">
        @endif
    </a>
</div>
