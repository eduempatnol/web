@extends("layouts.applayout")
@section("mentoring", "active open")
@section("mentoring.category", "active")
@section("title", "- Setting Mentoring Category")

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
  <div class="col-sm-12 mb-4 order-0">
    <div class="card">
      <div class="card-body">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add">Tambah Category</button>
        <div class="mt-4">
          <table id="tables" class="w-100">
            <thead>
              <tr>
                <th style="white-space: nowrap">Nama Kategori</th>
                <th style="white-space: nowrap">Slug</th>
                <th style="white-space: nowrap">Status Kategori</th>
                <th>Aksi</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="add" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5">Tambah Category</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route("mentoring.category.store") }}" method="POST">
          @csrf
          <div class="d-flex flex-column gap-1 mb-3">
            <label for="name">Nama Kategori</label>
            <input type="text" class="form-control" name="name" autocomplete="off" placeholder="Online Mentoring">
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@push("js")
<script src="https://cdn.datatables.net/v/dt/dt-1.13.8/r-2.5.0/datatables.min.js"></script>
<script>
  let table = $('#tables').DataTable({
    ajax: {
      url: "{{ route('mentoring.category.data') }}"
    },
    columns: [
      {data: "category_name", searchable: false, orderable: false, render: function(data, type, row) {
        return data;
      }},
      {data: "category_slug", searchable: true, orderable: false, render: function(data, type, row) {
        return data;
      }},
      {data: "category_active", searchable: true, orderable: false, render: function(data, type, row) {
        if (data == 1) {
          return `<span class="badge bg-success">Aktif</span>`;
        } else {
          return `<span class="badge bg-danger">Tidak Aktif</span>`
        }
      }},
      {data: "id", searchable: false, orderable: false, render: function(data, type, row) {
        return `<div class="d-flex">
          <button type="button" data-bs-toggle="modal" data-bs-target="#edit-${data}" class="btn btn-sm btn-info d-flex align-items-center gap-1">
            <i class='bx bx-edit'></i>
            <span class="fw-bold" style="margin-top: 2px">EDIT</span>
          </button>
          <div class="modal fade" id="edit-${data}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5">Tambah Category</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form action="{{ route("mentoring.category.update") }}" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" value="${row.id}">
                    <div class="d-flex flex-column gap-1 mb-3">
                      <label for="name">Nama Kategori</label>
                      <input type="text" class="form-control" value="${row.category_name}" name="name" autocomplete="off" placeholder="Online Mentoring">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>`;
      }}
    ]
  });
</script>
@endpush