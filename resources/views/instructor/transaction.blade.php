@extends("layouts.applayout")
@section("transaction", "active")
@section("title", "- Transaction")

@push('css')
<link href="https://cdn.datatables.net/v/dt/dt-1.13.8/r-2.5.0/datatables.min.css" rel="stylesheet">
<style>
  .sorting_disabled::before,
  .sorting_disabled::after {
    display: none !important;
  }
  #tables {
    padding-top: 20px;
    margin-bottom: 10px;
  }
</style>
@endpush

@section("content")
<div class="row">
  <div class="col-sm-12">
    <div class="card">
      <div class="card-body">
        <table id="tables" class="w-100">
          <thead>
            <tr>
              <th style="white-space: nowrap">Invoice Code</th>
              <th style="white-space: nowrap">Kelas</th>
              <th style="white-space: nowrap">Pelajar</th>
              <th style="white-space: nowrap">Nominal Bayar</th>
              <th style="white-space: nowrap">Status</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection

@push('js')
<script src="https://cdn.datatables.net/v/dt/dt-1.13.8/r-2.5.0/datatables.min.js"></script>
<script>
  let table = $('#tables').DataTable({
    ajax: {
      url: "{{ route('instructor.transaction.data') }}"
    },
    columns: [
      {data: "code", searchable: false, orderable: false, render: function(data, type, row) {
        return `<span style="white-space: nowrap">${data}</span>`;
      }},
      {data: "note", searchable: true, orderable: false, render: function(data, type, row) {
        return data.split(" | ")[1];
      }},
      {data: "name", searchable: true, orderable: false, render: function(data, type, row) {
        return data;
      }},
      {data: "amount", searchable: true, orderable: false, render: function(data, type, row) {
        return `Rp ${data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.')}`;
      }},
      {data: "status", searchable: true, orderable: false, render: function(data, type, row) {
        // 'Pending','Success','Expired','Error'
        if (data == "Pending") {
          return `<span class="badge bg-warning">${data}</span>`;
        }
        if (data == "Success") {
          return `<span class="badge bg-primary">${data}</span>`;
        }
        if (data == "Expired") {
          return `<span class="badge bg-secondary">${data}</span>`;
        }
        if (data == "Error") {
          return `<span class="badge bg-danger">${data}</span>`;
        }
      }},
    ]
  });
</script>
@endpush