<div id="headerMain" class="d-none">
    <header id="header"
            class="navbar navbar-expand-lg navbar-fixed navbar-height navbar-flush navbar-container navbar-bordered">
        <div class="navbar-nav-wrap">
            <div class="navbar-brand-wrapper">
            </div>

            <div class="navbar-nav-wrap-content-left d-xl-none">
                <button type="button" class="js-navbar-vertical-aside-toggle-invoker close mr-3">
                    <i class="tio-first-page navbar-vertical-aside-toggle-short-align" data-toggle="tooltip"
                       data-placement="right" title="Collapse"></i>
                    <i class="tio-last-page navbar-vertical-aside-toggle-full-align"
                       data-template='<div class="tooltip d-none d-sm-block" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
                       data-toggle="tooltip" data-placement="right" title="Expand"></i>
                </button>
            </div>

            <div class="navbar-nav-wrap-content-right">
                <ul class="navbar-nav align-items-center flex-row">

                    <li class="nav-item ml-4">
                        <div class="hs-unfold">
                            <a class="js-hs-unfold-invoker navbar-dropdown-account-wrapper media align-items-center right-dropdown-icon"
                               href="javascript:;"
                               data-hs-unfold-options='{
                                     "target": "#accountNavbarDropdown",
                                     "type": "css-animation"
                                   }'>
                                <div class="media-body pl-0 pr-2">
                                    <span class="card-title h5 text-right"> {{translate('Merchant Panel')}} </span>
                                    <span
                                        class="card-text">{{auth('user')->user()->f_name??''}} {{auth('user')->user()->l_name??''}}</span>
                                </div>
                                <div class="avatar avatar-sm avatar-circle">
                                    <img class="avatar-img"
                                         src="{{auth('user')->user()->image_fullpath}}"
                                         alt="Image Description">
                                    <span class="avatar-status avatar-sm-status avatar-status-success"></span>
                                </div>
                            </a>

                            <div id="accountNavbarDropdown"
                                 class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right navbar-dropdown-menu navbar-dropdown-account min-w-16rem">
                                <div class="dropdown-item-text">
                                    <div class="media gap-3 align-items-center">
                                        <div class="avatar avatar-sm avatar-circle">
                                            <img class="avatar-img"
                                                 src="{{auth('user')->user()->image_fullpath}}"
                                                 alt="Image Description">
                                        </div>
                                        <div class="media-body">
                                            <span class="card-title h5">{{auth('user')->user()->f_name??''}}</span>
                                            <span class="card-text">{{auth('user')->user()->email??''}}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="dropdown-divider"></div>

                                <a class="dropdown-item" href="{{ route('vendor.settings') }}">
                                    <span class="text-truncate pr-2" title="Settings">{{translate('settings')}}</span>
                                </a>

                                <div class="dropdown-divider"></div>

                                <a class="dropdown-item merchant-logout-btn" href="javascript:">
                                    <span class="text-truncate pr-2" title="Sign out">{{translate('sign_out')}}</span>
                                </a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </header>
</div>
<div id="headerFluid" class="d-none"></div>
<div id="headerDouble" class="d-none"></div>
