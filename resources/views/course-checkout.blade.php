@extends("layouts.pagelayout")
@section("title", $course->course_title)

@section("content")
<div class="container px-3 md:px-10 xl:px-48 py-20">
  <div class="px-5 md:px-20 xl:px-48 text-black">
    <h3 class="mb-3 font-bold text-xl md:text-3xl text-center">Checkout Kelas</h3>
    <h5 class="text-center">Bergabung dengan kami di kelas Premium dan<br />membangun skillset yang dibutuhkan</h5>
  </div>
  <div class="w-full md:w-3/4 mx-auto grid grid-cols-1 md:grid-cols-3 gap-5 mt-16">
    <div class="col-span-1">
      <div class="rounded-[16px] bg-white overflow-hidden">
        <img src="{{ asset($course->course_thumbnail) }}" alt="">
        <div class="p-[15px]">
          <h3 class="font-semibold" id="course-title" data-title="{{ $course->id }}">{{ $course->course_title }}</h3>
          <div class="flex items-center gap-0.5 mt-5">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: #F4A42B;transform: ;msFilter:;"><path d="M21.947 9.179a1.001 1.001 0 0 0-.868-.676l-5.701-.453-2.467-5.461a.998.998 0 0 0-1.822-.001L8.622 8.05l-5.701.453a1 1 0 0 0-.619 1.713l4.213 4.107-1.49 6.452a1 1 0 0 0 1.53 1.057L12 18.202l5.445 3.63a1.001 1.001 0 0 0 1.517-1.106l-1.829-6.4 4.536-4.082c.297-.268.406-.686.278-1.065z"></path></svg>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: #F4A42B;transform: ;msFilter:;"><path d="M21.947 9.179a1.001 1.001 0 0 0-.868-.676l-5.701-.453-2.467-5.461a.998.998 0 0 0-1.822-.001L8.622 8.05l-5.701.453a1 1 0 0 0-.619 1.713l4.213 4.107-1.49 6.452a1 1 0 0 0 1.53 1.057L12 18.202l5.445 3.63a1.001 1.001 0 0 0 1.517-1.106l-1.829-6.4 4.536-4.082c.297-.268.406-.686.278-1.065z"></path></svg>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: #F4A42B;transform: ;msFilter:;"><path d="M21.947 9.179a1.001 1.001 0 0 0-.868-.676l-5.701-.453-2.467-5.461a.998.998 0 0 0-1.822-.001L8.622 8.05l-5.701.453a1 1 0 0 0-.619 1.713l4.213 4.107-1.49 6.452a1 1 0 0 0 1.53 1.057L12 18.202l5.445 3.63a1.001 1.001 0 0 0 1.517-1.106l-1.829-6.4 4.536-4.082c.297-.268.406-.686.278-1.065z"></path></svg>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: #F4A42B;transform: ;msFilter:;"><path d="M21.947 9.179a1.001 1.001 0 0 0-.868-.676l-5.701-.453-2.467-5.461a.998.998 0 0 0-1.822-.001L8.622 8.05l-5.701.453a1 1 0 0 0-.619 1.713l4.213 4.107-1.49 6.452a1 1 0 0 0 1.53 1.057L12 18.202l5.445 3.63a1.001 1.001 0 0 0 1.517-1.106l-1.829-6.4 4.536-4.082c.297-.268.406-.686.278-1.065z"></path></svg>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: #F4A42B;transform: ;msFilter:;"><path d="M21.947 9.179a1.001 1.001 0 0 0-.868-.676l-5.701-.453-2.467-5.461a.998.998 0 0 0-1.822-.001L8.622 8.05l-5.701.453a1 1 0 0 0-.619 1.713l4.213 4.107-1.49 6.452a1 1 0 0 0 1.53 1.057L12 18.202l5.445 3.63a1.001 1.001 0 0 0 1.517-1.106l-1.829-6.4 4.536-4.082c.297-.268.406-.686.278-1.065z"></path></svg>
            <span class="text-sm mt-1.5 ml-0.5">(1299)</span>
          </div>
        </div>
      </div>
    </div>
    <div class="col-span-2">
      <div class="rounded-[16px] p-[30px] bg-white overflow-hidden">
        <p class="text-lg font-semibold">Payment details</p>
        <div class="flex flex-col gap-2 mt-5">
          @php
            $price = $course->course_price;
            $ppn11 = $course->course_price * 11 / 100;
            $fee = 10000;
            $total = $price + $ppn11 + $fee;
          @endphp
          <div class="flex items-center justify-between">
            <span>Harga kelas</span>
            <span class="">Rp {{ number_format($price, 0, ",", ".") }}</span>
          </div>
          <div class="flex items-center justify-between">
            <span>PPN 11%</span>
            <span class="text-success">+ Rp {{ number_format($ppn11, 0, ",", ".") }}</span>
          </div>
          <div class="flex items-center justify-between">
            <span>Service fee</span>
            <span class=" text-success">+ Rp {{ number_format($fee, 0, ",", ".") }}</span>
          </div>
          <div class="flex items-center justify-between">
            <span>Total Transfer</span>
            <span class="font-bold" id="total-amount" data-total="{{ $total }}">Rp {{ number_format($total, 0, ",", ".") }}</span>
          </div>
        </div>
        <div class="flex items-center mt-10 mb-3">
          <input id="link-checkbox" type="checkbox" value="" class="w-5 h-5 text-primary bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-primary dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
          <label for="link-checkbox" class="ms-2 font-medium text-black select-none">Saya setuju dengan <a href="#" class="text-primary dark:text-blue-500 hover:underline">Terms and Conditions</a>.</label>
        </div>
        <button type="button" id="pay" class="flex items-center gap-2 justify-center bg-primary w-full text-white font-bold py-4 text-lg rounded-full disabled:opacity-0.6">
          Bayar & gabung kelas
          <span class="hidden" id="loading">
            <i class="bx bx-loader-alt animate-spin" style="font-size: 24px"></i>
          </span>
        </button>
      </div>
    </div>
  </div>
</div>
@endsection

@push('js')
<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>

<script>
  $("#pay").click(function (event) {
    event.preventDefault();
    $(this).prop("disabled", true);
    $("#loading").removeClass("hidden");

    $.post("{{ route('payment.course') }}", {
      _method: "POST",
      _token: "{{ csrf_token() }}",
      course_name: $("#course-title").data("title"),
      amount: $("#total-amount").data("total")
    },
    function (data, status) {
      return location.href = data.snap_url
    });
  });
</script>
@endpush
