<div class="single-select d-none d-lg-block mr-16">
    <input type="hidden" id="change_branch_url" value="{{ route('branchs.ajaxBranchChange') }}">
    <select name="user_branch" class="branch-select" id="change-user-branch">
        @foreach ($branches as $branch)
            <option value="{{ $branch->id }}" {{ $branch->id == userBranch() ? 'selected' : '' }}>
                {{ $branch->name }}</option>
        @endforeach
    </select>
</div>