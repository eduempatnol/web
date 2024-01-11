<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="/assets/">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Dashboard @yield('title')</title>
    <meta name="description" content="" />
    <link rel="icon" type="image/x-icon" href="{{ asset("favicon.ico") }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="{{ asset("assets/vendor/fonts/boxicons.css") }}" />
    <link rel="stylesheet" href="{{ asset("assets/vendor/css/core.css") }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset("assets/vendor/css/theme-default.css") }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset("assets/css/demo.css") }}" />
    <link rel="stylesheet" href="{{ asset("assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css") }}" />
    <link rel="stylesheet" href="{{ asset("assets/vendor/libs/apex-charts/apex-charts.css") }}" />
    <script src="{{ asset("assets/vendor/js/helpers.js") }}"></script>
    <script src="{{ asset("assets/js/config.js") }}"></script>
    @stack('css')
  </head>
  <body>
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo mb-3 d-flex justify-content-center align-items-center">
            <a href="{{ route("login") }}" class="app-brand-link">
              <img src="{{ asset("logo.png") }}" class="img-fluid" alt="logo">
            </a>
            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
              <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
          </div>
          <div class="menu-inner-shadow"></div>
          <ul class="menu-inner py-1">
            <li class="menu-item @yield("dashboard")">
              <a href="{{ route("login") }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div>Dashboard</div>
              </a>
            </li>
            @if (Auth::user()->role->role_slug == "administrator")
              <li class="menu-item @yield("mentoring")">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                  <i class="menu-icon tf-icons bx bx-layout"></i>
                  <div data-i18n="Layouts">Mentoring</div>
                </a>
                <ul class="menu-sub">
                  {{-- <li class="menu-item @yield("mentoring.category")">
                    <a href="{{ route("mentoring.category") }}" class="menu-link">
                      <div data-i18n="Without menu">Category</div>
                    </a>
                  </li> --}}
                  <li class="menu-item @yield("mentoring.schedule")">
                    <a href="{{ route("mentoring.schedule") }}" class="menu-link">
                      <div data-i18n="Without menu">Jadwal Mentoring</div>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="menu-item @yield("settings")">
                <a href="{{ route("admin.settings") }}" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-wrench"></i>
                  <div>Settings</div>
                </a>
              </li>
              <li class="menu-item @yield("admin.instructors")">
                <a href="{{ route("admin.instructors") }}" class="menu-link">
                  <i class='menu-icon tf-icons bx bx-ghost'></i>
                  <div>Instruktur</div>
                </a>
              </li>
            @endif
            @if (Auth::user()->role->role_slug == "instructor")
              <li class="menu-item @yield("courses")">
                <a href="{{ route("instructor.courses") }}" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-book-reader"></i>
                  <div>Kursus</div>
                </a>
              </li>
              <li class="menu-item @yield("transaction")">
                <a href="{{ route("instructor.transaction") }}" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-spreadsheet"></i>
                  <div>Transaksi Kelas</div>
                </a>
              </li>
              <li class="menu-item @yield("transaction.mentoring")">
                <a href="{{ route("instructor.transaction.mentoring") }}" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-spreadsheet"></i>
                  <div>Transaksi Mentoring</div>
                </a>
              </li>
            @endif
            @if (Auth::user()->role->role_slug == "user")
              <li class="menu-item @yield("class")">
                <a href="{{ route("user.class") }}" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-book-bookmark"></i>
                  <div>Kelasku</div>
                </a>
              </li>
            @endif
          </ul>
        </aside>
        <div class="layout-page">
          <nav
            class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
            id="layout-navbar"
          >
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
              </a>
            </div>
            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
              <div class="navbar-nav align-items-center">
              </div>
              <ul class="navbar-nav flex-row align-items-center ms-auto">
                <li class="nav-item lh-1 me-3"></li>
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                      <img src="{{ asset("/assets/img/avatars/1.png") }}" alt class="w-px-40 h-auto rounded-circle" />
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item" href="#">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-online">
                              <img src="{{ asset("/assets/img/avatars/1.png") }}" alt class="w-px-40 h-auto rounded-circle" />
                            </div>
                          </div>
                          <div class="flex-grow-1">
                            <span class="fw-semibold d-block">{{ Auth::user()->name }}</span>
                            <small class="text-muted">{{ Auth::user()->role->role_name }}</small>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="#">
                        <i class="bx bx-user me-2"></i>
                        <span class="align-middle">My Profile</span>
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="#">
                        <i class="bx bx-cog me-2"></i>
                        <span class="align-middle">Settings</span>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="javascript:void(0)" onclick="document.querySelector('#logout').click()">
                        <i class="bx bx-power-off me-2"></i>
                        <span class="align-middle">Log Out</span>
                      </a>
                      <form class="d-none" action="{{ route("logout") }}" method="POST">
                        @csrf
                        <button type="submit" id="logout"></button>
                      </form>
                    </li>
                  </ul>
                </li>
              </ul>
            </div>
          </nav>
          <div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">
              @yield("content")
            </div>
            <footer class="content-footer footer bg-footer-theme">
              <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                <div class="mb-2 mb-md-0">
                  ©
                  <script>
                    document.write(new Date().getFullYear());
                  </script>
                  , made with ❤️
                </div>
                <div>
                  <a href="https://themeselection.com/license/" class="footer-link me-4" target="_blank">License</a>
                  <a
                    href="https://github.com/themeselection/sneat-html-admin-template-free/issues"
                    target="_blank"
                    class="footer-link me-4"
                    >Support</a
                  >
                </div>
              </div>
            </footer>
            <div class="content-backdrop fade"></div>
          </div>
        </div>
      </div>
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>

    <script src="{{ asset("assets/vendor/libs/jquery/jquery.js") }}"></script>
    <script src="{{ asset("assets/vendor/libs/popper/popper.js") }}"></script>
    <script src="{{ asset("assets/vendor/js/bootstrap.js") }}"></script>
    <script src="{{ asset("assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js") }}"></script>
    <script src="{{ asset("assets/vendor/js/menu.js") }}"></script>
    <script src="{{ asset("assets/vendor/libs/apex-charts/apexcharts.js") }}"></script>
    <script src="{{ asset("assets/js/main.js") }}"></script>
    <script src="{{ asset("assets/js/dashboards-analytics.js") }}"></script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    @stack('js')
  </body>
</html>
