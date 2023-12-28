@extends("layouts.applayout")
@section("mentoring", "active open")
@section("mentoring.schedule", "active")
@section("title", "- Setting Mentoring Schedule")

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
@if (Session::has("error"))
  <div class="px-5 py-3 w-full rounded-lg text-sm bg-danger text-white font-bold mb-3">
    {{ Session::get("error") }}
  </div>
@endif
<div class="row">
  <div class="col-sm-12 mb-4 order-0">
    <div class="card">
      <div class="card-body">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add">Tambah Jadwal</button>
        <div class="mt-4">
          <table id="tables" class="w-100">
            <thead>
              <tr>
                <th style="white-space: nowrap">Start Date</th>
                <th style="white-space: nowrap">End Date</th>
                <th>Schedule Type</th>
                <th style="white-space: nowrap">Status</th>
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
        <h1 class="modal-title fs-5">Tambah Jadwal Mentoring</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route("mentoring.schedule.store") }}" method="POST">
          @csrf
          <div class="d-flex flex-column gap-1 mb-3">
            <div class="col-sm-12">
              <div class="row">
                <div class="col-sm-12">
                  <div class="d-flex flex-column gap-1 mb-3">
                    <label for="category">Kategori</label>
                    <select name="category" id="category" class="form-control">
                      <option value="" selected>Pilih Category</option>
                      <option value="online">Online</option>
                      <option value="offline">Offline</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-12">
              <div class="row">
                <div class="col-md-6 col-sm-12">
                  <div class="d-flex flex-column gap-1 mb-3">
                    <label for="start_date">Tanggal Mulai</label>
                    <input type="date" id="start_date" name="start_date" class="form-control" autocomplete="off">
                  </div>
                </div>
                <div class="col-md-6 col-sm-12">
                  <div class="d-flex flex-column gap-1 mb-3">
                    <label for="start_time">Waktu Mulai</label>
                    <input type="time" id="start_time" name="start_time" class="form-control" autocomplete="off">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-12">
              <div class="row">
                <div class="col-md-6 col-sm-12">
                  <div class="d-flex flex-column gap-1 mb-3">
                    <label for="end_date">Tanggal Berakhir</label>
                    <input type="date" id="end_date" name="end_date" class="form-control" autocomplete="off">
                  </div>
                </div>
                <div class="col-md-6 col-sm-12">
                  <div class="d-flex flex-column gap-1 mb-3">
                    <label for="end_time">Waktu Berakhir</label>
                    <input type="time" id="end_time" name="end_time" class="form-control" autocomplete="off">
                  </div>
                </div>
              </div>
            </div>
            <div id="type-result"></div>
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
  let table = $("#tables").DataTable({
    ajax: {
      url: "{{ route('mentoring.schedule.data') }}"
    },
    order: [[3, "desc"]],
    columns: [
      {data: "schedule_from", searchable: false, orderable: false, render: function(data, type, row) {
        return data;
      }},
      {data: "schedule_to", searchable: true, orderable: false, render: function(data, type, row) {
        return data;
      }},
      {data: "id", searchable: true, orderable: false, render: function(data, type, row) {
        return `
          <div class="">
            <div style="text-transform: capitalize; font-weight: 700; margin-bottom: 3px">${row.schedule_type}</div>
            <div>${row.schedule_type == "online" ? row.schedule_link : row.schedule_address}</div>
          </div>
        `;
      }},
      {data: "schedule_expired", searchable: true, orderable: false, render: function(data, type, row) {
        if (data == "active") {
          return `<span class="badge bg-success">Aktif</span>`;
        } else {
          return `<span class="badge bg-danger">Tidak Aktif</span>`
        }
      }},
      // {data: "id", searchable: false, orderable: false, render: function(data, type, row) {
      //   return `<div class="d-flex">
      //     <button type="button" data-bs-toggle="modal" data-bs-target="#edit-${data}" class="btn btn-sm btn-info d-flex align-items-center gap-1">
      //       <i class='bx bx-edit'></i>
      //       <span class="fw-bold" style="margin-top: 2px">EDIT</span>
      //     </button>
      //     <div class="modal fade" id="edit-${data}" tabindex="-1" aria-hidden="true">
      //       <div class="modal-dialog">
      //         <div class="modal-content">
      //           <div class="modal-header">
      //             <h1 class="modal-title fs-5">Tambah Category</h1>
      //             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      //           </div>
      //           <div class="modal-body">
      //             <form action="{{ route("mentoring.category.update") }}" method="POST">
      //               <input type="hidden" name="_token" value="{{ csrf_token() }}">
      //               <input type="hidden" name="id" value="${row.id}">
      //               <div class="d-flex flex-column gap-1 mb-3">
      //                 <label for="name">Nama Kategori</label>
      //                 <input type="text" class="form-control" value="${row.category_name}" name="name" autocomplete="off" placeholder="Online Mentoring">
      //               </div>
      //               <button type="submit" class="btn btn-primary">Submit</button>
      //             </form>
      //           </div>
      //         </div>
      //       </div>
      //     </div>
      //   </div>`;
      // }}
    ]
  });

  $("#category").change(function() {
    $("#type-result").html("");

    if ($(this).val() == "online") {
      $("#type-result").append(`
        <div class="col-sm-12">
          <div class="row">
            <div class="col-sm-12">
              <div class="d-flex flex-column gap-1 mb-3">
                <label for="link">Link</label>
                <input type="text" class="form-control" name="link" autocomplete="off" placeholder="https://us06web.zoom.us/j/83335090701">
              </div>
            </div>
          </div>
        </div>
      `);
    } else if ($(this).val() == "offline") {
      $("#type-result").append(`
        <div class="col-sm-12">
          <div class="row">
            <div class="col-sm-12">
              <div class="d-flex flex-column gap-1 mb-3">
                <label for="address">Alamat</label>
                <textarea type="text" class="form-control" rows="5" name="address" autocomplete="off" placeholder="Jl. Ahmad Yani"></textarea>
              </div>
            </div>
          </div>
        </div>
      `);
    }
  });
</script>
@endpush