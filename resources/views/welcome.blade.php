@extends("layouts.pagelayout")
@section("title", "Edukasi 4.0")
@section("description", "Temukan kelas yang kamu inginkan disini")
@section("image", asset("favicon.jpg"))

@push('css')
<link rel="stylesheet" href="{{ asset("css/slick.css") }}">
<link rel="stylesheet" href="{{ asset("css/slick-theme.css") }}">
@endpush

@section("content")
<div class="w-full overflow-hidden relative h-[480px]">
  <div class="banner w-full">
    <div class="w-full overflow-hidden">
      <img src="{{ asset("static/banner1.jpg") }}" class="w-full h-[480px] object-cover" alt="banner">
    </div>
    <div class="w-full overflow-hidden">
      <img src="{{ asset("static/banner2.jpg") }}" class="w-full h-[480px] object-cover" alt="banner">
    </div>
  </div>
  <div class="absolute top-0 right-0 bottom-0 left-0 bg-bannerbgsection">
    <div class="w-full h-full flex flex-col items-center justify-center px-3">
      <h1 class="text-white font-bold text-4xl text-center">Kembangkan Skillmu <br /> Dengan Edukasi 4.0</h1>
      <div class="text-center mt-10">
        <a href="/register" class="bg-primary text-white px-5 py-3 rounded-full font-bold">Daftar Sekarang</a>
      </div>
    </div>
  </div>
</div>
{{-- section popular --}}
@if (count($courses))
  <div class="w-full container px-3 md:px-10 xl:px-28 py-10 lg:py-20">
    <h3 class="text-2xl font-bold">Kelas Unggulan Edukasi 4.0</h3>
    <div class="popular-class relative mt-5">
      @foreach ($courses as $course)
        <div class="px-1.5">
          <div class="bg-white rounded-lg overflow-hidden cursor-pointer select-none" onclick="goToCourse('{{ route('course.detail', $course->course_slug) }}')">
            <img src="{{ asset($course->course_thumbnail) }}" class="w-full h-[160px] object-cover object-top" alt="{{ $course->course_title }}">
            <div class="p-[16px]">
              <h3 class="text-lg font-bold text-black text-2line mb-3">{{ $course->course_title }}</h3>
              <span class="text-gray-400">Rp {{ number_format($course->course_price, 0, ",", ".") }}</span>
            </div>
          </div>
        </div>
      @endforeach
    </div>
    <div class="arrow-popular relative">
      <button class="prev-btn absolute bg-white w-[40px] h-[40px] shadow rounded-full left-[-5px] md:left-[-15px] top-[-160px]">
        <i class='bx bx-chevron-left'></i>
      </button>
      <button class="next-btn absolute bg-white w-[40px] h-[40px] shadow rounded-full right-[-5px] md:right-[-15px] top-[-160px]">
        <i class='bx bx-chevron-right' ></i>
      </button>
    </div>
  </div>
