<div class="single-selectd-lg-block mr-16">
    <input type="hidden" id="change_company_url" value="{{ route('company.ajaxCompanyChange') }}">
    <select name="user_company" class="company-select select2-initialize " id="change-user-company">
        @foreach ($companies as $company)
            <option value="{{ $company->id }}" {{ $company->id == userCompanies() ? 'selected' : '' }}>
                {{ $company->name }}</option>
        @endforeach
    </select>
</div>

 
