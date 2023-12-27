@extends("layouts.blank")

@section("content")
<div class="max-w-3xl mx-auto px-5 lg:px-0">
  <div class="my-5 lg:my-10">
    <h3 class="text-center text-2xl underline font-bold">Forum</h3>
    <h1 class="text-center text-2xl font-bold mt-2">{{ $forum->forum_title }}</h1>
    <div class="mt-16">
      <div class="flex items-center gap-3 justify-between mb-5">
        <h4 class="font-semibold text-primary">Threads</h4>
        <button class="btn btn-sm btn-primary my-2" type="button">Buat Threads</button>
      </div>
      @foreach ($forum->threads as $thread)
        <div class="mt-3 border border-primary bg-white rounded-lg flex items-center px-5 py-3 gap-5 select-none cursor-pointer">
          <div class="w-[40px] h-[40px] border border-primary rounded-full bg-white overflow-hidden">
            <img src="{{ asset($thread->user->photo ?? 'assets/img/avatars/1.png') }}" class="w-full h-full" alt="avatar">
          </div>
          <div class="flex-1 text-1line font-semibold">{{ $thread->thread_title }}</div>
          <div>
            <div class="text-primary">
              <i class='bx bx-comment-dots'></i>
              <span class="text-black text-sm">{{ $thread->comments->count() }}</span>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</div>
@endsection