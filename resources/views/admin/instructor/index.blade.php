@extends("layouts.applayout")
@section("admin.instructors", "active")
@section("title", "- List Instructors")

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
    @if (session()->get('errors'))
      <div class="alert alert-danger alert-dismissible" role="alert">
        {{ session()->get('errors') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
    <div class="card">
      <div class="card-body">
        <a href="{{ route("instructor.course.add") }}" type="button" class="btn btn-primary">Tambah Kursus</a>
        <div class="mt-4">
          <table id="tables" class="w-100">
            <thead>
              <tr>
                <th style="white-space: nowrap">Nama</th>
                <th style="white-space: nowrap">Status</th>
                {{-- <th style="white-space: nowrap">Harga Kursus</th> --}}
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
      url: "{{ route('admin.instructors.data') }}"
    },
    columns: [
      {data: "id", searchable: false, orderable: false, render: function(data, type, row) {
        return row.user.name;
      }},
      {data: "status", searchable: false, orderable: false, render: function(data, type, row) {
        return data == "Pending" || data == "Expired" ? "<span class='badge bg-secondary'>Bukan Mentor</span>" : "<span class='badge bg-primary'>Mentor</span>";
      }},
      {data: "status", searchable: false, orderable: false, render: function(data, type, row) {
        if (data == "Pending" || data == "Expired") {
          return `
            <a href="{{ route("admin.instructors.up") }}?id=${row.id}" class="btn btn-sm btn-primary">Jadikan Mentor</a>
          `
        } else {
          return `
            <a href="{{ route("admin.instructors.down") }}?id=${row.id}" class="btn btn-sm btn-danger">Lepas Status Mentor</a>
          `
        }
      }},
      // {data: "id", searchable: true, orderable: false, render: function(data, type, row) {
      //   return `<div>
      //     <span>( ${row.lessons.length} Materi )</span>
      //     <h5 class="mt-1">${data}</h5>
      //   </div>`;
      // }},
      // {data: "id", searchable: true, orderable: false, render: function(data, type, row) {
      //   return `Rp ${data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.')}`;
      // }},
      // {data: "id", searchable: false, orderable: false, render: function(data, type, row) {
      //   return `<div>
      //     <a href="/course/${row.course_slug}" class="btn btn-sm btn-info d-flex align-items-center gap-1">
      //       <i class='bx bx-paper-plane'></i>
      //       <span class="fw-bold" style="margin-top: 1px">LIHAT</span>
      //     </a>
      //     <a href="/instructor/courses/edit/${data}" class="mt-1 btn btn-sm btn-success d-flex align-items-center gap-1">
      //       <i class='bx bx-edit-alt'></i>
      //       <span class="fw-bold" style="margin-top: 1px">EDIT</span>
      //     </a>
      //   </div>`;
      // }}
    ]
  });
</script>
@endpush