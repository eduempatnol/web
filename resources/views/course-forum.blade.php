@extends("layouts.blank")

@section("content")
<div class="max-w-3xl mx-auto px-5 lg:px-0">
  <div class="my-5 lg:my-10">
    <h3 class="text-center text-2xl underline font-bold">Forum</h3>
    <h1 class="text-center text-2xl font-bold mt-2">{{ $forum->forum_title }}</h1>
    <div class="mt-16">
      <div class="flex items-center gap-3 justify-between mb-5">
        <h4 class="font-semibold text-primary">Threads</h4>
        <label class="btn btn-sm btn-primary my-2 text-white" for="createThreads">Buat Threads</label>
      </div>
      @foreach ($forum->threads->reverse() as $thread)
        <div onclick="showThread({{ $thread->id }})" class="mt-3 border border-primary bg-white rounded-lg flex items-center px-5 py-3 gap-5 select-none cursor-pointer">
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
<input type="checkbox" id="createThreads" class="modal-toggle" />
<div class="modal" role="dialog">
  <div class="modal-box">
    <h3 class="font-bold text-lg">Buat Thread</h3>
    <form id="newThreads" method="POST" action="{{ route("threads.post", $forum->id) }}">
      @csrf
      <div class="forum-body">
        <div class="flex flex-col gap-1 mt-3">
          <label for="title" class="text-sm">Thread Title</label>
          <input type="text" name="thread_title" class="outline-none border rounded-lg py-2 px-3 text-sm" autocomplete="off">
        </div>
        <div class="flex flex-col gap-1 mt-3">
          <label for="description" class="text-sm">Thread Description</label>
          <textarea name="thread_description" class="outline-none border rounded-lg py-2 px-3 text-sm" autocomplete="off" rows="5"></textarea>
        </div>
      </div>
      <div class="modal-action">
        <button class="btn bg-primary text-white hover:bg-primary">Submit</button>
        <label for="createThreads" class="btn">Close!</label>
      </div>
    </form>
  </div>
</div>
@endsection

@push("js")
<script>
  function showThread(param) {
    return location.href = location.href + "/" + param;
  }
</script>
@endpush