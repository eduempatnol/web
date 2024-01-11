@extends("layouts.blank")

@section("content")
<div class="h-10 my-10 px-5 md:px-20">
  <div class="gap-10 flex flex-col md:flex-row">
    <div class="w-full lg:max-w-[380px]">
      <div class="bg-white rounded-lg p-5 border border-primary">
        {{ $thread->thread_title }}
      </div>
    </div>
    <div class="w-full lg:flex-1">
      <div class="flex items-center justify-start">
        <label for="comment" class="font-semibold bg-primary text-white text-sm py-2 px-4 rounded cursor-pointer select-none">
          Tulis komentar
        </label>
      </div>
      @if (count($thread->comments) < 1)
        <div class="mt-3 text-lg">Belum ada komentar</div>
      @else
        @foreach ($thread->comments->reverse() as $comment)
          <div class="mt-3 border border-primary bg-white py-2 px-4 rounded">
            <div class="text-sm font-semibold text-primary">{{ $comment->user->name }}</div>
            <div class="text-sm my-2">{{ $comment->comment }}</div>
            <div class="text-primary font-semibold flex justify-end" style="font-size: 10px">{{ date("d/m/Y H:i:s", strtotime($comment->created_at)) }}</div>
          </div>
        @endforeach
      @endif
    </div>
  </div>
</div>
<input type="checkbox" id="comment" class="modal-toggle" />
<div class="modal" role="dialog">
  <div class="modal-box">
    <h3 class="font-bold text-lg">Tulis Komentar</h3>
    <form id="newThreads" method="POST" action="{{ route("comment.post", $thread->id) }}">
      @csrf
      <div class="forum-body">
        <div class="flex flex-col gap-1 mt-3">
          <textarea name="comment" class="outline-none border rounded-lg py-2 px-3 text-sm" autocomplete="off" rows="5"></textarea>
        </div>
      </div>
      <div class="modal-action">
        <button class="btn bg-primary text-white hover:bg-primary">Submit</button>
        <label for="comment" class="btn">Close!</label>
      </div>
    </form>
  </div>
</div>
@endsection