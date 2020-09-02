@include('admin_dash.header')
<aside class="main-sidebar elevation-1 custom_class_sdbr">
  <a href="#" class="brand-link custom_brand_link">
    <img src="{{ asset('admin_css/images/follow_logo.png') }}" class="brand-image" style="opacity: .8"><span
      class="brand-text font-weight-light heading_mainn"><span class="admin_text">
        admin</span><span class="panel_text">panel</span></span>
  </a>
  <div class="sidebar">


    <nav class="mt-2">
      <ul class="nav custom_navv nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
        data-accordion="false">
        <div class="elementss_box">
          <li class="nav-item has-treeview nav_custom_item">
            <a href="{{ route('home') }}"
              class="nav-link custom_navv_linkk homee_divv class_inside_anchorr @if(request()->route()->getName()=='home') active @endif"
              style="padding-bottom: 1px;">
              <p style="color:#505B7A;font-weight: 600;padding-left: 14px;">
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview nav_custom_item">
            <a href="{{ route('user') }}" class="nav-link custom_navv_linkk homee_divv class_inside_anchorr @if(request()->route()->getName()=='user') active
                            @elseif(request()->route()->getName()=='UserDetail') active
                            @endif" style="padding-bottom: 1px;">
              <p style="color:#505B7A;font-weight: 600;padding-left: 14px;">
                User Management
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview nav_custom_item">
            <a href="{{ route('department') }}" class="nav-link custom_navv_linkk homee_divv class_inside_anchorr
              @if(request()->route()->getName()=='department') active
              @elseif(request()->route()->getName()=='badge') active
              @elseif(request()->route()->getName()=='DepartmentDetail') active
              @elseif(request()->route()->getName()=='BadgeDetail') active
              @endif" style="padding-bottom: 1px;">
              <p style="color:#505B7A;font-weight: 600;padding-left: 14px;">
                Department/Badge Management
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview nav_custom_item">
            <a href="{{ route('departmentRequest') }}" class="nav-link custom_navv_linkk homee_divv class_inside_anchorr 
           @if(request()->route()->getName()=='departmentRequest') active
              @endif" style="padding-bottom: 1px;">
              <p style="color:#505B7A;font-weight: 600;padding-left: 14px;">
                Request for new department
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview nav_custom_item">
            <a href="{{ route('post-list') }}" class="nav-link custom_navv_linkk homee_divv class_inside_anchorr 
           @if(request()->route()->getName()=='post-list') active
              @endif" style="padding-bottom: 1px;">
              <p style="color:#505B7A;font-weight: 600;padding-left: 14px;">
               Posts Management
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview nav_custom_item">
            <a href="{{ route('notification') }}"
              class="nav-link custom_navv_linkk homee_divv class_inside_anchorr @if(request()->route()->getName()=='notification') active @endif"
              style="padding-bottom: 1px;">
              <p style="color:#505B7A;font-weight: 600;padding-left: 14px;">
                Notifications
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview nav_custom_item">
            <a href="{{ route('about_us') }}" class="nav-link custom_navv_linkk homee_divv class_inside_anchorr @if(request()->route()->getName()=='about_us') active
                              @elseif(request()->route()->getName()=='terms') active 
                              @elseif(request()->route()->getName()=='privacy') active 
                              @endif" style="padding-bottom: 1px;">
              <p style="color:#505B7A;font-weight: 600;padding-left: 14px;">
                CMS
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview nav_custom_item">
            <a href="{{ route('countries') }}" class="nav-link custom_navv_linkk homee_divv class_inside_anchorr @if(request()->route()->getName()=='countries') active
                              @elseif(request()->route()->getName()=='ethnicity') active 
                              @elseif(request()->route()->getName()=='gender') active 
                              @elseif(request()->route()->getName()=='report') active 
                              @elseif(request()->route()->getName()=='add_country_page') active
                              @elseif(request()->route()->getName()=='add_state_page') active
                              @elseif(request()->route()->getName()=='add_city_page') active
                              @elseif(request()->route()->getName()=='add_ethnicity_page') active
                              @endif" style="padding-bottom: 1px;">
              <p style="color:#505B7A;font-weight: 600;padding-left: 14px;">
                Manage Data
              </p>
            </a>
          </li>
          {{-- <li class="nav-item has-treeview nav_custom_item"> 
         <a href="#" class="nav-link custom_navv_linkk homee_divv class_inside_anchorr" style="padding-bottom: 1px;">
           <p style="color:#505B7A;font-weight: 600;padding-left: 14px;">
                  Reported Posts
          </p>
         </a>
        </li> --}}
        </div>
      </ul>
    </nav>
  </div>
</aside>