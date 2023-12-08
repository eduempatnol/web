<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/x-icon" href="{{ asset("favicon.ico") }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="{{ asset("css/page.css") }}" />
    <link type="text/css" rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset("assets/vendor/fonts/boxicons.css") }}" />
    <link rel="canonical" href="{{ URL::current() }}">
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
    <meta property="og:type" content="article">
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
    @yield("content")
    @stack('js')
  </body>
</html>