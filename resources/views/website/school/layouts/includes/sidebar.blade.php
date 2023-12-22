<!-- Sidebar -->
<ul class="sidebar_wide navbar-nav accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-start">
        <div class="sidebar-brand-icon">
            <img class="platform_icon" alt="lam platform logo" src="{{ URL::asset('img/website/logo/lam_logo.svg') }}">
        </div>
        <div class="topbar-divider d-none d-sm-block fullsc_topbar_hide my-0 mx-1"></div>
        <div class="sidebar-brand-text">منصة لام</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-2">

    <!-- Nav Item - Dashboard -->

    <li class="nav-item current_school_active">
        <a class="nav-link collapsed" @if(Auth::guard('school')->user()->shared_school == 2) href="#"
            data-bs-toggle="collapse" @endif data-bs-target="#current_school"
            aria-expanded="true" aria-controls="collapsePages" data-toggle="collapse" data-target=".navbar-collapse">
            <img class="sidebare_icon" alt="school" src="{{ URL::asset('img/icons/sidebar/school.svg') }}">
            <div style="display: inline-grid;">
                <span class="main-color fw-bold">{{ $school->name }}</span>
                <div class=" text-gray-400 text-xs" style="display: inline-table;">{{ $school->department_office->name
                    }}</div>
            </div>
        </a>

        @if(Auth::guard('school')->user()->shared_school == 2)
        <div id="current_school" class="collapse collapse-side-admin" aria-labelledby="headingPages"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner">
                <a class="collapse-item clickable-item-pointer change_school_sidebar" data-school_type="1">
                    <img class="sidebare_icon me-2" alt="school" src="{{ URL::asset('img/icons/sidebar/school.svg') }}">
                    {{ Auth::guard('school')->user()->first_school->name; }}
                </a>
                <a class="collapse-item clickable-item-pointer change_school_sidebar" data-school_type="2">
                    <img class="sidebare_icon me-2" alt="school" src="{{ URL::asset('img/icons/sidebar/school.svg') }}">
                    {{ Auth::guard('school')->user()->second_school->name }}
                </a>

            </div>
        </div>
        @endif

    </li>

    <hr class="my-0">

    <li class="nav-item active">
        <a class="nav-link collapsed" href="{{ route('school_route.dashboard') }}" aria-expanded="true" aria-controls="collapsePages" data-toggle="collapse"
            data-target=".navbar-collapse">
            <img class="sidebare_icon" alt="school" src="{{ URL::asset('img/icons/sidebar/home.svg') }}">
            <span>الرئيسية</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePagesCost_center"
            aria-expanded="true" aria-controls="collapsePages" data-toggle="collapse" data-target=".navbar-collapse">
            <img class="sidebare_icon" alt="school" src="{{ URL::asset('img/icons/sidebar/school_2.svg') }}">
            <span>المدرسة</span>
        </a>

        <div id="collapsePagesCost_center" class="collapse collapse-side-admin" aria-labelledby="headingPages"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner">
                <a class="collapse-item" href="#">
                    <div class="icon_square" style="background-color:#BCD7F5;"></div>
                    بيانات المدرسة
                </a>
                <a class="collapse-item" href="#">
                    <div class="icon_square" style="background-color:#F5CBBC;"></div>
                    طلاب المدرسة
                </a>
                <a class="collapse-item" href="#">
                    <div class="icon_square" style="background-color:#F5BCBC;"></div>
                    معلمي المدرسة
                </a>
                <a class="collapse-item" href="#">
                    <div class="icon_square" style="background-color:#BDF5BC;"></div>
                    إداري المدرسة
                </a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#meetings_sidebar"
            aria-expanded="true" aria-controls="collapsePages" data-toggle="collapse" data-target=".navbar-collapse">
            <img class="sidebare_icon" alt="school" src="{{ URL::asset('img/icons/sidebar/users.svg') }}">
            <span>إجتماعات اللجان والفرق</span>
        </a>

        <div id="meetings_sidebar" class="collapse collapse-side-admin" aria-labelledby="headingPages"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner">

                <a class="collapse-item" href="{{ url('school\Committees_and_teams_meetings') }}">
                    <div class="icon_square" style="background-color:#BCD7F5;"></div>
                    إجتماعات اللجان
                </a>
                <a class="collapse-item" href="{{ url('school\Committees_and_teams_meetings?teams=1') }}">
                    <div class="icon_square" style="background-color:#F5CBBC;"></div>
                    إجتماعات الفرق
                </a>


            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#tasks_sidebar"
            aria-expanded="true" aria-controls="collapsePages" data-toggle="collapse" data-target=".navbar-collapse">
            <img class="sidebare_icon" alt="school" src="{{ URL::asset('img/icons/sidebar/flag.svg') }}">
            <span>التكلفات</span>
        </a>

        <div id="tasks_sidebar" class="collapse collapse-side-admin" aria-labelledby="headingPages"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner">
                <a class="collapse-item" href="#">
                    <div class="icon_square" style="background-color:#BCD7F5;"></div>
                    بيانات المدرسة
                </a>
                <a class="collapse-item" href="#">
                    <div class="icon_square" style="background-color:#F5CBBC;"></div>
                    طلاب المدرسة
                </a>
                <a class="collapse-item" href="#">
                    <div class="icon_square" style="background-color:#F5BCBC;"></div>
                    معلمي المدرسة
                </a>
                <a class="collapse-item" href="#">
                    <div class="icon_square" style="background-color:#BDF5BC;"></div>
                    إداري المدرسة
                </a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#tasks_notes"
            aria-expanded="true" aria-controls="collapsePages" data-toggle="collapse" data-target=".navbar-collapse">
            <img class="sidebare_icon" alt="school" src="{{ URL::asset('img/icons/sidebar/note.svg') }}">
            <span>الخطابات الرسمية</span>
        </a>

        <div id="tasks_notes" class="collapse collapse-side-admin" aria-labelledby="headingPages"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner">
                <a class="collapse-item" href="#">
                    <div class="icon_square" style="background-color:#BCD7F5;"></div>
                    بيانات المدرسة
                </a>
                <a class="collapse-item" href="#">
                    <div class="icon_square" style="background-color:#F5CBBC;"></div>
                    طلاب المدرسة
                </a>
                <a class="collapse-item" href="#">
                    <div class="icon_square" style="background-color:#F5BCBC;"></div>
                    معلمي المدرسة
                </a>
                <a class="collapse-item" href="#">
                    <div class="icon_square" style="background-color:#BDF5BC;"></div>
                    إداري المدرسة
                </a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#tasks_tables"
            aria-expanded="true" aria-controls="collapsePages" data-toggle="collapse" data-target=".navbar-collapse">
            <img class="sidebare_icon" alt="school" src="{{ URL::asset('img/icons/sidebar/grid.svg') }}">
            <span>الجداول</span>
        </a>

        <div id="tasks_tables" class="collapse collapse-side-admin" aria-labelledby="headingPages"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner">
                <a class="collapse-item" href="#">
                    <div class="icon_square" style="background-color:#BCD7F5;"></div>
                    بيانات المدرسة
                </a>
                <a class="collapse-item" href="#">
                    <div class="icon_square" style="background-color:#F5CBBC;"></div>
                    طلاب المدرسة
                </a>
                <a class="collapse-item" href="#">
                    <div class="icon_square" style="background-color:#F5BCBC;"></div>
                    معلمي المدرسة
                </a>
                <a class="collapse-item" href="#">
                    <div class="icon_square" style="background-color:#BDF5BC;"></div>
                    إداري المدرسة
                </a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#tasks_summer"
            aria-expanded="true" aria-controls="collapsePages" data-toggle="collapse" data-target=".navbar-collapse">
            <img class="sidebare_icon" alt="school" src="{{ URL::asset('img/icons/sidebar/sun.svg') }}">
            <span>الزيارات الصيفية</span>
        </a>

        <div id="tasks_summer" class="collapse collapse-side-admin" aria-labelledby="headingPages"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner">
                <a class="collapse-item" href="#">
                    <div class="icon_square" style="background-color:#BCD7F5;"></div>
                    بيانات المدرسة
                </a>
                <a class="collapse-item" href="#">
                    <div class="icon_square" style="background-color:#F5CBBC;"></div>
                    طلاب المدرسة
                </a>
                <a class="collapse-item" href="#">
                    <div class="icon_square" style="background-color:#F5BCBC;"></div>
                    معلمي المدرسة
                </a>
                <a class="collapse-item" href="#">
                    <div class="icon_square" style="background-color:#BDF5BC;"></div>
                    إداري المدرسة
                </a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#tasks_summer"
            aria-expanded="true" aria-controls="collapsePages" data-toggle="collapse" data-target=".navbar-collapse">
            <img class="sidebare_icon" alt="school" src="{{ URL::asset('img/icons/sidebar/task.svg') }}">
            <span>الاختبارات</span>
        </a>

        <div id="tasks_summer" class="collapse collapse-side-admin" aria-labelledby="headingPages"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner">
                <a class="collapse-item" href="#">
                    <div class="icon_square" style="background-color:#BCD7F5;"></div>
                    بيانات المدرسة
                </a>
                <a class="collapse-item" href="#">
                    <div class="icon_square" style="background-color:#F5CBBC;"></div>
                    طلاب المدرسة
                </a>
                <a class="collapse-item" href="#">
                    <div class="icon_square" style="background-color:#F5BCBC;"></div>
                    معلمي المدرسة
                </a>
                <a class="collapse-item" href="#">
                    <div class="icon_square" style="background-color:#BDF5BC;"></div>
                    إداري المدرسة
                </a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#tasks_stac"
            aria-expanded="true" aria-controls="collapsePages" data-toggle="collapse" data-target=".navbar-collapse">
            <img class="sidebare_icon" alt="school" src="{{ URL::asset('img/icons/sidebar/stac.svg') }}">
            <span>السلوك والمواظبة</span>
        </a>
        <div id="tasks_stac" class="collapse collapse-side-admin" aria-labelledby="headingPages"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner">
                <a class="collapse-item" href="#">
                    <div class="icon_square" style="background-color:#BCD7F5;"></div>
                    بيانات المدرسة
                </a>
                <a class="collapse-item" href="#">
                    <div class="icon_square" style="background-color:#F5CBBC;"></div>
                    طلاب المدرسة
                </a>
                <a class="collapse-item" href="#">
                    <div class="icon_square" style="background-color:#F5BCBC;"></div>
                    معلمي المدرسة
                </a>
                <a class="collapse-item" href="#">
                    <div class="icon_square" style="background-color:#BDF5BC;"></div>
                    إداري المدرسة
                </a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#tasks_stac_2"
            aria-expanded="true" aria-controls="collapsePages" data-toggle="collapse" data-target=".navbar-collapse">
            <img class="sidebare_icon" alt="school" src="{{ URL::asset('img/icons/sidebar/grid_2.svg') }}">
            <span>النماذج</span>
        </a>
        <div id="tasks_stac_2" class="collapse collapse-side-admin" aria-labelledby="headingPages"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner">
                <a class="collapse-item" href="#">
                    <div class="icon_square" style="background-color:#BCD7F5;"></div>
                    بيانات المدرسة
                </a>
                <a class="collapse-item" href="#">
                    <div class="icon_square" style="background-color:#F5CBBC;"></div>
                    طلاب المدرسة
                </a>
                <a class="collapse-item" href="#">
                    <div class="icon_square" style="background-color:#F5BCBC;"></div>
                    معلمي المدرسة
                </a>
                <a class="collapse-item" href="#">
                    <div class="icon_square" style="background-color:#BDF5BC;"></div>
                    إداري المدرسة
                </a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#tasks_cards"
            aria-expanded="true" aria-controls="collapsePages" data-toggle="collapse" data-target=".navbar-collapse">
            <img class="sidebare_icon" alt="school" src="{{ URL::asset('img/icons/sidebar/cards.svg') }}">
            <span>التقارير</span>
        </a>
        <div id="tasks_cards" class="collapse collapse-side-admin" aria-labelledby="headingPages"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner">
                <a class="collapse-item" href="#">
                    <div class="icon_square" style="background-color:#BCD7F5;"></div>
                    بيانات المدرسة
                </a>
                <a class="collapse-item" href="#">
                    <div class="icon_square" style="background-color:#F5CBBC;"></div>
                    طلاب المدرسة
                </a>
                <a class="collapse-item" href="#">
                    <div class="icon_square" style="background-color:#F5BCBC;"></div>
                    معلمي المدرسة
                </a>
                <a class="collapse-item" href="#">
                    <div class="icon_square" style="background-color:#BDF5BC;"></div>
                    إداري المدرسة
                </a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#tasks_message"
            aria-expanded="true" aria-controls="collapsePages" data-toggle="collapse" data-target=".navbar-collapse">
            <img class="sidebare_icon" alt="school" src="{{ URL::asset('img/icons/sidebar/keep.svg') }}">
            <span>الرسائل والتنبيهات</span>
        </a>
        <div id="tasks_message" class="collapse collapse-side-admin" aria-labelledby="headingPages"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner">
                <a class="collapse-item" href="#">
                    <div class="icon_square" style="background-color:#BCD7F5;"></div>
                    بيانات المدرسة
                </a>
                <a class="collapse-item" href="#">
                    <div class="icon_square" style="background-color:#F5CBBC;"></div>
                    طلاب المدرسة
                </a>
                <a class="collapse-item" href="#">
                    <div class="icon_square" style="background-color:#F5BCBC;"></div>
                    معلمي المدرسة
                </a>
                <a class="collapse-item" href="#">
                    <div class="icon_square" style="background-color:#BDF5BC;"></div>
                    إداري المدرسة
                </a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#tasks_trash"
            aria-expanded="true" aria-controls="collapsePages" data-toggle="collapse" data-target=".navbar-collapse">
            <img class="sidebare_icon" alt="school" src="{{ URL::asset('img/icons/sidebar/trash.svg') }}">
            <span>سلة المحذوفات</span>
        </a>
        <div id="tasks_trash" class="collapse collapse-side-admin" aria-labelledby="headingPages"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner">
                <a class="collapse-item" href="#">
                    <div class="icon_square" style="background-color:#BCD7F5;"></div>
                    بيانات المدرسة
                </a>
                <a class="collapse-item" href="#">
                    <div class="icon_square" style="background-color:#F5CBBC;"></div>
                    طلاب المدرسة
                </a>
                <a class="collapse-item" href="#">
                    <div class="icon_square" style="background-color:#F5BCBC;"></div>
                    معلمي المدرسة
                </a>
                <a class="collapse-item" href="#">
                    <div class="icon_square" style="background-color:#BDF5BC;"></div>
                    إداري المدرسة
                </a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#tasks_sett"
            aria-expanded="true" aria-controls="collapsePages" data-toggle="collapse" data-target=".navbar-collapse">
            <img class="sidebare_icon" alt="school" src="{{ URL::asset('img/icons/sidebar/cog.svg') }}">
            <span>الاعدادات</span>
        </a>
        <div id="tasks_sett" class="collapse collapse-side-admin" aria-labelledby="headingPages"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner">
                <a class="collapse-item" href="#">
                    <div class="icon_square" style="background-color:#BCD7F5;"></div>
                    بيانات المدرسة
                </a>
                <a class="collapse-item" href="#">
                    <div class="icon_square" style="background-color:#F5CBBC;"></div>
                    طلاب المدرسة
                </a>
                <a class="collapse-item" href="#">
                    <div class="icon_square" style="background-color:#F5BCBC;"></div>
                    معلمي المدرسة
                </a>
                <a class="collapse-item" href="#">
                    <div class="icon_square" style="background-color:#BDF5BC;"></div>
                    إداري المدرسة
                </a>
            </div>
        </div>
    </li>

    <li class="nav-item mb-5">
        <a class="nav-link collapsed" href="{{ route('school_route.logout') }}" onclick="event.preventDefault();
        document.getElementById('logout_sidebar-form').submit();">
            <img class="sidebare_icon" alt="school" src="{{ URL::asset('img/icons/sidebar/logout.svg') }}">
            <span>تسجيل الخروج</span>
        </a>
        <form id="logout_sidebar-form" action="{{ route('school_route.logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </li>
</ul>
<!-- End of Sidebar -->
