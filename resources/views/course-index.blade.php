@extends("layouts.pagelayout")
@section("title", "Semua Kelas")
@section("description", "Temukan kelas yang kamu inginkan disini")
@section("image", asset("favicon.jpg"))

@section("content")
<div class="container px-3 md:px-10 xl:px-28 py-20">
  <h1 class="text-black font-bold text-3xl">Kelas Edukasi 4.0</h1>
  <form class="border border-primary flex items-center gap-2 px-3 py-2 rounded-lg bg-white mt-3">
    <i class="bx bx-search text-primary" style="font-size: 24px"></i>
    <input type="text" id="search" value="{{ $inputSearch }}" class="w-full outline-none text-sm h-full flex-1" placeholder="Cari kelas disini..." autocomplete="off">
    <button type="submit" class="outline-none bg-primary text-white h-full px-3 py-1.5 rounded-lg text-sm text-nowrap">Go</button>
  </form>
  <div class="grid gap-3 grid-cols-2 md:grid-cols-3 lg:grid-cols-4 mt-10">
    @foreach ($courses as $course)
      <div class="bg-white rounded-lg overflow-hidden cursor-pointer select-none" onclick="goToCourse('{{ route('course.detail', $course->course_slug) }}')">
        <img src="{{ asset($course->course_thumbnail) }}" alt="{{ $course->course_title }}">
        <div class="p-[16px]">
          <h3 class="text-lg font-bold text-black text-2line mb-3">{{ $course->course_title }}</h3>
          <span class="text-gray-400">Rp {{ number_format($course->course_price, 0, ",", ".") }}</span>
        </div>
      </div>
    @endforeach
  </div>
</div>
@endsection

@push("js")
<script>
  document.querySelector("form").addEventListener("submit", function(e) {
    e.preventDefault();
    const search = document.querySelector("#search");
    if (search) {
      return location.href = `/course?q=${search.value}`
    }
  });

  function goToCourse(paramUrl) {
    return location.href = paramUrl;
  }
</script>
@endpush
