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
              <th style="white-space: nowrap">Sertifikat</th>
              <th style="white-space: nowrap">Aksi</th>
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
      {data: "id", searchable: false, orderable: false, render: function(data, type, row) {
        if (row.user.course_certificate.length > 0) {
          const cc = row.user.course_certificate.filter((m) => m.course_id == row.course.id);
          if (cc.length > 0) {
            return "<span class='badge bg-info'>Sudah</span>";
          }
          return "<span class='badge bg-warning'>Belum</span>";
        }
        return "<span class='badge bg-warning'>Belum</span>";
      }},
      {data: "id", searchable: false, orderable: false, render: function(data, type, row) {
        return `
          <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#upload-${data}">Upload sertifikat</button>
          <div class="modal fade" id="upload-${data}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Upload Sertifikat</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route("instructor.upload.certificate") }}" enctype="multipart/form-data">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                  <input type="hidden" name="course_id" value="${row.course.id}" />
                  <input type="hidden" name="user_id" value="${row.user.id}" />
                  <div class="modal-body">
                    <input type="file" name="file" class="form-control" />
                  </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Upload</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        `;
      }},
    ]
  });
</script>
@endpush