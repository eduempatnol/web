@extends("layouts.applayout")
@section("admin.vouchers", "active")

@section("content")
<div class="row">
  <div class="col-sm-12 mb-4 order-0">
    <div class="card">
      <div class="card-body">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#create">
          Buat Voucher Baru
        </button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="create" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Voucher Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <hr>
      <form action="{{ route("admin.voucher.store") }}" id="form-create" method="POST">
        <div class="modal-body pt-1">
          @csrf
          <div class="row">
            <div class="col-md-6 col-sm-12 mb-3">
              <div class="d-flex flex-column gap-1">
                <label for="type_voucher">Tipe Voucher</label>
                <select name="type_voucher" id="type_voucher" class="form-control">
                  <option value="" selected>Pilih Tipe Voucher</option>
                  <option value="single">Single Benefit</option>
                  <option value="package">Package Benefit</option>
                </select>
              </div>
            </div>
            <div class="col-md-6 col-sm-12 mb-3">
              <div class="d-flex flex-column gap-1">
                <label for="benefit_voucher">Tipe Benefit</label>
                <select name="benefit_voucher" id="benefit_voucher" class="form-control">
                  <option value="" selected>Pilih Tipe Benefit</option>
                  <option value="discount">Discount Benefit</option>
                  <option value="course">Redeen Course Benefit</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12 mb-3">
              <div class="d-flex flex-column gap-1">
                <label for="based_voucher">Digunakan Berdasarkan</label>
                <select name="based_voucher" id="based_voucher" class="form-control">
                  <option value="" selected>Pilih Penggunaan Voucher</option>
                  <option value="time">Rentan Waktu</option>
                  <option value="use">Maksimal Penggunaan</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row d-none" id="type_time">
            <div class="col-md-6 col-sm-12 mb-3">
              <div class="d-flex flex-column gap-1">
                <label for="valid_voucher">Valid Voucher</label>
                <input type="date" id="valid_voucher" name="valid_voucher" autocomplete="off" class="form-control">
              </div>
            </div>
            <div class="col-md-6 col-sm-12 mb-3">
              <div class="d-flex flex-column gap-1">
                <label for="expired_voucher">Expired Voucher</label>
                <input type="date" id="expired_voucher" name="expired_voucher" autocomplete="off" class="form-control">
              </div>
            </div>
          </div>
          <div class="row d-none" id="type_use">
            <div class="col-12 mb-3">
              <div class="d-flex flex-column gap-1">
                <label for="used_voucher">Maksimal Penggunaan Voucher</label>
                <input type="number" id="used_voucher" name="used_voucher" autocomplete="off" class="form-control">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" id="submit-create" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('js')
<script>
  $("#form-create").submit(function() {
    $("#submit-create").attr("disabled", true);
  });

  $("#based_voucher").change(function(element) {
    $("#valid_voucher").val("");
    $("#expired_voucher").val("");
    $("#used_voucher").val("");

    const based = $(this).val();
    if (based == "time") {
      $("#type_use").addClass("d-none");
      return $("#type_time").removeClass("d-none");
    }
    if (based == "use") {
      $("#type_time").addClass("d-none");
      return $("#type_use").removeClass("d-none");
    }

    $("#type_time").addClass("d-none");
    $("#type_use").addClass("d-none");
  });
</script>
@endpush