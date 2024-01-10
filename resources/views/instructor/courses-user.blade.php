@extends("layouts.applayout")
@section("courses", "active")
@section("title", "- Kursus")

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
  <div class="col-12">
    <h4 class="text-primary">{{ $course->course_title }}</h4>
  </div>
</div>
<div class="row">
  <div class="col-sm-12">
    <div class="card">
      <div class="card-body">
        <table id="tables" class="w-100">
          <thead>
            <tr>
              <th style="white-space: nowrap">Invoice</th>
              <th style="white-space: nowrap">Siswa/Siswi</th>
              <th style="white-space: nowrap">Email</th>
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
      url: `/instructor/courses/{{ $course->id }}`,
      method: "POST",
      data: {
        _token: "{{ csrf_token() }}"
      },
    },
    columns: [
      {data: "code", searchable: false, orderable: false, render: function(data, type, row) {
        return data;
      }},
      {data: "name", searchable: false, orderable: false, render: function(data, type, row) {
        return data;
      }},
      {data: "email", searchable: false, orderable: false, render: function(data, type, row) {
        return data;
      }},
    ]
  });

  $("#tables tbody").on("click", "tr", function() {
    const data = table.row(this).data();
    return location.href = `/instructor/courses/${data.id}`;
  });
</script>
@endpush