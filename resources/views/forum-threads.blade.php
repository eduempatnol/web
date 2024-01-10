@extends("layouts.blank")

@section("content")
<div class="h-10 my-10 px-5 md:px-20">
  <div class="gap-10 flex flex-col md:flex-row">
    <div class="w-full md:max-w-[380px]">
      <div class="bg-white rounded-lg p-5 border">
        {{ $thread->thread_title }}
      </div>
    </div>
    <div class="w-full md:flex-1">
      <div class="flex items-center justify-start">
        <label for="" class="font-semibold bg-primary text-white text-sm py-2 px-4 rounded cursor-pointer">
          Tulis komentar
        </label>
      </div>
      @if (count($thread->comments) < 1)
        <div>Belum ada komentar</div>
      @else
        <div class=""></div>
      @endif
    </div>
  </div>
</div>
@endsection