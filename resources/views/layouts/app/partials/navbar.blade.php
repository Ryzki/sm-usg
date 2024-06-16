<header class="navbar-expand-md">
    <div class="collapse navbar-collapse" id="navbar-menu">
        <div class="navbar">
            <div class="container-xl">
                @if (Auth::user()->verified)
                    <ul class="navbar-nav">
                        @can('PregnantMother')
                            <li class="nav-item {{ Route::is('user.dashboard') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('user.dashboard') }}">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-home">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                                            <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                            <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">
                                        Dashboard
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item {{ Route::is('user.check-anc*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('user.check-anc.index') }}">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-body-scan">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M4 8v-2a2 2 0 0 1 2 -2h2" />
                                            <path d="M4 16v2a2 2 0 0 0 2 2h2" />
                                            <path d="M16 4h2a2 2 0 0 1 2 2v2" />
                                            <path d="M16 20h2a2 2 0 0 0 2 -2v-2" />
                                            <path d="M12 8m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                            <path d="M10 17v-1a2 2 0 1 1 4 0v1" />
                                            <path d="M8 10c.666 .666 1.334 1 2 1h4c.666 0 1.334 -.334 2 -1" />
                                            <path d="M12 11v3" />
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">
                                        Kunjungan ANC
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item {{ Route::is('user.schedule-supplement*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('user.schedule-supplement.index') }}">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-pill">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M4.5 12.5l8 -8a4.94 4.94 0 0 1 7 7l-8 8a4.94 4.94 0 0 1 -7 -7" />
                                            <path d="M8.5 8.5l7 7" />
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">
                                        Jadwal TTD
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item {{ Route::is('user.chat*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('user.chat.index') }}">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block ">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-message">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M8 9h8" />
                                            <path d="M8 13h6" />
                                            <path
                                                d="M18 4a3 3 0 0 1 3 3v8a3 3 0 0 1 -3 3h-5l-5 3v-3h-2a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12z" />
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">
                                        Konsultasi
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item {{ Route::is('user.education*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('user.education.index') }}">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block ">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-vocabulary">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M10 19h-6a1 1 0 0 1 -1 -1v-14a1 1 0 0 1 1 -1h6a2 2 0 0 1 2 2a2 2 0 0 1 2 -2h6a1 1 0 0 1 1 1v14a1 1 0 0 1 -1 1h-6a2 2 0 0 0 -2 2a2 2 0 0 0 -2 -2z" />
                                            <path d="M12 5v16" />
                                            <path d="M7 7h1" />
                                            <path d="M7 11h1" />
                                            <path d="M16 7h1" />
                                            <path d="M16 11h1" />
                                            <path d="M16 15h1" />
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">
                                        Edukasi Ibu Hamil
                                    </span>
                                </a>
                            </li>
                        @endcan
                        @can('Midwife')
                            <li class="nav-item {{ Route::is('midwife.dashboard') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('midwife.dashboard') }}">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-home">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                                            <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                            <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">
                                        Dashboard
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item {{ Route::is('midwife.control-users*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('midwife.control-users.index') }}">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-users">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                            <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                            <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">
                                        Kontrol Ibu Hamil
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item {{ Route::is('midwife.schedule-users*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('midwife.schedule-users.index') }}">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-time">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M11.795 21h-6.795a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v4" />
                                            <path d="M18 18m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                            <path d="M15 3v4" />
                                            <path d="M7 3v4" />
                                            <path d="M3 11h16" />
                                            <path d="M18 16.496v1.504l1 1" />
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">
                                        Penjadwalan Kunjungan ANC
                                    </span>
                                </a>
                            </li>
                        @endcan
                        @can('Doctor')
                            <li class="nav-item {{ Route::is('doctor.dashboard') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('doctor.dashboard') }}">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-home">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                                            <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                            <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">
                                        Dashboard
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item {{ Route::is('doctor.control_all_users') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('doctor.control_all_users') }}">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-users">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                            <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                            <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">
                                        Kontrol Ibu Hamil
                                    </span>
                                </a>
                            </li>
                        @endcan
                        @can('Admin')
                            <li class="nav-item {{ Route::is('admin.dashboard') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-home">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                                            <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                            <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">
                                        Dashboard
                                    </span>
                                </a>
                            </li>
                            <li
                                class="nav-item dropdown {{ Route::is(['admin.users*', 'admin.sub-district*']) ? 'active' : '' }}">
                                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"
                                    data-bs-auto-close="outside" role="button" aria-expanded="false">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-database">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M12 6m-8 0a8 3 0 1 0 16 0a8 3 0 1 0 -16 0" />
                                            <path d="M4 6v6a8 3 0 0 0 16 0v-6" />
                                            <path d="M4 12v6a8 3 0 0 0 16 0v-6" />
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">
                                        Data Master
                                    </span>
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item {{ Route::is('admin.users*') ? 'active' : '' }}"
                                        href="{{ route('admin.users.index') }}">
                                        Data Pengguna
                                    </a>
                                    <a class="dropdown-item {{ Route::is('admin.sub-district*') ? 'active' : '' }}"
                                        href="{{ route('admin.sub-district.index') }}">
                                        Data Kelurahan
                                    </a>
                                    <a class="dropdown-item {{ Route::is('admin.areas*') ? 'active' : '' }}"
                                        href="{{ route('admin.areas.index') }}">
                                        Data Daerah
                                    </a>
                                    <a class="dropdown-item {{ Route::is('admin.midwife_areas*') ? 'active' : '' }}"
                                        href="{{ route('admin.midwife_areas.index') }}">
                                        Data Pemetaan Bidan
                                    </a>
                                    <a class="dropdown-item {{ Route::is('admin.preeclampsia*') ? 'active' : '' }}"
                                        href="{{ route('admin.preeclampsia.index') }}">
                                        Data Kategori Preklamsia
                                    </a>
                                </div>
                            </li>
                        @endcan
                        @cannot('PregnantMother')
                            <li class="nav-item {{ Route::is('education*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('education.index') }}">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-book">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M3 19a9 9 0 0 1 9 0a9 9 0 0 1 9 0" />
                                            <path d="M3 6a9 9 0 0 1 9 0a9 9 0 0 1 9 0" />
                                            <path d="M3 6l0 13" />
                                            <path d="M12 6l0 13" />
                                            <path d="M21 6l0 13" />
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">
                                        Data Materi
                                    </span>
                                </a>
                            </li>
                        @endcannot
                    </ul>
                @else
                    <ul class="navbar-nav">
                        <li class="nav-item {{ Route::is('verification') ? 'active' : '' }}">
                            <a class="nav-link" href="#">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-user-scan">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M10 9a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                        <path d="M4 8v-2a2 2 0 0 1 2 -2h2" />
                                        <path d="M4 16v2a2 2 0 0 0 2 2h2" />
                                        <path d="M16 4h2a2 2 0 0 1 2 2v2" />
                                        <path d="M16 20h2a2 2 0 0 0 2 -2v-2" />
                                        <path d="M8 16a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">
                                    Verikasi Pengguna
                                </span>
                            </a>
                        </li>
                    </ul>
                @endif
            </div>
        </div>
    </div>
</header>
