@extends("layouts.applayout")
@section("settings", "active")

@section("content")
<div class="row">
  <div class="col-sm-12 col-md-4 col-lg-3 mb-4">
    <div class="card">
      <div class="card-body">
        <span style="text-transform: capitalize">Type : {{ $salesFee->type }}</span>
        <br />
        <span style="text-transform: capitalize">Rate : {{ $salesFee->value }}</span>
        <div class="mt-3">
          <form action="{{ route("admin.settings.rate") }}" method="POST">
            @csrf
            <select name="type" id="type" class="form-control mb-2" onchange="changeType()">
              <option value="percentage" {{ $salesFee->type == "percentage" ? "selected" : "" }}>Percentage</option>
              <option value="fixed" {{ $salesFee->type == "percentage" ? "fixed" : "" }}>Fixed</option>
            </select>
            <input type="text" name="value" class="form-control mb-2" id="value" value="{{ $salesFee->value }}">
            <button class="btn btn-primary">Change</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.6.0/cleave.min.js" integrity="sha512-KaIyHb30iXTXfGyI9cyKFUIRSSuekJt6/vqXtyQKhQP6ozZEGY8nOtRS6fExqE4+RbYHus2yGyYg1BrqxzV6YA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
  var cleave = new Cleave("#value", {
    numeral: true,
    delimiter: "",
    onlyPositive: true
  });
  function changeType() {
    return document.querySelector("#value").value = "0";
  }
</script>
@endpush