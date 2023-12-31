<!DOCTYPE html>
<html data-theme="light">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/x-icon" href="{{ asset("favicon.ico") }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="{{ asset("css/page.css?v=1.0.1") }}" />
    <link type="text/css" rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset("assets/vendor/fonts/boxicons.css") }}" />
    <link rel="canonical" href="{{ URL::current() }}">
    @stack("css")
    <title>@hasSection("title")
      @yield('title')
    @else
      Edukasi 4.0
    @endif</title>
    @hasSection ('description')
      <meta name="description" content="@yield('description')">
    @endif
    <meta name="keywords" content="Education 3.0, Education 4.0, Edukasi 3.0, Edukasi 4.0, Self Improvment, Pengembangan Skill">
    <meta name="author" content="EdukasiEmpatNol" />
    @hasSection('image')
      <meta image="@yield('image')">
    @endif
    <meta property="og:type" content="article">
    @hasSection('image')
      <meta property="og:image" content="@yield('image')">
    @endif
    @hasSection("title")
      <meta property="og:title" content="@yield('title')">
    @else
      <meta property="og:title" content="Edukasi 4.0">
    @endif
    <meta property="og:site_name" content="edukasiempatnol">
    @hasSection ('description')
      <meta name="og:description" content="@yield('description')">
    @endif
    <meta property="og:url" content="{{ URL::current() }}">
  </head>

  <body>
    <header class="sticky top-0 z-20 bg-white py-6 px-[20px] md:px-[50px]">
      <div class="flex items-center justify-start md:justify-between gap-3 md:gap-0">
        <div class="inline lg:hidden drawer w-auto">
          <input id="menu-mobile" type="checkbox" class="drawer-toggle" />
          <div class="drawer-content">
            {{-- <label for="menu-mobile" class="btn btn-primary drawer-button">Open drawer</label> --}}
            <label for="menu-mobile">
              <i class='bx bx-menu' style="font-size: 30px"></i>
            </label>
          </div> 
          <div class="drawer-side">
            <label for="menu-mobile" aria-label="close sidebar" class="drawer-overlay"></label>
            <ul class="menu p-4 w-80 min-h-full bg-base-200 text-base-content">
              <li>
                <a href="/">Flash Sale</a>
              </li>
              <li>
                <a href="/course">Kelas</a>
              </li>
              <li>
                <a href="/">Challange</a>
              </li>
            </ul>
          </div>
        </div>
        <a href="/" class="flex items-center gap-2 select-none">
          <img src="{{ asset("logo.png") }}" class="w-[100px] md:w-[150px] rounded-lg" alt="logo">
        </a>
        <div class="hidden lg:flex items-center gap-10">
          <a href="/">Flash Sale</a>
          <a href="/course">Kelas</a>
          <a href="/">Challange</a>
        </div>
        <div class="hidden lg:flex {{ Auth::check() ? "gap-6" : "gap-3" }} items-center">
          @if (Auth::check())
            <div class="dropdown dropdown-end">
              <div tabindex="0" class="shadow cursor-pointer w-[40px] h-[40px] bg-secondary flex items-center justify-center rounded-full relative">
                <i class="bx bx-bell"></i>
              </div>
              <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-lg w-52 mt-2">
                <li><a>Item 1</a></li>
                <li><a>Item 2</a></li>
              </ul>
            </div>
            <div class="dropdown dropdown-end">
              <div tabindex="0" class="flex items-center select-none cursor-pointer gap-[18px]">
                <span>Halo, {{ explode(" ", Auth::user()->name)[0] }}</span>
                <div class="w-[50px] h-[50px] rounded-full overflow-hidden">
                  <img src="{{ asset(Auth::user()->photo ?? "default_user.png") }}" class="w-full h-full" alt="">
                </div>
              </div>
              <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-lg w-52 mt-2">
                <li>
                  <a href="{{ route("user.class") }}">Kelas Saya</a>
                </li>
                <li>
                  <a href="javascript:void(0)" onclick="document.querySelector('#logout').click()">Sign Out</a>
                  <form class="hidden" action="{{ route("logout") }}" method="POST">
                    @csrf
                    <button type="submit" id="logout"></button>
                  </form>
                </li>
              </ul>
            </div>
          @else
            <a href="/register" class="text-sm font-bold text-black h-10 w-28 flex items-center justify-center rounded-full bg-secondary">Sign Up</a>
            <a href="/login" class="text-sm font-bold text-black h-10 w-28 flex items-center justify-center rounded-full bg-secondary">Sign In</a>
          @endif
        </div>
      </div>
    </header>
    @yield("content")
    @stack('js')
    <footer class="bg-white p-[50px] px-[20px] md:px-[50px]">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div>
          <a href="/" class="flex items-center gap-2 select-none">
            <img src="{{ asset("logo.png") }}" class="w-[100px] md:w-[150px] rounded-lg" alt="logo">
          </a>
          <div class="mt-3 text-black">
            Tingkatkan kompetensi dan keterampilan melalui berbagai fitur unggulan, mulai dari mengakses kursus, live webinar, membaca e-book, diskusi di forum hingga private mentoring dengan para ahli.
          </div>
        </div>
        <div class="flex justify-end">
          <div class="w-full md:w-1/2">
            <div class="text-lg font-bold mb-5">Kontak</div>
            <div class="mb-3">Ruko Inkopal, Kramat Raya, Senen, Jakarta Pusat, Jakarta 10450</div>
            <div class="mb-1">cs@edukasiempatnol.com</div>
            <div>+6281911777742</div>
          </div>
        </div>
      </div>
    </footer>
  </body>
</html>