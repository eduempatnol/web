@extends("layouts.applayout")
@section("dashboard", "active")

@section("content")
<div class="row">
  <div class="col-sm-12 mb-4 order-0">
    <div class="card">
      <div class="d-flex align-items-end row">
        <div class="col-sm-7">
          <div class="card-body">
            <h5 class="card-title text-primary">Selamat Datang {{ Auth::user()->name }}! 🎉</h5>
            {{-- <p class="mb-4">
              You have done <span class="fw-bold">72%</span> more sales today. Check your new badge in
              your profile.
            </p> --}}
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
  <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
    <div class="card">
      <div class="card-body text-primary">
        <div class="d-flex align-items-center gap-2 mb-2">
          <i class='bx bxs-group' style="font-size: 28px"></i>
          <span class="fs-4">Pelajar</span>
        </div>
        <span class="fs-3">{{ $students }}</span>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
    <div class="card">
      <div class="card-body text-primary">
        <div class="d-flex align-items-center gap-2 mb-2">
          <i class='bx bxs-face' style="font-size: 28px"></i>
          <span class="fs-4">Instruktur</span>
        </div>
        <span class="fs-3">{{ $instructors }}</span>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
    <div class="card">
      <div class="card-body text-primary">
        <div class="d-flex align-items-center gap-2 mb-2">
          <i class='bx bxs-videos' style="font-size: 28px"></i>
          <span class="fs-4">Kelas</span>
        </div>
        <span class="fs-3">{{ $courses }}</span>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
    <div class="card">
      <div class="card-body text-primary">
        <div class="d-flex align-items-center gap-2 mb-2">
          <i class='bx bx-book-bookmark' style="font-size: 28px"></i>
          <span class="fs-4">Transaksi</span>
        </div>
        <span>Rp</span>
        <span class="fs-3">{{ number_format($transaction, 0, ",", ".") }}</span>
      </div>
    </div>
  </div>
</div>
@endsection