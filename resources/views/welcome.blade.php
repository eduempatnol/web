@extends("layouts.pagelayout")
@section("title", "Edukasi 4.0")
@section("description", "Temukan kelas yang kamu inginkan disini")
@section("image", asset("favicon.jpg"))

@section("content")
<div class="container px-3 md:px-10 xl:px-28 py-20">
  <h1 class="text-center text-black font-bold text-3xl">Edukasi 4.0</h1>
  <h3 class="text-center text-black mt-3">Belajar dengan mentor expert dengan <br /> harga yang lebih terjangkau 😎</h3>
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
  function goToCourse(paramUrl) {
    return location.href = paramUrl;
  }
</script>
@endpush