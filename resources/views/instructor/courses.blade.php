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
  <div class="col-sm-12">
    <div class="card">
      <div class="card-body">
        <a href="{{ route("instructor.course.add") }}" type="button" class="btn btn-primary">Tambah Kursus</a>
        <div class="mt-4">
          <table id="tables" class="w-100">
            <thead>
              <tr>
                <th style="white-space: nowrap">Thumbnail</th>
                <th style="white-space: nowrap">Judul Kursus</th>
                <th style="white-space: nowrap">Harga Kursus</th>
                <th>Aksi</th>
              </tr>
            </thead>
          </table>
        </div>
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
      url: "{{ route('instructor.courses.data') }}"
    },
    columns: [
      {data: "course_thumbnail", searchable: false, orderable: false, render: function(data, type, row) {
        return `<img src="/${data}" style="object-fit: cover; object-position: top left" width="150" height="150" />`;
      }},
      {data: "course_title", searchable: true, orderable: false, render: function(data, type, row) {
        return `<div>
          <span>( ${row.lessons.length} Materi )</span>
          <h5 class="mt-1">${data}</h5>
        </div>`;
      }},
      {data: "course_price", searchable: true, orderable: false, render: function(data, type, row) {
        return `Rp ${data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.')}`;
      }},
      {data: "id", searchable: false, orderable: false, render: function(data, type, row) {
        return `<div>
          <a href="/course/${row.course_slug}" class="btn btn-sm btn-info d-flex align-items-center gap-1">
            <i class='bx bx-paper-plane'></i>
            <span class="fw-bold" style="margin-top: 1px">LIHAT</span>
          </a>
          <a href="/instructor/courses/edit/${data}" class="mt-1 btn btn-sm btn-success d-flex align-items-center gap-1">
            <i class='bx bx-edit-alt'></i>
            <span class="fw-bold" style="margin-top: 1px">EDIT</span>
          </a>
        </div>`;
      }}
    ]
  });
</script>
@endpush