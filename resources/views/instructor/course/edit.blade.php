@extends("layouts.applayout")
@section("courses", "active")
@section("title", "- Edit Kursus")

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
        <form action="{{ route("instructor.course.update", $course->id) }}" id="form" method="POST" enctype="multipart/form-data">
          @method("PUT")
          @csrf
          <div class="row">
            <div class="col-md-6 col-sm-12">
              <div class="d-flex flex-column gap-1 mb-3">
                <label for="course_title">Judul Kursus</label>
                <input
                  type="text"
                  id="course_title"
                  name="course_title"
                  class="form-control"
                  autocomplete="off"
                  placeholder="Complete Freelancer UI/UX & Illustration Designer: Brief, Wireframe, Visual Design, Portfolio"
                  value="{{ $course->course_title }}"
                />
              </div>
            </div>
            <div class="col-md-6 col-sm-12">
              <div class="d-flex flex-column gap-1 mb-3">
                <label for="course_tagline">Tagline / Slogan</label>
                <input
                  type="text"
                  name="course_tagline"
                  id="course_tagline"
                  class="form-control"
                  autocomplete="off"
                  placeholder="Preparing Yourself to Be Professional UI Freelancer"
                  value="{{ $course->course_tagline }}"
                />
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-8 col-sm-12">
              <div class="d-flex flex-column gap-1 mb-3">
                <label for="course_description">Deskripsi</label>
                <textarea name="course_description" id="course_description" cols="30" rows="10">{{ $course->course_description }}</textarea>
              </div>
            </div>
            <div class="col-md-4 col-sm-12">
              <div class="d-flex flex-column gap-1 mb-3">
                <label for="course_thumbnail">Thumbnail</label>
                <input type="file" class="form-control" name="course_thumbnail" id="course_thumbnail">
                <small class="text-info">Rekomendasi ukuran 593x385 (Landscape)</small>
                <img id="image" src="{{ asset($course->course_thumbnail) }}" class="image-fluid mt-2 rounded" />
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 col-sm-12">
              <div class="d-flex flex-column gap-1 mb-3">
                <label for="course_price">Harga Kursus</label>
                <input
                  type="text"
                  id="course_price"
                  name="course_price"
                  class="form-control"
                  autocomplete="off"
                  placeholder="100.000"
                  value="{{ $course->course_price }}"
                />
              </div>
            </div>
            <div class="col-md-4 col-sm-12">
              <div class="d-flex flex-column gap-1 mb-3">
                <label for="course_certificate">Sertifikat Kursus</label>
                <select name="course_certificate" id="course_certificate" class="form-control">
                  <option value="">Pilih Ketersediaan</option>
                  <option value="1" {{ $course->course_certificate == 1 ? "selected" : "" }}>Tersedia</option>
                  <option value="0" {{ $course->course_certificate == 0 ? "selected" : "" }}>Tidak Tersedia</option>
                </select>
              </div>
            </div>
            <div class="col-md-4 col-sm-12">
              <div class="d-flex flex-column gap-1 mb-3">
                <label for="consultation_certificate">Konsultasi Kursus</label>
                <select name="consultation_certificate" id="consultation_certificate" class="form-control">
                  <option value="">Pilih Ketersediaan</option>
                  <option value="1" {{ $course->consultation_certificate == 1 ? "selected" : "" }}>Tersedia</option>
                  <option value="0" {{ $course->consultation_certificate == 0 ? "selected" : "" }}>Tidak Tersedia</option>
                </select>
              </div>
            </div>
            <div id="consultation_true" class="row">
              @if ($course->consultation_certificate == 1)
                <div class="col-md-6 col-sm-12">
                  <div class="d-flex flex-column gap-1 mb-3">
                    <label for="consultation_link">Link Konsultasi</label>
                    <input
                      type="text"
                      id="consultation_link"
                      name="consultation_link"
                      class="form-control"
                      autocomplete="off"
                      placeholder="https://us06web.zoom.us/j/83335090701"
                      value="{{ $course->consultation_link }}"
                    >
                  </div>
                </div>
                <div class="col-md-6 col-sm-12">
                  <div class="row">
                    <div class="col-md-6 col-sm-12">
                      <div class="d-flex flex-column gap-1 mb-3">
                        <label for="consultation_date">Tanggal Konsultasi</label>
                        <input
                          type="date"
                          id="consultation_date"
                          name="consultation_date"
                          class="form-control"
                          autocomplete="off"
                          value="{{ $course->consultation_date ? explode(" ", $course->consultation_date)[0] : "" }}"
                        />
                      </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                      <div class="d-flex flex-column gap-1 mb-3">
                        <label for="consultation_time">Waktu Konsultasi</label>
                        <input
                          type="time"
                          id="consultation_time"
                          name="consultation_time"
                          class="form-control"
                          autocomplete="off"
                          value="{{ $course->consultation_date ? explode(" ", $course->consultation_date)[1] : "" }}"
                        />
                      </div>
                    </div>
                  </div>
                </div>
              @endif
            </div>
          </div>
          <div class="mt-4">
            <h4>PELAJARAN</h4>
            <button type="button" class="btn btn-sm btn-success" onclick="addLessons()">Tambah Pelajaran</button>
            <div class="mt-3" id="lessons-wrapper">
              @if (count($course->lessons) > 0)
                <script>
                  let leassons = [];
                </script>
                @foreach ($course->lessons as $key => $lesson)
                  <script>
                    leassons.push({
                      lesson_title: "{{ $lesson->lesson_title }}",
                      lesson_link: "{{ $lesson->lesson_link }}",
                      lesson_duration: "{{ $lesson->lesson_duration }}"
                    });
                  </script>
                  <div class="row" id="lessonsWrapper-{{ $key }}">
                    <div class="col-md-3 col-sm-12">
                      <div class="d-flex flex-column gap-1 mb-3">
                        <label for="lesson_title">Judul Pelajaran</label>
                        <input
                          type="text"
                          name="lesson_title[]"
                          id="lesson_title-{{ $key }}"
                          class="form-control"
                          value="{{ $lesson->lesson_title }}"
                          autocomplete="off"
                          placeholder="Goals Kelas UIUX Illustration"
                          onkeyup="changeValueTitle({{ $key }})"
                        />
                      </div>
                    </div>
                    <div class="col-md-3 col-sm-12">
                      <div class="d-flex flex-column gap-1 mb-3">
                        <label for="lesson_link">Link Pelajaran</label>
                        <input
                          type="text"
                          name="lesson_link[]"
                          id="lesson_link-{{ $key }}"
                          class="form-control"
                          value="{{ $lesson->lesson_link }}"
                          autocomplete="off"
                          placeholder="https://www.youtube.com/embed/yTsl4w1a_4o?si=uC3nR8AZXowBmW62"
                          onkeyup="changeValueLink({{ $key }})"
                        />
                      </div>
                    </div>
                    <div class="col-md-3 col-sm-12">
                      <div class="d-flex flex-column gap-1 mb-3">
                        <label for="lesson_duration">Durasi Pelajaran</label>
                        <input
                          type="text"
                          name="lesson_duration[]"
                          id="lesson_duration-{{ $key }}"
                          class="form-control lesson_duration"
                          value="{{ $lesson->lesson_duration }}"
                          autocomplete="off"
                          placeholder="09:00"
                          onkeyup="changeValueDuration({{ $key }})"
                        />
                      </div>
                    </div>
                    <div class="col-md-3 col-sm-12">
                      <div class="d-flex gap-1 mb-3 h-100 align-items-center" style="padding-top: 10px">
                        <button class="btn btn-danger" type="button" onclick="eraseLesson({{ $key }})">
                          Hapus
                          <i class='bx bx-trash'></i>
                        </button>
                      </div>
                    </div>
                  </div>
                @endforeach
              @endif
            </div>
          </div>
          <div class="mt-4">
            <div class="d-flex gap-1 align-items-center">
              <h4>E-BOOK</h4>
              <small class="text-danger">(*Hapus baris jika tidak ada ebook)</small>
            </div>
            <button type="button" class="btn btn-sm btn-success" onclick="addEbooks()">Tambah E-Book</button>
            <div class="mt-3" id="ebooks-wrapper">
              @if (count($course->ebooks) > 0)
                <script>
                  let ebooks = [];
                </script>
                @foreach ($course->ebooks as $kbook => $ebook)
                  <script>
                    ebooks.push({
                      ebook_title: "{{ $ebook->ebook_title }}",
                      ebook_link: "{{ $ebook->ebook_link }}",
                    });
                  </script>
                  <div class="row" id="ebooksWrapper-{{ $kbook }}">
                    <div class="col-md-4 col-sm-12">
                      <div class="d-flex flex-column gap-1 mb-3">
                        <label for="ebook_title">Judul Ebook</label>
                        <input
                          type="text"
                          name="ebook_title[]"
                          id="ebook_title-{{ $kbook }}"
                          class="form-control"
                          value="{{ $ebook->ebook_title }}"
                          autocomplete="off"
                          placeholder="Perancangan Percobaan"
                          onkeyup="changeValueTitleEbook({{ $kbook }})"
                        />
                      </div>
                    </div>
                    <div class="col-md-5 col-sm-12">
                      <div class="d-flex flex-column gap-1 mb-3">
                        <label for="ebook_link">Link Ebook</label>
                        <input
                          type="text"
                          name="ebook_link[]"
                          id="ebook_link-{{ $kbook }}"
                          class="form-control"
                          value="{{ $ebook->ebook_link }}"
                          autocomplete="off"
                          placeholder="https://simdos.unud.ac.id/uploads/file_pendidikan_1_dir/cc429295fa1c78b491ca20550e03dd97.pdf"
                          onkeyup="changeValueLinkEbook({{ $kbook }})"
                        />
                      </div>
                    </div>
                    <div class="col-md-3 col-sm-12">
                      <div class="d-flex gap-1 mb-3 h-100 align-items-center" style="padding-top: 10px">
                        <button class="btn btn-danger" type="button" onclick="eraseEbook({{ $kbook }})">
                          Hapus
                          <i class='bx bx-trash'></i>
                        </button>
                      </div>
                    </div>
                  </div>
                @endforeach
              @endif
            </div>
          </div>
          <div class="mt-4">
            <div class="d-flex gap-1 align-items-center">
              <h4>QUIS</h4>
              <small class="text-danger">(*Hapus baris jika tidak ada quis)</small>
            </div>
            <button type="button" class="btn btn-sm btn-success" onclick="addQuis()">Tambah Quis</button>
            <div class="mt-3" id="quis-wrapper">
              @if (count($course->quis) > 0)
                <script>
                  let quis = [];
                </script>
                @foreach ($course->quis as $kquis => $quis)
                  <script>
                    quis.push({
                      question: "{{ $quis->question }}",
                      type: "{{ $quis->type }}",
                      a: "{{ $quis->a }}",
                      b: "{{ $quis->b }}",
                      c: "{{ $quis->c }}",
                      d: "{{ $quis->d }}",
                      answer: "",
                    });
                  </script>
                  <div class="row" id="quisWrapper-{{ $kquis }}">
                    <div class="col-md-8 col-sm-12">
                      <div class="d-flex flex-column gap-1 mb-3">
                        <label for="question">Pertanyaan</label>
                        <input
                          type="text"
                          name="question[]"
                          id="question-{{ $kquis }}"
                          class="form-control"
                          value="{{ $quis->question }}"
                          autocomplete="off"
                          placeholder="eg: Siapa nama kamu?"
                          onkeyup="changeQuisQuestion({{ $kquis }})"
                        />
                      </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                      <div class="d-flex flex-column gap-1 mb-3">
                        <label for="type">Tipe</label>
                        <select
                          name="type[]"
                          class="form-control"
                          value="{{ $quis->type }}"
                          id="type-{{ $kquis }}"
                          onchange="changeQuisType({{ $kquis }})"
                        >
                          <option value="">Pilih Tipe</option>
                          <option value="choice" {{ $quis->type == "choice" ? "selected" : "" }}>Pilihan Ganda</option>
                          <option value="essays" {{ $quis->type == "essays" ? "selected" : "" }}>Jawaban Esay</option>
                        </select>
                      </div>
                    </div>
                    <div id="wrapperType-{{ $kquis }}" class="row">
                      @if ($quis->type == "choice")
                        <div class="col-md-3 col-sm-6">
                          <div class="d-flex flex-column gap-1 mb-3">
                            <label for="a">A.</label>
                            <input
                              type="text"
                              name="a[]"
                              id="a-{{ $kquis }}"
                              class="form-control"
                              value="{{ $quis->A }}"
                              autocomplete="off"
                              placeholder="eg: Apel"
                              onkeyup="changeQuisAnswerA({{ $kquis }})"
                            />
                          </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                          <div class="d-flex flex-column gap-1 mb-3">
                            <label for="b">B.</label>
                            <input
                              type="text"
                              name="b[]"
                              id="b-{{ $kquis }}"
                              class="form-control"
                              value="{{ $quis->B }}"
                              autocomplete="off"
                              placeholder="eg: Jeruk"
                              onkeyup="changeQuisAnswerB({{ $kquis }})"
                            />
                          </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                          <div class="d-flex flex-column gap-1 mb-3">
                            <label for="c">C.</label>
                            <input
                              type="text"
                              name="c[]"
                              id="c-{{ $kquis }}"
                              class="form-control"
                              value="{{ $quis->C }}"
                              autocomplete="off"
                              placeholder="eg: Mangga"
                              onkeyup="changeQuisAnswerC({{ $kquis }})"
                            />
                          </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                          <div class="d-flex flex-column gap-1 mb-3">
                            <label for="d">D.</label>
                            <input
                              type="text"
                              name="d[]"
                              id="d-{{ $kquis }}"
                              class="form-control"
                              value="{{ $quis->D }}"
                              autocomplete="off"
                              placeholder="eg: Pepaya"
                              onkeyup="changeQuisAnswerD({{ $kquis }})"
                            />
                          </div>
                        </div>
                      @else
                        <input type="hidden" type="text" name="a[]" />
                        <input type="hidden" type="text" name="b[]" />
                        <input type="hidden" type="text" name="c[]" />
                        <input type="hidden" type="text" name="d[]" />
                      @endif
                    </div>
                  </div>
                @endforeach
              @endif
            </div>
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

  $("#course_thumbnail").change(function() {
    const preview = document.querySelector("#image");
    const file = $(this).get(0).files[0];
    const reader = new FileReader();

    reader.addEventListener("load", () => {
      preview.src = reader.result;
    }, false);

    if (file) {
      reader.readAsDataURL(file);
    }
  });

  $("#consultation_certificate").change(function() {
    if ($(this).val() == 1) {
      $("#consultation_true").append(`
        <div class="col-md-6 col-sm-12">
          <div class="d-flex flex-column gap-1 mb-3">
            <label for="consultation_link">Link Konsultasi</label>
            <input type="text" id="consultation_link" name="consultation_link" class="form-control" autocomplete="off" placeholder="https://us06web.zoom.us/j/83335090701">
          </div>
        </div>
        <div class="col-md-6 col-sm-12">
          <div class="row">
            <div class="col-md-6 col-sm-12">
              <div class="d-flex flex-column gap-1 mb-3">
                <label for="consultation_date">Tanggal Konsultasi</label>
                <input type="date" id="consultation_date" name="consultation_date" class="form-control" autocomplete="off">
              </div>
            </div>
            <div class="col-md-6 col-sm-12">
              <div class="d-flex flex-column gap-1 mb-3">
                <label for="consultation_time">Waktu Konsultasi</label>
                <input type="time" id="consultation_time" name="consultation_time" class="form-control" autocomplete="off">
              </div>
            </div>
          </div>
        </div>
      `);
    } else {
      $("#consultation_true").empty();
    }
  });

  const lessonsWrapper = document.getElementById("lessons-wrapper");

  function addLessons() {
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

  const ebooksWrapper = document.getElementById("ebooks-wrapper");

  function addEbooks() {
    ebooks.push({
      ebook_title: "",
      ebook_link: "",
    });
    elementEbook();
  }

  function elementEbook() {
    ebooksWrapper.innerHTML = "";

    ebooks.forEach((data, iteration) => {
      ebooksWrapper.innerHTML += `<div class="row" id="ebooksWrapper-${iteration}">
        <div class="col-md-4 col-sm-12">
          <div class="d-flex flex-column gap-1 mb-3">
            <label for="ebook_title">Judul Ebook</label>
            <input
              type="text"
              name="ebook_title[]"
              id="ebook_title-${iteration}"
              class="form-control"
              value="${data ? data.ebook_title : ""}"
              autocomplete="off"
              placeholder="Perancangan Percobaan"
              onkeyup="changeValueTitleEbook(${iteration})"
            />
          </div>
        </div>
        <div class="col-md-5 col-sm-12">
          <div class="d-flex flex-column gap-1 mb-3">
            <label for="ebook_link">Link Ebook</label>
            <input
              type="text"
              name="ebook_link[]"
              id="ebook_link-${iteration}"
              class="form-control"
              value="${data ? data.ebook_link : ""}"
              autocomplete="off"
              placeholder="https://simdos.unud.ac.id/uploads/file_pendidikan_1_dir/cc429295fa1c78b491ca20550e03dd97.pdf"
              onkeyup="changeValueLinkEbook(${iteration})"
            />
          </div>
        </div>
        <div class="col-md-3 col-sm-12">
          <div class="d-flex gap-1 mb-3 h-100 align-items-center" style="padding-top: 10px">
            <button class="btn btn-danger" type="button" onclick="eraseEbook(${iteration})">
              Hapus
              <i class='bx bx-trash'></i>
            </button>
          </div>
        </div>
      </div>`;
    });
  }

  function eraseEbook(iteration) {
    const selector = document.querySelector(`#ebooksWrapper-${iteration}`);
    if (selector) {
      ebooks.splice(iteration, 1);
      selector.remove();
    }

    elementEbook();
  }

  function changeValueTitleEbook(elementId) {
    const selector = document.querySelector(`#ebooksWrapper-${elementId}`);
    if (selector) {
      ebooks[elementId].ebook_title = selector.querySelector(`#ebook_title-${elementId}`).value;
    }
  }

  function changeValueLinkEbook(elementId) {
    const selector = document.querySelector(`#ebooksWrapper-${elementId}`);
    if (selector) {
      ebooks[elementId].ebook_link = selector.querySelector(`#ebook_link-${elementId}`).value;
    }
  }

  const quisWrapper = document.getElementById("quis-wrapper");

  function addQuis() {
    quis.push({
      question: "",
      type: "",
      a: "",
      b: "",
      c: "",
      d: "",
      answer: "",
    });
    elementQuis();
  }

  function elementQuis() {
    quisWrapper.innerHTML = "";

    quis.forEach((data, iteration) => {
      quisWrapper.innerHTML += `<div class="row" id="quisWrapper-${iteration}">
        <div class="col-md-8 col-sm-12">
          <div class="d-flex flex-column gap-1 mb-3">
            <label for="question">Pertanyaan</label>
            <input
              type="text"
              name="question[]"
              id="question-${iteration}"
              class="form-control"
              value="${data ? data.question : ""}"
              autocomplete="off"
              placeholder="eg: Siapa nama kamu?"
              onkeyup="changeQuisQuestion(${iteration})"
            />
          </div>
        </div>
        <div class="col-md-4 col-sm-12">
          <div class="d-flex flex-column gap-1 mb-3">
            <label for="type">Tipe</label>
            <select
              name="type[]"
              class="form-control"
              value="${data ? data.type : ""}"
              id="type-${iteration}"
              onchange="changeQuisType(${iteration})"
            >
              <option value="" selected>Pilih Tipe</option>
              <option value="choice">Pilihan Ganda</option>
              <option value="essays">Jawaban Esay</option>
            </select>
          </div>
        </div>
        <div id="wrapperType-${iteration}" class="row"></div>
      </div>`;
    });
  }

  function changeQuisQuestion(elementId) {
    const selector = document.querySelector(`#quisWrapper-${elementId}`);
    if (selector) {
      quis[elementId].question = selector.querySelector(`#question-${elementId}`).value;
    }
  }

  function changeQuisType(elementId) {
    const selector = document.querySelector(`#quisWrapper-${elementId}`);
    if (selector) {
      quis[elementId].type = selector.querySelector(`#type-${elementId}`).value;
    }

    const selectorType = document.querySelector(`#wrapperType-${elementId}`);
    if (selectorType) {
      if (quis[elementId].type == "choice") {
        selectorType.innerHTML = `
          <div class="col-md-3 col-sm-6">
            <div class="d-flex flex-column gap-1 mb-3">
              <label for="a">A.</label>
              <input
                type="text"
                name="a[]"
                id="a-${elementId}"
                class="form-control"
                value="${quis[elementId].a ? quis[elementId].a : ""}"
                autocomplete="off"
                placeholder="eg: Apel"
                onkeyup="changeQuisAnswerA(${elementId})"
              />
            </div>
          </div>
          <div class="col-md-3 col-sm-6">
            <div class="d-flex flex-column gap-1 mb-3">
              <label for="b">B.</label>
              <input
                type="text"
                name="b[]"
                id="b-${elementId}"
                class="form-control"
                value="${quis[elementId].b ? quis[elementId].b : ""}"
                autocomplete="off"
                placeholder="eg: Jeruk"
                onkeyup="changeQuisAnswerB(${elementId})"
              />
            </div>
          </div>
          <div class="col-md-3 col-sm-6">
            <div class="d-flex flex-column gap-1 mb-3">
              <label for="c">C.</label>
              <input
                type="text"
                name="c[]"
                id="c-${elementId}"
                class="form-control"
                value="${quis[elementId].c ? quis[elementId].c : ""}"
                autocomplete="off"
                placeholder="eg: Mangga"
                onkeyup="changeQuisAnswerC(${elementId})"
              />
            </div>
          </div>
          <div class="col-md-3 col-sm-6">
            <div class="d-flex flex-column gap-1 mb-3">
              <label for="d">D.</label>
              <input
                type="text"
                name="d[]"
                id="d-${elementId}"
                class="form-control"
                value="${quis[elementId].d ? quis[elementId].d : ""}"
                autocomplete="off"
                placeholder="eg: Pepaya"
                onkeyup="changeQuisAnswerD(${elementId})"
              />
            </div>
          </div>
        `;
      }
      else if (quis[elementId].type == "essays") {
        selectorType.innerHTML = `
          <input type="hidden" type="text" name="a[]" />
          <input type="hidden" type="text" name="b[]" />
          <input type="hidden" type="text" name="c[]" />
          <input type="hidden" type="text" name="d[]" />
        `;
      }
      else {
        selectorType.innerHTML = `
          <input type="hidden" type="text" name="a[]" />
          <input type="hidden" type="text" name="b[]" />
          <input type="hidden" type="text" name="c[]" />
          <input type="hidden" type="text" name="d[]" />
        `;
      }
    }
  }

  function changeQuisAnswerA(elementId) {
    const selector = document.querySelector(`#wrapperType-${elementId}`);
    if (selector) {
      quis[elementId].a = selector.querySelector(`#a-${elementId}`).value;
    }
  }

  function changeQuisAnswerB(elementId) {
    const selector = document.querySelector(`#wrapperType-${elementId}`);
    if (selector) {
      quis[elementId].b = selector.querySelector(`#b-${elementId}`).value;
    }
  }

  function changeQuisAnswerC(elementId) {
    const selector = document.querySelector(`#wrapperType-${elementId}`);
    if (selector) {
      quis[elementId].c = selector.querySelector(`#c-${elementId}`).value;
    }
  }

  function changeQuisAnswerD(elementId) {
    const selector = document.querySelector(`#wrapperType-${elementId}`);
    if (selector) {
      quis[elementId].d = selector.querySelector(`#d-${elementId}`).value;
    }
  }

  function submitData(element) {
    element.disabled = true;
    document.querySelector("#form").submit();
  }
</script>
@endpush