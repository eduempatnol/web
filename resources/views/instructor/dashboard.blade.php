@extends("layouts.applayout")
@section("dashboard", "active")

@section("content")
<div class="row">
  <div class="col-sm-12 mb-4 order-0">
    @if (count($schedule) > 0 && !$mentoring)
      <div class="d-flex align-items-center gap-2 mb-3">
        <span class="fw-bold">Kamu berhak mengikutin program mentorship, dan jadilah mentor sekarang!</span>
        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#mentorship">Become a mentorship</button>
        <div class="modal fade" id="mentorship" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5">Daftar Program Mentorship</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form action="{{ route("payment.mentoring") }}" method="POST">
                  @csrf
                  <div class="d-flex flex-column gap-1 mb-3">
                    <div class="col-sm-12">
                      <div class="d-flex flex-column gap-1 mb-3">
                        <label for="mentoring_id">Ketersediaan Program</label>
                        <select name="mentoring_id" id="mentoring_id" class="form-control">
                          <option value="" selected>Pilih Jadwal</option>
                          @foreach ($schedule as $sche)
                            <option value="{{ $sche->id }}">
                              <span class="fw-bold">{{ $sche->schedule_from }} / {{ $sche->schedule_to }}</span>
                              <span>|</span>
                              <span>{{ ucfirst($sche->schedule_type) }}</span>
                            </option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-primary">Submit</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    @endif
    @if ($mentoring)
      <div class="alert alert-primary" role="alert">
        Ikuti kelas mentoring kamu disini — 
        @if ($mentoring->checkout->schedule->schedule_link)
          <a href="{{ $mentoring->checkout->schedule->schedule_link }}">
            <strong>{{ $mentoring->checkout->schedule->schedule_link }}</strong>
          </a>
        @endif
        @if ($mentoring->checkout->schedule->schedule_address)
          <strong>{{ $mentoring->checkout->schedule->schedule_address }}</strong>
        @endif
      </div>
    @endif
    <div class="card">
      <div class="d-flex align-items-end row">
        <div class="col-sm-7">
          <div class="card-body">
            <h5 class="card-title text-primary">Selamat Datang {{ Auth::user()->name }} 🎉</h5>
          </div>
        </div>
        <div class="col-sm-5 text-center text-sm-left">
          <div class="card-body pb-0 px-0 px-md-4">
            <img
              src="{{ asset("assets/img/illustrations/man-with-laptop-light.png") }}"
              height="140"
              alt="View Badge User"
              data-app-dark-img="illustrations/man-with-laptop-dark.png"
              data-app-light-img="illustrations/man-with-laptop-light.png"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection