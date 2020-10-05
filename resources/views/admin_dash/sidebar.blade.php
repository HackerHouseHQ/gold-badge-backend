<nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
  <div class="scrollbar-inner">
    <!-- Brand -->
    <div class="sidenav-header  d-flex  align-items-center">
      <a class="navbar-brand" href="{{route('home')}}">
        <!--<img src="{{asset('admin_new/assets/img/brand/blue.png')}}" class="navbar-brand-img" alt="...">-->
        <img src="http://13.235.176.85/gold_badge/public/admin_css/images/follow_logo.png" class="navbar-brand-img"
          alt="..."> Gold Badge
      </a>
      <div class=" ml-auto ">
        <!-- Sidenav toggler -->
        <div class="sidenav-toggler d-none d-xl-block" data-action="sidenav-unpin" data-target="#sidenav-main">
          <div class="sidenav-toggler-inner">
            <i class="sidenav-toggler-line"></i>
            <i class="sidenav-toggler-line"></i>
            <i class="sidenav-toggler-line"></i>
          </div>
        </div>
      </div>
    </div>
    <div class="navbar-inner">
      <!-- Collapse -->
      <div class="collapse navbar-collapse" id="sidenav-collapse-main">
        <!-- Nav items -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a href="{{ route('home') }}" class="nav-link  @if(request()->route()->getName()=='home') active
          @endif">
              <i class="ni ni-tv-2 text-primary"></i>
              <span class="nav-link-text">Dashboard</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('user') }}" class="nav-link  @if(request()->route()->getName()=='user') active
            @elseif(request()->route()->getName()=='UserDetail') active
            @endif">
              <i class="fas fa-user-cog text-primary"></i>
              <span class="nav-link-text">User Management</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('department') }}" class="nav-link 
              @if(request()->route()->getName()=='department') active
              @elseif(request()->route()->getName()=='badge') active
              @elseif(request()->route()->getName()=='DepartmentDetail') active
              @elseif(request()->route()->getName()=='BadgeDetail') active
              @endif">
              <i class="fab fa-delicious text-primary"></i>
              <span class="nav-link-text">Department/Badge Management </span>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('departmentRequest') }}" class="nav-link  @if(request()->route()->getName()=='departmentRequest' || request()->route()->getName()=='deprtmentPendingRequest' || request()->route()->getName()=='deprtmentRejectRequest') active
            @endif">
              <i class="fas fa-tasks text-primary"></i>
              <span class="nav-link-text">Department Request </span>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('post-list') }}" class="nav-link  @if(request()->route()->getName()=='post-list') active
            @endif">
              <i class="far fa-envelope text-primary"></i>
              <span class="nav-link-text">Post Management </span>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('notification') }}" class="nav-link  @if(request()->route()->getName()=='notification') active
            @endif">
              <i class="fas fa-bell text-primary"></i>
              <span class="nav-link-text">Notification </span>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('about_us') }}" class="nav-link  @if(request()->route()->getName()=='about_us' || request()->route()->getName()=='privacy' || request()->route()->getName()=='terms') active
            @endif">
              <i class="ni ni-collection text-primary"></i>
              <span class="nav-link-text">CMS </span>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('countries') }}" class="nav-link  @if(request()->route()->getName()=='countries' 
                 || request()->route()->getName()=='ethnicity' || request()->route()->getName()=='gender' 
                 || request()->route()->getName()=='report' || request()->route()->getName()=='add_country') active
            @endif">
              <i class="far fa-chart-bar text-primary"></i>
              <span class="nav-link-text">Manage Data</span>
            </a>
          </li>
          {{-- <li class="nav-item">
            <a href="{{ route('countries') }}" class="nav-link @if(request()->route()->getName()=='countries'
          || request()->route()->getName()=='ethnicity' || request()->route()->getName()=='gender'
          || request()->route()->getName()=='report' || request()->route()->getName()=='add_country') active
          @endif">
          <i class="far fa-chart-bar text-primary"></i>
          <span class="nav-link-text">Reported Posts</span>
          </a>
          </li> --}}

          <!--          <li class="nav-item">
            <a class="nav-link" href="#navbar-components" data-toggle="collapse" role="button" aria-expanded="false"
              aria-controls="navbar-components">
              <i class="ni ni-ui-04 text-info"></i>
              <span class="nav-link-text">Components</span>
            </a>
            <div class="collapse" id="navbar-components">
              <ul class="nav nav-sm flex-column">
                <li class="nav-item">
                  <a href="../../pages/components/buttons.html" class="nav-link">
                    <span class="sidenav-mini-icon"> B </span>
                    <span class="sidenav-normal"> Buttons </span>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="../../pages/components/cards.html" class="nav-link">
                    <span class="sidenav-mini-icon"> C </span>
                    <span class="sidenav-normal"> Cards </span>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="../../pages/components/grid.html" class="nav-link">
                    <span class="sidenav-mini-icon"> G </span>
                    <span class="sidenav-normal"> Grid </span>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="../../pages/components/notifications.html" class="nav-link">
                    <span class="sidenav-mini-icon"> N </span>
                    <span class="sidenav-normal"> Notifications </span>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="../../pages/components/icons.html" class="nav-link">
                    <span class="sidenav-mini-icon"> I </span>
                    <span class="sidenav-normal"> Icons </span>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="../../pages/components/typography.html" class="nav-link">
                    <span class="sidenav-mini-icon"> T </span>
                    <span class="sidenav-normal"> Typography </span>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#navbar-multilevel" class="nav-link" data-toggle="collapse" role="button"
                    aria-expanded="true" aria-controls="navbar-multilevel">
                    <span class="sidenav-mini-icon"> M </span>
                    <span class="sidenav-normal"> Multi level </span>
                  </a>
                  <div class="collapse show" id="navbar-multilevel" style="">
                    <ul class="nav nav-sm flex-column">
                      <li class="nav-item">
                        <a href="#!" class="nav-link ">Third level menu</a>
                      </li>
                      <li class="nav-item">
                        <a href="#!" class="nav-link ">Just another link</a>
                      </li>
                      <li class="nav-item">
                        <a href="#!" class="nav-link ">One last link</a>
                      </li>
                    </ul>
                  </div>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#navbar-forms" data-toggle="collapse" role="button" aria-expanded="false"
              aria-controls="navbar-forms">
              <i class="ni ni-single-copy-04 text-pink"></i>
              <span class="nav-link-text">Forms</span>
            </a>
            <div class="collapse" id="navbar-forms">
              <ul class="nav nav-sm flex-column">
                <li class="nav-item">
                  <a href="../../pages/forms/elements.html" class="nav-link">
                    <span class="sidenav-mini-icon"> E </span>
                    <span class="sidenav-normal"> Elements </span>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="../../pages/forms/components.html" class="nav-link">
                    <span class="sidenav-mini-icon"> C </span>
                    <span class="sidenav-normal"> Components </span>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="../../pages/forms/validation.html" class="nav-link">
                    <span class="sidenav-mini-icon"> V </span>
                    <span class="sidenav-normal"> Validation </span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="#navbar-tables" data-toggle="collapse" role="button" aria-expanded="true"
              aria-controls="navbar-tables">
              <i class="ni ni-align-left-2 text-default"></i>
              <span class="nav-link-text">Tables</span>
            </a>
            <div class="collapse show" id="navbar-tables">
              <ul class="nav nav-sm flex-column">
                <li class="nav-item">
                  <a href="../../pages/tables/tables.html" class="nav-link">
                    <span class="sidenav-mini-icon"> T </span>
                    <span class="sidenav-normal"> Tables </span>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="../../pages/tables/sortable.html" class="nav-link">
                    <span class="sidenav-mini-icon"> S </span>
                    <span class="sidenav-normal"> Sortable </span>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="../../pages/tables/datatables.html" class="nav-link active">
                    <span class="sidenav-mini-icon"> D </span>
                    <span class="sidenav-normal"> Datatables </span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#navbar-maps" data-toggle="collapse" role="button" aria-expanded="false"
              aria-controls="navbar-maps">
              <i class="ni ni-map-big text-primary"></i>
              <span class="nav-link-text">Maps</span>
            </a>
            <div class="collapse" id="navbar-maps">
              <ul class="nav nav-sm flex-column">
                <li class="nav-item">
                  <a href="../../pages/maps/google.html" class="nav-link">
                    <span class="sidenav-mini-icon"> G </span>
                    <span class="sidenav-normal"> Google </span>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="../../pages/maps/vector.html" class="nav-link">
                    <span class="sidenav-mini-icon"> V </span>
                    <span class="sidenav-normal"> Vector </span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../pages/widgets.html">
              <i class="ni ni-archive-2 text-green"></i>
              <span class="nav-link-text">Widgets</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../pages/charts.html">
              <i class="ni ni-chart-pie-35 text-info"></i>
              <span class="nav-link-text">Charts</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../pages/calendar.html">
              <i class="ni ni-calendar-grid-58 text-red"></i>
              <span class="nav-link-text">Calendar</span>
            </a>
          </li>-->
        </ul>
        <!-- Divider -->
        <hr class="my-3">
        <!-- Heading -->
        <!--        <h6 class="navbar-heading p-0 text-muted">
          <span class="docs-normal">Documentation</span>
          <span class="docs-mini">D</span>
        </h6>-->
        <!-- Navigation -->
        <!--        <ul class="navbar-nav mb-md-3">
          <li class="nav-item">
            <a class="nav-link" href="../../docs/getting-started/overview.html" target="_blank">
              <i class="ni ni-spaceship"></i>
              <span class="nav-link-text">Getting started</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../docs/foundation/colors.html" target="_blank">
              <i class="ni ni-palette"></i>
              <span class="nav-link-text">Foundation</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../docs/components/alerts.html" target="_blank">
              <i class="ni ni-ui-04"></i>
              <span class="nav-link-text">Components</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../docs/plugins/charts.html" target="_blank">
              <i class="ni ni-chart-pie-35"></i>
              <span class="nav-link-text">Plugins</span>
            </a>
          </li>
        </ul>-->
      </div>
    </div>
  </div>
</nav>