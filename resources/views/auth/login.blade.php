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
    <title>Masuk Edukasi 4.0</title>
    <meta name="keywords" content="Education 3.0, Education 4.0, Edukasi 3.0, Edukasi 4.0, Self Improvment, Pengembangan Skill">
    <meta name="author" content="EdukasiEmpatNol" />
    <meta property="og:type" content="article">
    <meta property="og:image" content="{{ asset("favicon.jpg") }}">
    <meta property="og:title" content="Edukasi 4.0">
    <meta property="og:site_name" content="edukasiempatnol">
    <meta property="og:url" content="{{ URL::current() }}">
  </head>

  <body>
    <div class="min-h-screen flex justify-center items-center px-5 select-none">
      <div class="w-full max-w-[480px]">
        <div class="py-[36px] px-[31px] bg-white rounded-lg mt-3 md:mt-5">
          <div class="flex justify-center mb-10">
            <img src="{{ asset("logo.png") }}" class="w-[100px] md:w-[150px] rounded-lg" alt="logo">
          </div>
          <span class="text-xl md:text-2xl">Sign In</span>
          <form class="mt-8" method="POST" action="{{ route("login") }}">
            @if (Session::has("success"))
              <div class="px-5 py-3 w-full rounded-lg text-sm bg-success text-white font-bold mb-3">
                {{ Session::get("success") }}
              </div>
            @endif
            @if (Session::has("error"))
              <div class="px-5 py-3 w-full rounded-lg text-sm bg-red-500 text-white font-bold mb-3">
                {{ Session::get("error") }}
              </div>
            @endif
            @csrf
            <div class="flex flex-col gap-1 text-black">
              <label for="email">Email</label>
              <input type="text" class="outline-none text-sm border py-2.5 px-3 rounded-lg" name="email" autocomplete="off" placeholder="example@edukasi.com" autofocus>
            </div>
            <div class="flex flex-col gap-1 mt-4 text-black">
              <label for="email">Password</label>
              <input type="password" class="outline-none text-sm border py-2.5 px-3 rounded-lg" name="password" autocomplete="off" placeholder="example@edukasi.com">
            </div>
            <div class="mt-8">
              <button class="w-full bg-primary text-white font-semibold py-3 rounded-lg">Sign In</button>
              <div class="text-center text-sm mt-3">
                <span class="text-black">Belum punya akun?</span>
                <a href="{{ route("register") }}" class="text-primary">Daftar disini</a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </body>
</html>