<div class="mr-16 d-flex align-items-center gap-5">
    <i class="fa-solid fa-globe"></i>
    <input type="hidden" class="change_frontend_lang_url" value="{{ route('language.ajaxFrontendLangChange') }}">
    <select name="frontend_lang" class="change-frontend-lang">
        @foreach ($data['languages'] ?? [] as $language)
            <option value="{{ $language->code }}" {{ $language->name == $data['frontend_language'] ? 'selected' : '' }}>
                {{ $language->name }}
            </option>
        @endforeach
    </select>
</div>
