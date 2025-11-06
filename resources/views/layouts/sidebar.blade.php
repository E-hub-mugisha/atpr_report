<div class="nk-sidebar nk-sidebar-fixed is-dark" data-content="sidebarMenu">
        <div class="nk-sidebar-element nk-sidebar-head">
                <div class="nk-menu-trigger">
                        <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu">
                                <em class="icon ni ni-arrow-left"></em>
                        </a>
                        <a href="#" class="nk-nav-compact nk-quick-nav-icon d-none d-xl-inline-flex" data-target="sidebarMenu">
                                <em class="icon ni ni-menu"></em>
                        </a>
                </div>
                <div class="nk-sidebar-brand">
                        <a href="{{ route('courses.index') }}" class="logo-link nk-sidebar-logo">
                                <img class="logo-light logo-img" src="images/logo.png" alt="logo">
                                <img class="logo-dark logo-img" src="images/logo-dark.png" alt="logo-dark">
                        </a>
                </div>
        </div>

        <div class="nk-sidebar-element nk-sidebar-body">
                <div class="nk-sidebar-content">
                        <div class="nk-sidebar-menu" data-simplebar>
                                <ul class="nk-menu">

                                        <!-- Dashboard -->
                                        <li class="nk-menu-heading">
                                                <h6 class="overline-title text-primary-alt">Dashboard</h6>
                                        </li>
                                        <li class="nk-menu-item">
                                                <a href="{{ route('courses.index') }}" class="nk-menu-link">
                                                        <span class="nk-menu-icon"><em class="icon ni ni-dashlite"></em></span>
                                                        <span class="nk-menu-text">Dashboard</span>
                                                </a>
                                        </li>

                                        <!-- Courses & Modules -->
                                        <li class="nk-menu-heading">
                                                <h6 class="overline-title text-primary-alt">Courses & Modules</h6>
                                        </li>

                                        <!-- Courses & Modules -->
                                        @foreach($courses as $course)
                                        <li class="nk-menu-item has-sub">
                                                <a href="#" class="nk-menu-link nk-menu-toggle" title="{{ $course->name }}">
                                                        <span class="nk-menu-icon"><em class="icon ni ni-book"></em></span>
                                                        <span class="nk-menu-text">{{ Str::limit($course->name, 15) }}</span>
                                                </a>
                                                <ul class="nk-menu-sub">
                                                        @foreach($course->modules as $module)
                                                        <li class="nk-menu-item has-sub">
                                                                <a href="#" class="nk-menu-link nk-menu-toggle" title="{{ $module->title }}">
                                                                        {{ Str::limit($module->title, 20) }}
                                                                </a>
                                                                @if($module->lessons->count())
                                                                <ul class="nk-menu-sub">
                                                                        @foreach($module->lessons as $lesson)
                                                                        <li class="nk-menu-item">
                                                                                <a href="{{ route('modules.lessons.show', [$module->id, $lesson->id]) }}"
                                                                                        class="nk-menu-link"
                                                                                        title="{{ $lesson->title }}">
                                                                                        {{ Str::limit($lesson->lesson_code, 20) }}
                                                                                </a>
                                                                        </li>
                                                                        @endforeach
                                                                </ul>
                                                                @endif
                                                        </li>
                                                        @endforeach
                                                </ul>
                                        </li>
                                        @endforeach


                                        <!-- Students -->
                                        <li class="nk-menu-heading">
                                                <h6 class="overline-title text-primary-alt">Students & Trainers</h6>
                                        </li>
                                        <li class="nk-menu-item">
                                                <a href="{{ route('students.index') }}" class="nk-menu-link">
                                                        <span class="nk-menu-icon"><em class="icon ni ni-users"></em></span>
                                                        <span class="nk-menu-text">Students</span>
                                                </a>
                                        </li>
                                        <li class="nk-menu-item">
                                                <a href="{{ route('trainers.index') }}" class="nk-menu-link">
                                                        <span class="nk-menu-icon"><em class="icon ni ni-user-check"></em></span>
                                                        <span class="nk-menu-text">Trainers</span>
                                                </a>
                                        </li>

                                        <!-- Reports -->
                                        <li class="nk-menu-heading">
                                                <h6 class="overline-title text-primary-alt">Reports & Assessments</h6>
                                        </li>
                                        <li class="nk-menu-item has-sub">
                                                <a href="#" class="nk-menu-link nk-menu-toggle">
                                                        <span class="nk-menu-icon"><em class="icon ni ni-file-text"></em></span>
                                                        <span class="nk-menu-text">Reports</span>
                                                </a>
                                                <ul class="nk-menu-sub">
                                                        <li class="nk-menu-item">
                                                                <a href="{{ route('reports.index') }}" class="nk-menu-link">All Reports</a>
                                                        </li>
                                                        <li class="nk-menu-item">
                                                                <a href="{{ route('reports.uploadForm') }}" class="nk-menu-link">Upload Report</a>
                                                        </li>
                                                        <li class="nk-menu-item">
                                                                <a href="{{ route('students.report') }}" class="nk-menu-link">Student Marks Report</a>
                                                        </li>
                                                </ul>
                                        </li>

                                </ul>
                        </div>
                </div>
        </div>
</div>