@extends("layouts.applayout")
@section("courses", "active")
@section("title", "- Tambah Kursus")

@section("content")
<div class="row">
  <div class="col-sm-12">
    <div class="card">
      <div class="card-body">
        <h4>Tambah Kursus Baru</h4>
        <div class="border-bottom my-4"></div>
        @if (session()->get('errors'))
          <div class="alert alert-danger alert-dismissible" role="alert">
            {{ session()->get('errors')->first() }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif
        <form action="{{ route("instructor.course.submit") }}" id="form" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="col-md-6 col-sm-12">
              <div class="d-flex flex-column gap-1 mb-3">
                <label for="course_title">Judul Kursus</label>
                <input type="text" id="course_title" name="course_title" class="form-control" autocomplete="off" placeholder="Complete Freelancer UI/UX & Illustration Designer: Brief, Wireframe, Visual Design, Portfolio">
              </div>
            </div>
            <div class="col-md-6 col-sm-12">
              <div class="d-flex flex-column gap-1 mb-3">
                <label for="course_tagline">Tagline / Slogan</label>
                <input type="text" name="course_tagline" id="course_tagline" class="form-control" autocomplete="off" placeholder="Preparing Yourself to Be Professional UI Freelancer">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-8 col-sm-12">
              <div class="d-flex flex-column gap-1 mb-3">
                <label for="course_description">Deskripsi</label>
                <textarea name="course_description" id="course_description" cols="30" rows="10"></textarea>
              </div>
            </div>
            <div class="col-md-4 col-sm-12">
              <div class="d-flex flex-column gap-1 mb-3">
                <label for="course_thumbnail">Thumbnail</label>
                <input type="file" class="form-control" name="course_thumbnail" id="course_thumbnail">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 col-sm-12">
              <div class="d-flex flex-column gap-1 mb-3">
                <label for="course_price">Harga Kursus</label>
                <input type="text" id="course_price" name="course_price" class="form-control" autocomplete="off" placeholder="100.000">
              </div>
            </div>
            <div class="col-md-4 col-sm-12">
              <div class="d-flex flex-column gap-1 mb-3">
                <label for="course_certificate">Sertifikat Kursus</label>
                <select name="course_certificate" id="course_certificate" class="form-control">
                  <option value="" selected>Pilih Ketersediaan</option>
                  <option value="1">Tersedia</option>
                  <option value="0">Tidak Tersedia</option>
                </select>
              </div>
            </div>
            <div class="col-md-4 col-sm-12">
              <div class="d-flex flex-column gap-1 mb-3">
                <label for="consultation_certificate">Konsultasi Kursus</label>
                <select name="consultation_certificate" id="consultation_certificate" class="form-control">
                  <option value="" selected>Pilih Ketersediaan</option>
                  <option value="1">Tersedia</option>
                  <option value="0">Tidak Tersedia</option>
                </select>
              </div>
            </div>
          </div>
          <div class="mt-4">
            <h4>PELAJARAN</h4>
            <button type="button" class="btn btn-sm btn-success" onclick="addLessons()">Tambah Pelajaran</button>
            <div class="mt-3" id="lessons-wrapper"></div>
          </div>
          <div class="mt-5">
            <button class="btn btn-primary w-100" type="button" onclick="submitData(this)">Submit Kursus</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.6.0/cleave.min.js" integrity="sha512-KaIyHb30iXTXfGyI9cyKFUIRSSuekJt6/vqXtyQKhQP6ozZEGY8nOtRS6fExqE4+RbYHus2yGyYg1BrqxzV6YA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.tiny.cloud/1/nrdzm1osuqpbh3qjsbbk3vka9qajngh3hrvbmntyf5v9riqg/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
  const iDescription = tinymce.init({
    selector: 'textarea',
    plugins: '',
    toolbar: 'styles | bold italic',
    menubar: '',
    tinycomments_mode: 'embedded',
    tinycomments_author: 'Author name',
    mergetags_list: [
      { value: 'First.Name', title: 'First Name' },
      { value: 'Email', title: 'Email' },
    ],
    ai_request: (request, respondWith) => respondWith.string(() => Promise.reject("See docs to implement AI Assistant")),
  });

  const iPrice = new Cleave('#course_price', {
    numeral: true,
    numeralThousandsGroupStyle: 'thousand'
  });

  // let leassons = [
  //   {
  //     lesson_title: "",
  //     lesson_link: "",
  //     lesson_duration: ""
  //   },
  // ];
  const lessonsWrapper = document.getElementById("lessons-wrapper");
  let leassons = [];

  if (lessonsWrapper) {
    elementLesson();
  }

  function addLessons(){
    leassons.push({
      lesson_title: "",
      lesson_link: "",
      lesson_duration: ""
    });
    elementLesson();
  }

  function eraseLesson(iteration) {
    const selector = document.querySelector(`#lessonsWrapper-${iteration}`);
    if (selector) {
      leassons.splice(iteration, 1);
      selector.remove();
    }

    elementLesson();
  }

  function elementLesson() {
    lessonsWrapper.innerHTML = "";

    leassons.forEach((data, iteration) => {
      lessonsWrapper.innerHTML += `<div class="row" id="lessonsWrapper-${iteration}">
        <div class="col-md-3 col-sm-12">
          <div class="d-flex flex-column gap-1 mb-3">
            <label for="lesson_title">Judul Pelajaran</label>
            <input
              type="text"
              name="lesson_title[]"
              id="lesson_title-${iteration}"
              class="form-control"
              value="${data ? data.lesson_title : ""}"
              autocomplete="off"
              placeholder="Goals Kelas UIUX Illustration"
              onkeyup="changeValueTitle(${iteration})"
            />
          </div>
        </div>
        <div class="col-md-3 col-sm-12">
          <div class="d-flex flex-column gap-1 mb-3">
            <label for="lesson_link">Link Pelajaran</label>
            <input
              type="text"
              name="lesson_link[]"
              id="lesson_link-${iteration}"
              class="form-control"
              value="${data ? data.lesson_link : ""}"
              autocomplete="off"
              placeholder="https://www.youtube.com/embed/yTsl4w1a_4o?si=uC3nR8AZXowBmW62"
              onkeyup="changeValueLink(${iteration})"
            />
          </div>
        </div>
        <div class="col-md-3 col-sm-12">
          <div class="d-flex flex-column gap-1 mb-3">
            <label for="lesson_duration">Durasi Pelajaran</label>
            <input
              type="text"
              name="lesson_duration[]"
              id="lesson_duration-${iteration}"
              class="form-control lesson_duration"
              value="${data ? data.lesson_duration : ""}"
              autocomplete="off"
              placeholder="09:00"
              onkeyup="changeValueDuration(${iteration})"
            />
          </div>
        </div>
        <div class="col-md-3 col-sm-12">
          <div class="d-flex gap-1 mb-3 h-100 align-items-center" style="padding-top: 10px">
            <button class="btn btn-danger" type="button" onclick="eraseLesson(${iteration})">
              Hapus
              <i class='bx bx-trash'></i>
            </button>
          </div>
        </div>
      </div>`;

      document.querySelectorAll(".lesson_duration").forEach(function(f) {
        new Cleave(f, {
          time: true,
          timePattern: ['h', 'm']
        });
      });
    });
  }

  function changeValueTitle(elementId) {
    const selector = document.querySelector(`#lessonsWrapper-${elementId}`);
    if (selector) {
      leassons[elementId].lesson_title = selector.querySelector(`#lesson_title-${elementId}`).value;
    }
  }

  function changeValueLink(elementId) {
    const selector = document.querySelector(`#lessonsWrapper-${elementId}`);
    if (selector) {
      leassons[elementId].lesson_link = selector.querySelector(`#lesson_link-${elementId}`).value;
    }
  }

  function changeValueDuration(elementId) {
    const selector = document.querySelector(`#lessonsWrapper-${elementId}`);
    if (selector) {
      leassons[elementId].lesson_duration = selector.querySelector(`#lesson_duration-${elementId}`).value;
    }
  }

  function submitData(element) {
    element.disabled = true;
    document.querySelector("#form").submit();
  }
</script>
@endpush