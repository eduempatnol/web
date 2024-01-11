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
          <span class="text-xl md:text-2xl">Sign Up</span>
          @if (Session::has("error"))
            <div class="px-5 py-3 w-full rounded-lg text-sm bg-red-500 text-white font-bold mt-5">
              {{ Session::get("error") }}
            </div>
          @endif
          <div role="tablist" class="tabs tabs-bordered {{ Session::has("error") ? "mt-5" : "mt-8" }} w-full">
            {{-- Student --}}
            <input type="radio" name="register" role="tab" class="tab" onclick="resetForm()" aria-label="Pelajar" checked />
            <div role="tabpanel" class="tab-content">
              <form class="mt-7" method="POST" action="{{ route("register") }}">
                @csrf
                <input type="hidden" name="type" value="student">
                <div class="flex flex-col gap-1 text-black">
                  <label for="name">Nama (maks. 50 karakter)</label>
                  <input type="text" class="outline-none text-sm border py-2.5 px-3 rounded-lg" name="name" autocomplete="off" placeholder="My Education 4.0">
                </div>
                <div class="flex flex-col gap-1 text-black mt-4 text-black">
                  <label for="email">Email address</label>
                  <input type="text" class="outline-none text-sm border py-2.5 px-3 rounded-lg" name="email" autocomplete="off" placeholder="example@edukasi.com">
                </div>
                <div class="flex flex-col gap-1 mt-4 text-black">
                  <label for="email">Password</label>
                  <input
                    type="password"
                    class="outline-none text-sm border py-2.5 px-3 rounded-lg"
                    name="password"
                    autocomplete="off"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                  >
                </div>
                <div class="mt-8">
                  <button class="w-full bg-primary text-white font-semibold py-3 rounded-lg">Sign Up</button>
                </div>
              </form>
            </div>
            {{-- Instuctor --}}
            <input type="radio" name="register" role="tab" class="tab" onclick="resetForm()" aria-label="Instruktur" />
            <div role="tabpanel" class="tab-content">
              <form class="mt-7" method="POST" action="{{ route("register") }}">
                @csrf
                <input type="hidden" name="type" value="instructor">
                <div class="flex flex-col gap-1 text-black">
                  <label for="name">Nama (maks. 50 karakter)</label>
                  <input type="text" class="outline-none text-sm border py-2.5 px-3 rounded-lg" name="name" autocomplete="off" placeholder="Edukasi Empat Nol">
                </div>
                <div class="flex flex-col gap-1 text-black mt-4 text-black">
                  <label for="email">Email address</label>
                  <input type="text" class="outline-none text-sm border py-2.5 px-3 rounded-lg" name="email" autocomplete="off" placeholder="example@edukasi.com">
                </div>
                <div class="flex flex-col gap-1 mt-4 text-black">
                  <label for="email">Password</label>
                  <input
                    type="password"
                    class="outline-none text-sm border py-2.5 px-3 rounded-lg"
                    name="password"
                    autocomplete="off"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                  >
                </div>
                <div class="mt-8">
                  <button class="w-full bg-primary text-white font-semibold py-3 rounded-lg">Sign Up</button>
                </div>
              </form>
            </div>
            {{-- Organization --}}
            <input type="radio" name="register" role="tab" class="tab" onclick="resetForm()" aria-label="Organisasi" />
            <div role="tabpanel" class="tab-content">
              <form class="mt-7" method="POST" action="{{ route("register") }}">
                @csrf
                <input type="hidden" name="type" value="organization">
                <div class="flex flex-col gap-1 text-black">
                  <label for="name">Nama (maks. 50 karakter)</label>
                  <input type="text" class="outline-none text-sm border py-2.5 px-3 rounded-lg" name="name" autocomplete="off" placeholder="Edukasi Empat Nol">
                </div>
                <div class="flex flex-col gap-1 text-black mt-4 text-black">
                  <label for="email">Email address</label>
                  <input type="text" class="outline-none text-sm border py-2.5 px-3 rounded-lg" name="email" autocomplete="off" placeholder="example@edukasi.com">
                </div>
                <div class="flex flex-col gap-1 mt-4 text-black">
                  <label for="email">Password</label>
                  <input
                    type="password"
                    class="outline-none text-sm border py-2.5 px-3 rounded-lg"
                    name="password"
                    autocomplete="off"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                  >
                </div>
                <div class="border-t my-5"></div>
                <div class="flex flex-col gap-1 text-black">
                  <label for="organization_name">Nama Organisasi</label>
                  <input type="text" class="outline-none text-sm border py-2.5 px-3 rounded-lg" name="organization_name" autocomplete="off" placeholder="My Education 4.0">
                </div>
                <div class="flex flex-col gap-1 text-black mt-4">
                  <label for="organization_address">Alamat</label>
                  <input type="text" class="outline-none text-sm border py-2.5 px-3 rounded-lg" name="organization_address" autocomplete="off" placeholder="Jl. Edukasi Empat Nol No. 01">
                </div>
                <div class="flex flex-col gap-1 text-black mt-4">
                  <label for="organization_contact">Kontak</label>
                  <input type="text" class="outline-none text-sm border py-2.5 px-3 rounded-lg" name="organization_contact" autocomplete="off" placeholder="+628123456789">
                </div>
                <div class="mt-8">
                  <button class="w-full bg-primary text-white font-semibold py-3 rounded-lg">Sign Up</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>

  <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
  <script>
    function resetForm() {
      $("form")[0].reset();
    }
  </script>
</html>