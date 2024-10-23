
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        @if($appInfo->count() > 0)
        <a href="{{route('admin.dashboard')}}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ URL::asset('storage/appsettings/'.$appInfo->where('key','app_logo')->pluck('value')->first())}}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('storage/appsettings/'.$appInfo->where('key','app_logo')->pluck('value')->first()) }}" alt="" height="33">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="{{url('/')}}" class="logo logo-light ">
            <span class="logo-sm">
                <img src="{{ URL::asset('storage/appsettings/'.$appInfo->where('key','app_logo')->pluck('value')->first()) }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('storage/appsettings/'.$appInfo->where('key','app_logo')->pluck('value')->first()) }}" alt="" height="17">
            </span>
        </a>
        @else
            <a href="{{url('/')}}" class="logo logo-light">
            <span class="logo-sm">
             <img src="{{ URL::asset('build/images/logo-light.png')}}" alt="" height="22">
            </span>
                <span class="logo-lg">
          <img src="{{ URL::asset('build/images/logo-light.png')}}" alt="" height="17">
            </span>
            </a>

        @endif
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span>@lang('translation.menu')</span></li>


                <li class="nav-item">
                    <a class="nav-link menu-link {{ (Route::currentRouteName()=='admin.dashboard')?'active':''}}" href="{{route('admin.dashboard')}}" >
                        <i class="ri-dashboard-2-line"></i> <span>Dashboard</span>
                    </a>
                </li>

                @canany('admin-user-view')
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ (Route::currentRouteName()=='admin.user.index')?'active':''}}" href="{{route('admin.user.index')}}" >
                            <i class="ri-parent-fill"></i> <span>@lang('translation.users') </span>
                        </a>
                    </li>
                @endcanany

                    <li class="nav-item">
                        <a class="nav-link menu-link {{ (Route::currentRouteName()=='admin.user.category')?'active':''}}" href="{{route('admin.category.index')}}" >
                            <i class="ri-parent-fill"></i> <span> Category</span>
                        </a>
                    </li>

                <li class="nav-item">
                    <a class="nav-link menu-link {{ (Route::currentRouteName()=='admin.product.index')?'active':''}}" href="{{route('admin.product.index')}}" >
                        <i class="ri-parent-fill"></i> <span>Products</span>
                    </a>
                </li>





                 <li class="nav-item">
                        <a class="nav-link menu-link {{ (Route::currentRouteName()=='admin.roles.index' OR Route::currentRouteName()=='admin.language.index' OR Route::currentRouteName()=='admin.app-settings.index')?'active':''}}" href="#sidebarDashboards" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                            <i class="ri-settings-2-line"></i> <span>@lang('translation.settings')</span>
                        </a>

                        <div class="collapse menu-dropdown {{ (Route::currentRouteName()=='admin.roles.index' OR Route::currentRouteName()=='admin.language.index' OR Route::currentRouteName()=='admin.app-settings.index')?'collapse show':''}}" id="sidebarDashboards">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">

                                  <a href="{{route('admin.app-settings.index')}}" class="nav-link {{ ( Route::currentRouteName()=='admin.app-settings.index')?'active':''}}">@lang('translation.app_settings')</a>


                                        <a href="{{route('admin.roles.index')}}" class="nav-link {{ (Route::currentRouteName()=='admin.roles.index')?'active':''}}">@lang('translation.roles')</a>





                                </li>



                            </ul>
                        </div>
                    </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
    <div class="sidebar-background"></div>
</div>
<div class="vertical-overlay"></div>
