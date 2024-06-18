<ul class="nav nav-tabs page-header-tabs border-bottom">
    <li class="nav-item">
        <a class="nav-link {{Request::is('admin/admin/view*') || Request::is('admin/agent/view*') || Request::is('admin/customer/view*') || Request::is('admin/vendor/view*')?'active':''}}"
           @if($user->type == 0)
               href="{{route('admin.admin.view',[$user['id']])}}"
           @elseif($user->type == 2)
               href="{{route('admin.customer.view',[$user['id']])}}"
           @elseif($user->type == 1)
               href="{{route('admin.vendor.view',[$user['id']])}}"
           @else
               href="#"
            @endif
        >{{translate('details')}}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{Request::is('admin/admin/transaction*') || Request::is('admin/agent/transaction*') || Request::is('admin/customer/transaction*') || Request::is('admin/vendor/transaction*')?'active':''}}"
           @if($user->type == 0)
               href="{{route('admin.admin.transaction',[$user['id']])}}"
           @elseif($user->type == 2)
               href="{{route('admin.customer.transaction',[$user['id']])}}"
           @elseif($user->type == 1)
               href="{{route('admin.vendor.transaction',[$user['id']])}}"
           @else
               href="#"
            @endif
        >{{translate('Transactions')}}</a>
    </li>
        @if(isset($user) && $user->type != 0 && $user->type != 1)
        <li class="nav-item">
            <a class="nav-link {{Request::is('admin/agent/log*') || Request::is('admin/customer/log*')?'active':''}}"
               @if(isset($user) && $user->type == 1)
                   href="{{route('admin.agent.log',[$user['id']])}}"
               @elseif(isset($user) && $user->type == 2)
                   href="{{route('admin.customer.log',[$user['id']])}}"
               @else
                   href="#"
                @endif
            >{{translate('Logs')}}</a>
        </li>
    @endif

</ul>