@endif
{{-- section community --}}
<div class="w-full bg-primary px-3 md:px-10 xl:px-28 py-10 lg:py-20">
  <div class="flex flex-col md:flex-row justify-between items-center gap-10 overflow-hidden">
    <div>
      <div class="text-black font-semibold">Trusted By 900K+ Students</div>
      <div class="text-white font-bold text-3xl my-3">Join Our Supportive <br /> Community</div>
      <div class="text-white text-sm">Edukasi 4.0 menyediakan komunitas belajar UI/UX <br /> design & Web Development untuk pemula ke mahir</div>
    </div>
    <div class="w-full md:w-2/3">
      <div class="community-top">
        <div class="px-1.5">
          <div class="bg-white p-4 rounded-lg">
            <div class="font-semibold">Berkualitas Tinggi</div>
            <div class="text-sm py-3">Banyak ilmu dari Edukasi 4.0 yang terbaru modal bekerja.</div>
            <div class="flex items-center gap-2">
              <img src="{{ asset("default_user.png") }}" class="w-[30px] h-[30px] rounded-full" alt="">
              <span class="text-sm font-bold">Aqil</span>
            </div>
          </div>
        </div>
        <div class="px-1.5">
          <div class="bg-white p-4 rounded-lg">
            <div class="font-semibold">Always Up to Date</div>
            <div class="text-sm py-3">Edukasi 4.0 memberikan materi kelas dengan tools terbaru.</div>
            <div class="flex items-center gap-2">
              <img src="{{ asset("default_user.png") }}" class="w-[30px] h-[30px] rounded-full" alt="">
              <span class="text-sm font-bold">Edi</span>
            </div>
          </div>
        </div>
        <div class="px-1.5">
          <div class="bg-white p-4 rounded-lg">
            <div class="font-semibold">Hemat Waktu</div>
            <div class="text-sm py-3">Materi design & development mudah dipahami.</div>
            <div class="flex items-center gap-2">
              <img src="{{ asset("default_user.png") }}" class="w-[30px] h-[30px] rounded-full" alt="">
              <span class="text-sm font-bold">Evita</span>
            </div>
          </div>
        </div>
        <div class="px-1.5">
          <div class="bg-white p-4 rounded-lg">
            <div class="font-semibold">Berkualitas Tinggi</div>
            <div class="text-sm py-3">Banyak ilmu dari Edukasi 4.0 yang terbaru modal bekerja.</div>
            <div class="flex items-center gap-2">
              <img src="{{ asset("default_user.png") }}" class="w-[30px] h-[30px] rounded-full" alt="">
              <span class="text-sm font-bold">Aqil</span>
            </div>
          </div>
        </div>
      </div>
      <div class="community-bot rotate-180 mt-3">
        <div class="px-1.5 rotate-180">
          <div class="bg-white p-4 rounded-lg">
            <div class="font-semibold">Berkualitas Tinggi</div>
            <div class="text-sm py-3">Banyak ilmu dari Edukasi 4.0 yang terbaru modal bekerja.</div>
            <div class="flex items-center gap-2">
              <img src="{{ asset("default_user.png") }}" class="w-[30px] h-[30px] rounded-full" alt="">
              <span class="text-sm font-bold">Aqil</span>
            </div>
          </div>
        </div>
        <div class="px-1.5 rotate-180">
          <div class="bg-white p-4 rounded-lg">
            <div class="font-semibold">Always Up to Date</div>
            <div class="text-sm py-3">Edukasi 4.0 memberikan materi kelas dengan tools terbaru.</div>
            <div class="flex items-center gap-2">
              <img src="{{ asset("default_user.png") }}" class="w-[30px] h-[30px] rounded-full" alt="">
              <span class="text-sm font-bold">Edi</span>
            </div>
          </div>
        </div>
        <div class="px-1.5 rotate-180">
          <div class="bg-white p-4 rounded-lg">
            <div class="font-semibold">Hemat Waktu</div>
            <div class="text-sm py-3">Materi design & development mudah dipahami.</div>
            <div class="flex items-center gap-2">
              <img src="{{ asset("default_user.png") }}" class="w-[30px] h-[30px] rounded-full" alt="">
              <span class="text-sm font-bold">Evita</span>
            </div>
          </div>
        </div>
        <div class="px-1.5 rotate-180">
          <div class="bg-white p-4 rounded-lg">
            <div class="font-semibold">Berkualitas Tinggi</div>
            <div class="text-sm py-3">Banyak ilmu dari Edukasi 4.0 yang terbaru modal bekerja.</div>
            <div class="flex items-center gap-2">
              <img src="{{ asset("default_user.png") }}" class="w-[30px] h-[30px] rounded-full" alt="">
              <span class="text-sm font-bold">Aqil</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
{{-- section mentor --}}
<div class="w-full container px-3 md:px-10 xl:px-28 py-10 lg:py-20">
  <div class="flex justify-center flex-col md:flex-row gap-10">
    <img src="{{ asset("static/mentoring.jpg") }}" class="w-full md:w-[368px] object-cover rounded-lg" alt="mentoring">
    <div>
      <div class="text-lg text-green-500 font-semibold">Sharing is Caring.</div>
      <div class="text-3xl font-bold mt-2 mb-5">Gabung Sebagai Mentor. <br /> Bagikan Skills & Pengalamanmu.</div>
      <div class="flex flex-col gap-2">
        <div class="flex items-center gap-3">
          <div class="w-[24px]">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <circle cx="12" cy="12" r="12" fill="#DEF6EE"/>
              <path d="M7 12L10.1579 15L17 9" stroke="#22C58B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>
          <div>Meningkatkan personal branding</div>
        </div>
        <div class="flex items-center gap-3">
          <div class="w-[24px]">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <circle cx="12" cy="12" r="12" fill="#DEF6EE"/>
              <path d="M7 12L10.1579 15L17 9" stroke="#22C58B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>
          <div>Menambah sumber income</div>
        </div>
        <div class="flex items-center gap-3">
          <div class="w-[24px]">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <circle cx="12" cy="12" r="12" fill="#DEF6EE"/>
              <path d="M7 12L10.1579 15L17 9" stroke="#22C58B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>
          <div>Menambah networking terbaru</div>
        </div>
        <div class="flex items-center gap-3">
          <div class="w-[24px]">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <circle cx="12" cy="12" r="12" fill="#DEF6EE"/>
              <path d="M7 12L10.1579 15L17 9" stroke="#22C58B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>
          <div>Mendapatkan projek freelance</div>
        </div>
        <div class="flex items-center gap-3">
          <div class="w-[24px]">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <circle cx="12" cy="12" r="12" fill="#DEF6EE"/>
              <path d="M7 12L10.1579 15L17 9" stroke="#22C58B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>
          <div>Privileges menarik mentor lainnya</div>
        </div>
      </div>
      <div class="mt-10">
        <a href="/register" class="bg-primary font-semibold py-3 px-6 rounded-full text-white">Daftar Sekarang</a>
      </div>
    </div>
  </div>
</div>
@endsection

@push("js")
<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
<script src="{{ asset("js/slick.min.js") }}"></script>

<script>
  $(document).ready(function(){
    $('.banner').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 4000,
      speed: 2000
    });
    $('.popular-class').slick({
      slidesToShow: 4,
      slidesToScroll: 1,
      autoplay: false,
      speed: 1000,
      infinite: true,
      loop: true,
      draggable: false,
      arrows: false,
      responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 1,
          }
        },
        {
          breakpoint: 600,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }
      ]
    });
    $(".prev-btn").click(function () {
      $(".popular-class").slick("slickPrev");
    });
    $(".next-btn").click(function () {
      $(".popular-class").slick("slickNext");
    });

    $('.community-top').slick({
      slidesToShow: 3,
      slidesToScroll: 1,
      autoplay: true,
      speed: 1000,
      infinite: true,
      loop: true,
      arrows: false,
      responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 1,
          }
        },
        {
          breakpoint: 600,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }
      ]
    });
    $('.community-bot').slick({
      slidesToShow: 3,
      slidesToScroll: 1,
      autoplay: true,
      speed: 1000,
      infinite: true,
      loop: true,
      arrows: false,
      responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 1,
          }
        },
        {
          breakpoint: 600,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }
      ]
    });
});

  function goToCourse(paramUrl) {
    return location.href = paramUrl;
  }
</script>
@endpush