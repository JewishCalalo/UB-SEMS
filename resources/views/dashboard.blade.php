<!-- Role-specific Dashboard Content -->
@if(Auth::user()->isAdmin())
    @include('admin.dashboard.index')
@elseif(Auth::user()->isManager())
    @include('manager.dashboard.index')
@else
    @include('user.dashboard.index')
@endif
