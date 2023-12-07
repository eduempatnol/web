@extends("layouts.pagelayout")
@section("title", $course->course_title)

@section("content")
<div class="container px-3 md:px-10 xl:px-48 py-20">
  <div class="px-5 md:px-20 xl:px-48 text-black">
    <h3 class="mb-3 font-bold text-xl md:text-3xl text-center">Kelas Online</h3>
    <h1 class="mb-3 font-bold text-xl md:text-3xl text-center">{{ $course->course_title }}</h1>
    <h5 class="text-center">{{ $course->course_tagline }}</h5>
    <div class="flex items-center justify-center gap-10 mt-10">
      <div class="flex items-center gap-1.5">
        <i class="bx bx-globe" style="font-size: 28px"></i>
        <span class="">Release date {{ $course->created_at->format("M Y") }}</span>
      </div>
      <div class="flex items-center gap-1.5">
        <i class='bx bx-refresh' style="font-size: 38px"></i>
        <span class="">Last updated {{ $course->updated_at->format("M Y") }}</span>
      </div>
    </div>
    <div class="flex items-center justify-center gap-10 mt-10">
      <div class="flex flex-col gap-2">
        <span class="text-lg font-semibold">Sertifikat</span>
        @if ($course->course_certificate == 1)
          <div class="flex justify-center">
            <div class="bg-white inline-block rounded-full p-0.5">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: #506FFF;transform: ;msFilter:;"><path d="m10 15.586-3.293-3.293-1.414 1.414L10 18.414l9.707-9.707-1.414-1.414z"></path></svg>
            </div>
          </div>
        @else
          <div class="flex justify-center">
            <div class="bg-white inline-block rounded-full p-0.5">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: #506FFF;transform: ;msFilter:;"><path d="m16.192 6.344-4.243 4.242-4.242-4.242-1.414 1.414L10.535 12l-4.242 4.242 1.414 1.414 4.242-4.242 4.243 4.242 1.414-1.414L13.364 12l4.242-4.242z"></path></svg>
            </div>
          </div>
        @endif
      </div>
      <div class="flex flex-col gap-2">
        <span class="text-lg font-semibold">Konsultasi</span>
        @if ($course->consultation_certificate == 1)
          <div class="flex justify-center">
            <div class="bg-white inline-block rounded-full p-0.5">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: #506FFF;transform: ;msFilter:;"><path d="m10 15.586-3.293-3.293-1.414 1.414L10 18.414l9.707-9.707-1.414-1.414z"></path></svg>
            </div>
          </div>
        @else
          <div class="flex justify-center">
            <div class="bg-white inline-block rounded-full p-0.5">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: #506FFF;transform: ;msFilter:;"><path d="m16.192 6.344-4.243 4.242-4.242-4.242-1.414 1.414L10.535 12l-4.242 4.242 1.414 1.414 4.242-4.242 4.243 4.242 1.414-1.414L13.364 12l4.242-4.242z"></path></svg>
            </div>
          </div>
        @endif
      </div>
    </div>
  </div>
  <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mt-16">
    <div class="col-span-2">
      <div class="wrapper-course-detail">
        <iframe src="{{ $course->lessons[0]->lesson_link }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
      </div>
    </div>
    <div class="col-span-1">
      <div class="rounded-t-[16px] bg-white p-[25px]">
        @foreach ($course->lessons as $lesson)
          <button class="bg-secondary rounded-full flex items-center justify-between gap-3 p-3 w-full mb-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" style="fill: #34364a;transform: ;msFilter:;"><path d="M12 2C6.486 2 2 6.486 2 12s4.486 10 10 10 10-4.486 10-10S17.514 2 12 2zm0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8z"></path><path d="m9 17 8-5-8-5z"></path></svg>
            <div class="text-black text-left flex-1 text-1line">{{ $lesson->lesson_title }}</div>
            <span>{{ $lesson->lesson_duration }}</span>
          </button>
        @endforeach
        <a href="/course/checkout/{{ $course->course_slug }}" class="bg-secondary rounded-full flex items-center justify-between gap-3 p-3 w-full">
          <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" style="fill: #34364a;transform: ;msFilter:;"><path d="M12 2C6.486 2 2 6.486 2 12s4.486 10 10 10 10-4.486 10-10S17.514 2 12 2zm0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8z"></path><path d="m9 17 8-5-8-5z"></path></svg>
          <div class="text-black text-left flex-1 text-1line">31 video lainnya</div>
        </a>
      </div>
      <a href="/course/checkout/{{ $course->course_slug }}" class="bg-primary block h-[72px] rounded-b-[16px] text-white flex items-center justify-center outline-none text-xl">Gabung Kelas</a>
    </div>
  </div>
  <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mt-16">
    <div class="col-span-2 flex flex-col gap-4 leading-7 text-black pr-0 md:pr-20">
      <h3 class="font-bold text-2xl">Develop Your Skills</h3>
      {!! $course->course_description !!}
    </div>
  </div>
</div>
@endsection