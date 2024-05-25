
<div id="sidebarMain" class="d-none">
    <aside
        class="js-navbar-vertical-aside navbar navbar-vertical-aside navbar-vertical navbar-vertical-fixed navbar-expand-xl navbar-bordered  ">
        <div class="navbar-vertical-container">
            <div class="navbar-brand-wrapper justify-content-between">
                @php($restaurantLogo=\App\CentralLogics\helpers::get_business_settings('logo'))
                <a class="navbar-brand" href="{{route('admin.dashboard')}}" aria-label="Front">
                    <img class="w-100 side-logo"
                         src="{{Helpers::onErrorImage($restaurantLogo, asset('storage/app/public/business') . '/' . $restaurantLogo, asset('public/assets/admin/img/ka_log.jpeg'), 'business/')}}"
                         alt="{{ translate('Logo') }}">
                </a>
                <div class="navbar-nav-wrap-content-left">
                    <button type="button" class="js-navbar-vertical-aside-toggle-invoker close mr-">
                        <i class="tio-first-page navbar-vertical-aside-toggle-short-align"></i>
                        <i class="tio-last-page navbar-vertical-aside-toggle-full-align"></i>
                    </button>
                </div>
            </div>

            <div class="navbar-vertical-content">

                <ul class="navbar-nav navbar-nav-lg nav-tabs">
                    <li class="pt-2 navbar-vertical-aside-has-menu {{Request::is('admin')?'active':''}}">
                        <a class="js-navbar-vertical-aside-menu-link nav-link"
                           href="{{route('admin.dashboard')}}" title="{{translate('dashboard')}}">
                            <i class="tio-home-vs-1-outlined nav-icon"></i>
                            <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                {{translate('dashboard')}}
                            </span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <small class="nav-subtitle"
                               title="{{translate('user')}} {{translate('section')}}">{{translate('user')}} {{translate('management')}}</small>
                        <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                    </li>

                    <li class="navbar-vertical-aside-has-menu {{ Request::is('admin/vendor/add') || Request::is('admin/vendor/list') || Request::is('admin/vendor/view*') || Request::is('admin/vendor/edit*') || Request::is('admin/vendor/transaction*')  ?'active':''}}">
                        <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:"
                        >
                            <i class="tio-user-big nav-icon"></i>
                            <span
                                class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{translate('Vendor')}}</span>
                        </a>
                        <ul class="js-navbar-vertical-aside-submenu nav nav-sub" style="display: {{Request::is('admin/vendor/add') || Request::is('admin/vendor/list') || Request::is('admin/vendor/view*') || Request::is('admin/vendor/edit*') || Request::is('admin/vendor/transaction*') ?'block':'none'}}">
                            <li class="navbar-vertical-aside-has-menu {{Request::is('admin/vendor/add')?'active':''}}">
                                <a class="nav-link " href="{{route('admin.vendor.add')}}"
                                   title="{{translate('add')}}">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">{{translate('register')}}</span>
                                </a>
                            </li>
                            <li class="navbar-vertical-aside-has-menu {{Request::is('admin/vendor/list')?'active':''}}">
                                <a class="nav-link " href="{{route('admin.vendor.list')}}"
                                   title="{{translate('list')}}">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">{{translate('list')}}</span>
                                </a>
                            </li>

                            <li class="navbar-vertical-aside-has-menu {{Request::is('admin/vendor/category')?'active':''}}">
                                <a class="nav-link " href="{{route('admin.vendor.category')}}"
                                   title="{{translate('list')}}">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">{{translate('Category')}}</span>
                                </a>
                            </li>

                            <li class="navbar-vertical-aside-has-menu {{Request::is('admin/vendor/zone')?'active':''}}">
                                <a class="nav-link " href="{{route('admin.vendor.zone')}}"
                                   title="{{translate('list')}}">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">{{translate('Zone')}}</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="navbar-vertical-aside-has-menu {{Request::is('admin/customer*')?'active':''}}">
                        <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:"
                        >
                            <i class="tio-group-senior nav-icon"></i>
                            <span
                                class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{translate('customer')}}</span>
                        </a>
                        <ul class="js-navbar-vertical-aside-submenu nav nav-sub" style="display: {{Request::is('admin/customer*')?'block':'none'}}">
                            <li class="navbar-vertical-aside-has-menu {{Request::is('admin/customer/add')?'active':''}}">
                                <a class="nav-link " href="{{route('admin.customer.add')}}"
                                   title="{{translate('add')}}">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">{{translate('register')}}</span>
                                </a>
                            </li>
                            <li class="navbar-vertical-aside-has-menu {{Request::is('admin/customer/list')?'active':''}}">
                                <a class="nav-link " href="{{route('admin.customer.list')}}"
                                   title="{{translate('list')}}">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">{{translate('list')}}</span>
                                </a>
                            </li>
                            {{-- <li class="navbar-vertical-aside-has-menu {{Request::is('admin/customer/kyc-requests')?'active':''}}">
                                <a class="nav-link " href="{{route('admin.customer.kyc_requests')}}"
                                   title="{{translate('Verification Requests')}}">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">{{translate('Verification Requests')}}</span>
                                </a>
                            </li> --}}
                        </ul>
                    </li>



                    <li class="nav-item">
                        <small class="nav-subtitle"
                               title="{{translate('system')}} {{translate('section')}}">{{translate('system')}} {{translate('management')}}</small>
                        <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                    </li>

                    <li class="navbar-vertical-aside-has-menu {{Request::is('admin/business-settings/*')?'active':''}}">
                        <a class="nav-link " href="{{route('admin.business-settings.business-setup')}}"
                            title="{{translate('business')}} {{translate('setup')}}">
                            <span class="tio-settings nav-icon"></span>
                            <span class="text-truncate">{{translate('business setup')}}</span>
                        </a>
                    </li>


                </ul>
            </div>
        </div>
    </aside>
</div>

<div id="sidebarCompact" class="d-none">

</div>

@push('script_2')
<script>
    $(window).on('load' , function() {
        if($(".navbar-vertical-content li.active").length) {
            $('.navbar-vertical-content').animate({
                scrollTop: $(".navbar-vertical-content li.active").offset().top - 150
            }, 10);
        }
    });

    var $rows = $('.navbar-vertical-content  .navbar-nav > li');
    $('#search-sidebar-menu').keyup(function() {
        var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

        $rows.show().filter(function() {
            var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
            return !~text.indexOf(val);
        }).hide();
    });
</script>
@endpush
