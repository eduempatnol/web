@extends("layouts.applayout")
@section("class", "active")

@push("css")
<link type="text/css" rel="stylesheet" href="{{ asset("css/page.css") }}" />
<link type="text/css" rel="stylesheet" href="{{ mix("css/app.css") }}" />
@endpush

@section("content")
<div class="row" id="wrapper-course">
  <div class="col-sm-12 transition-all" id="list-course">
    <div class="card">
      <div class="card-body">
        <h3 class="text-2xl mb-3">List kelas</h3>
        <div class="row">
          @foreach ($courseCheckout as $myCourse)
            <div class="col-md-3 col-sm-6 col-class mb-3">
              <div class="shadow rounded overflow-hidden cursor-pointer" onclick="showCourse({{ $myCourse->id }})">
                <img src="{{ asset($myCourse->course->course_thumbnail) }}" class="img-fluid" alt="">
                <div class="p-3">
                  <span class="fw-bold">{{ $myCourse->course->course_title }}</span>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push("js")
<script>
  let courseActive = false;
  let courseActiveLink = "";

  function showCourse(param) {
    $.get(`/user/class/${param}`, function(response, status) {
      // console.log(response);
      if (!courseActive) {
        $("#list-course").removeClass("col-sm-12");
        $("#list-course").addClass("col-md-8 col-sm-12");
        $(".col-class").removeClass("col-md-3 col-sm-6");
        $(".col-class").addClass("col-md-4 col-sm-6");

        $("#wrapper-course").append(`
          <div class="col-md-4 col-sm-12 mt-3 transition-all" id="course-active">
            <div class="wrapper-course-detail" id="course-video-playback">
              <iframe src="${response.data.course.lessons[0].lesson_link}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
            </div>
            <div class="mt-3 rounded-[16px] bg-white p-[25px]">
              ${response.data.course.lessons.map((data, iter) => {
                if (iter == 0) courseActiveLink = response.data.course.lessons[0].lesson_link;
                return `
                  <button
                    class="bg-secondary-2 rounded-full flex items-center justify-between gap-3 p-3 w-full mb-3 btn-can-playback ${iter == 0 ? "course-button-active" : ""}"
                    onclick="playCourse(${iter}, '${decodeURI(data.lesson_link)}')"
                    id="btn-can-playback-${iter}"
                  >
                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" style="fill: #34364a;transform: ;msFilter:;"><path d="M12 2C6.486 2 2 6.486 2 12s4.486 10 10 10 10-4.486 10-10S17.514 2 12 2zm0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8z"></path><path d="m9 17 8-5-8-5z"></path></svg>
                    <div class="text-black text-left flex-1 text-1line">${data.lesson_title}</div>
                    <span>${data.lesson_duration}</span>
                  </button>
                `;
              }).join("", ",")}
            </div>
          </div>
        `);

        courseActive = true;
      }
    });
  }

  function playCourse(btnIter, lessonLink) {
    $(".btn-can-playback").removeClass("course-button-active");
    $(`#btn-can-playback-${btnIter}`).addClass("course-button-active");
    $("#course-video-playback").empty();
    $("#course-video-playback").append(`
      <iframe src="${lessonLink.replace("watch?v=", "v/")}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
    `);
  }
</script>
@endpush