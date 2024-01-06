@extends('layouts.admin')
@section('page-title')
    {{__('Dashboard')}}
@endsection
@push('css-page')
  <!-- Font Tags Start -->
  <link rel="preconnect" href="https://fonts.gstatic.com" />
  <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;700&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('acron/style.css')}}" />
  <!-- Font Tags End -->
  <!-- Vendor Styles Start -->
  <link rel="stylesheet" href="{{ asset('acron/bootstrap.min.css')}}" />
  <link rel="stylesheet" href="{{ asset('acron/OverlayScrollbars.min.css')}}" />
  <link rel="stylesheet" href="{{ asset('acron/css/vendor/fullcalendar.min.css')}}" />
  <link rel="stylesheet" href="{{ asset('acron/glide.core.min.css')}}" />

  <!-- Vendor Styles End -->
  <!-- Template Base Styles Start -->
  <link rel="stylesheet" href="{{ asset('acron/styles.css')}}" />
  <!-- Template Base Styles End -->

  <link rel="stylesheet" href="{{ asset('acron/main.css')}}" />
  <script src="{{ asset('acron/loader.js')}}"></script>
@endpush
@push('script-page')
 <!-- Vendor Scripts Start -->
 <script src="{{ asset('acron/jquery-3.5.1.min.js')}}"></script>
 <script src="{{ asset('acron/bootstrap.bundle.min.js')}}"></script>
 <script src="{{ asset('acron/OverlayScrollbars.min.js')}}"></script>
 <script src="{{ asset('acron/autoComplete.min.js')}}"></script>
 <script src="{{ asset('acron/clamp.min.js')}}"></script>
 <script src="{{ asset('acron/acorn-icons.js')}}"></script>
 <script src="{{ asset('acron/acorn-icons-interface.js')}}"></script>
 <script src="{{ asset('acron/acorn-icons-medical.js')}}"></script>

 <script src="{{ asset('acron/glide.min.js')}}"></script>

 <!-- Vendor Scripts End -->

 <!-- Template Base Scripts Start -->
 <script src="{{ asset('acron/helpers.js')}}"></script>
 <script src="{{ asset('acron/globals.js')}}"></script>
 <script src="{{ asset('acron/nav.js')}}"></script>
 <script src="{{ asset('acron/search.js')}}"></script>
 <script src="{{ asset('acron/settings.js')}}"></script>
 <!-- Template Base Scripts End -->
 <!-- Page Specific Scripts Start -->

 <script src="{{ asset('acron/glide.custom.js')}}"></script>

 <script src="{{ asset('acron/dashboards.patient.js')}}"></script>

 <script src="{{ asset('acron/common.js')}}"></script>
 <script src="{{ asset('acron/scripts.js')}}"></script>
 <script src="{{ asset('acron/fullcalendar/main.min.js')}}"></script>
 <!-- Page Specific Scripts End -->
@endpush
@push('script-page')
    <script>
        $(document).ready(function()
        {
            get_data();
        });

        function get_data()
        {
            var calender_type=$('#calender_type :selected').val();
            $('#calendar').removeClass('local_calender');
            $('#calendar').removeClass('goggle_calender');
            if(calender_type==undefined){
                $('#calendar').addClass('local_calender');
            }
            $('#calendar').addClass(calender_type);
            $.ajax({
                url: $("#event_dashboard").val()+"/event/get_event_data" ,
                method:"POST",
                data: {"_token": "{{ csrf_token() }}",'calender_type':calender_type},
                success: function(data) {
                    (function () {
                        var etitle;
                        var etype;
                        var etypeclass;
                        var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
                            headerToolbar: {
                                left: 'prev,next today',
                                center: 'title',
                                right: 'timeGridDay,timeGridWeek,dayGridMonth'
                            },
                            buttonText: {
                                timeGridDay: "{{__('Day')}}",
                                timeGridWeek: "{{__('Week')}}",
                                dayGridMonth: "{{__('Month')}}"
                            },
                            slotLabelFormat: {
                                hour: '2-digit',
                                minute: '2-digit',
                                hour12: false,
                            },
                            themeSystem: 'bootstrap',
                            navLinks: true,
                            droppable: true,
                            selectable: true,
                            selectMirror: true,
                            editable: true,
                            dayMaxEvents: true,
                            handleWindowResize: true,
                            height: 'auto',
                            timeFormat: 'H(:mm)',
                            {{--events: {!! json_encode($arrEvents) !!},--}}
                            events: data,
                            locale: '{{basename(App::getLocale())}}',
                            dayClick: function (e) {
                                var t = moment(e).toISOString();
                                $("#new-event").modal("show"), $(".new-event--title").val(""), $(".new-event--start").val(t), $(".new-event--end").val(t)
                            },
                            eventResize: function (event) {
                                var eventObj = {
                                    start: event.start.format(),
                                    end: event.end.format(),
                                };
                            },
                            viewRender: function (t) {
                                e.fullCalendar("getDate").month(), $(".fullcalendar-title").html(t.title)
                            },
                            eventClick: function (e, t) {
                                var title = e.title;
                                var url = e.url;

                                if (typeof url != 'undefined') {
                                    $("#commonModal .modal-title").html(title);
                                    $("#commonModal .modal-dialog").addClass('modal-md');
                                    $("#commonModal").modal('show');
                                    $.get(url, {}, function (data) {
                                        $('#commonModal .modal-body').html(data);
                                    });
                                    return false;
                                }
                            }
                        });
                        calendar.render();
                    })();
                }
            });
        }
    </script>
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('clientuser.dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('HRM')}}</li>
@endsection
@php
    $setting = \App\Models\Utility::settings();
@endphp
@php
    $stat = 'Welcome';
   date_default_timezone_set('Asia/Karachi'); // Set the timezone to Pakistan
    $currentTime = date('H:i'); // Get the current time in 24-hour format
if ($currentTime >= '05:00' && $currentTime < '11:30') {
    $stat = 'Good Morning';
} elseif ($currentTime >= '11:30' && $currentTime < '17:30') {
    $stat = 'Good Afternoon';
} elseif ($currentTime >= '17:30' && $currentTime < '20:00') {
    $stat = 'Good Evening';
}else {
    $stat = 'Good Night';
}
@endphp
@section('content')
<div class="container row">
    <!-- Title and Top Buttons Start -->
    <div class="page-title-container">
      <div class="row">
        <!-- Title Start -->
        <div class="col-12 col-md-7">
          {{-- <span class="align-middle text-muted d-inline-block lh-1 pb-2 pt-2 text-small">Home</span> --}}
          <h1 class="mb-0 pb-0 display-4" id="title">{{$stat}}, {{$user->name}}</h1>
        </div>
        <!-- Title End -->
      </div>
    </div>
    <!-- Title and Top Buttons End -->

    <div class="row">
      <div class="col-xl-4 mb-5">
        <!-- About Start -->
        <h2 class="small-title">About</h2>
        <div class="card h-100-card">
          <div class="card-body">
            <div class="d-flex align-items-center flex-column mb-4">
              <div class="d-flex align-items-center flex-column">
                <div class="sw-13 position-relative mb-3">
                  <img src="img/profile/profile-1.webp" class="img-fluid rounded-xl" alt="thumb" />
                </div>
                <div class="h5 mb-0">{{$user->name}}</div>
                {{-- <div class="text-muted">Highschool Teacher</div> --}}
              </div>
            </div>
            <div class="d-flex justify-content-between mb-2">
              <div class="text-center">
                <p class="text-small text-muted mb-1">BLOOD</p>
                <p>A+</p>
              </div>
              <div class="text-center">
                <p class="text-small text-muted mb-1">AGE</p>
                <p>27</p>
              </div>
              <div class="text-center">
                <p class="text-small text-muted mb-1">WEIGHT</p>
                <p>64</p>
              </div>
              {{-- <div class="text-center">
                <p class="text-small text-muted mb-1">HEIGHT</p>
                <p>1.68</p>
              </div> --}}
            </div>
            <div class="mb-5">
              <p class="text-small text-muted mb-2">DIOGNOSTICS</p>
              <div class="row g-0 mb-2">
                <div class="col-auto">
                  <div class="sw-3 me-1">
                    <i data-acorn-icon="lungs" class="text-primary" data-acorn-size="17"></i>
                  </div>
                </div>
                <div class="col text-alternate">Allergic Rhinitis</div>
              </div>
              <div class="row g-0 mb-2">
                <div class="col-auto">
                  <div class="sw-3 me-1">
                    <i data-acorn-icon="brain" class="text-primary" data-acorn-size="17"></i>
                  </div>
                </div>
                <div class="col text-alternate">Diabetic Ketoacidosis</div>
              </div>
              <div class="row g-0 mb-2">
                <div class="col-auto">
                  <div class="sw-3 me-1">
                    <i data-acorn-icon="stomach" class="text-primary" data-acorn-size="17"></i>
                  </div>
                </div>
                <div class="col text-alternate">Cervical Spondylosis</div>
              </div>
            </div>

            <div class="mb-5">
              <p class="text-small text-muted mb-2">CONTACT</p>
              <div class="row g-0 mb-2">
                <div class="col-auto">
                  <div class="sw-3 me-1">
                    <i data-acorn-icon="phone" class="text-primary" data-acorn-size="17"></i>
                  </div>
                </div>
                <div class="col text-alternate">+6443884455</div>
              </div>
              <div class="row g-0 mb-2">
                <div class="col-auto">
                  <div class="sw-3 me-1">
                    <i data-acorn-icon="email" class="text-primary" data-acorn-size="17"></i>
                  </div>
                </div>
                <div class="col text-alternate">aliciaowens@gmail.com</div>
              </div>
              <div class="row g-0 mb-2">
                <div class="col-auto">
                  <div class="sw-3 me-1">
                    <i data-acorn-icon="pin" class="text-primary" data-acorn-size="17"></i>
                  </div>
                </div>
                <div class="col text-alternate">Wellington New Zealand</div>
              </div>
            </div>

            <div>
              <p class="text-small text-muted mb-2">NOTES</p>
              <div class="row g-0">
                <div class="col-auto">
                  <div class="sw-3 me-1">
                    <i data-acorn-icon="warning-hexagon" class="text-primary" data-acorn-size="17"></i>
                  </div>
                </div>
                <div class="col text-alternate align-middle">Penicillin Allergy</div>
              </div>
            </div>
          </div>
        </div>
        <!-- About End -->
      </div>
      <div class="col-xl-8">
        <!-- Stats Start -->
        <h2 class="small-title">Stats</h2>
        <div class="row gx-2">
          <div class="col-12 p-0">
            <div class="glide glide-small" id="statsCarousel">
              <div class="glide__track" data-glide-el="track">
                <div class="glide__slides">
                  <div class="glide__slide">
                    <div class="card mb-5 hover-border-primary">
                      <span class="position-absolute e-3 t-4 z-index-1">
                        <i data-acorn-icon="check" class="text-primary" data-acorn-size="14"></i>
                      </span>
                      <div class="h-100 d-flex flex-column justify-content-between card-body align-items-center">
                        <div class="sw-8 sh-8 rounded-xl d-flex justify-content-center align-items-center border border-primary">
                          <i data-acorn-icon="blood" class="text-primary"></i>
                        </div>
                        <div class="text-center mb-0 sh-8 d-flex align-items-center lh-1-5">
                          Blood
                          <br />
                          Pressure
                        </div>
                        <div class="display-6 text-primary">115/74</div>
                      </div>
                    </div>
                  </div>
                  <div class="glide__slide">
                    <div class="card mb-5 hover-border-primary">
                      <span class="position-absolute e-3 t-4 z-index-1">
                        <i data-acorn-icon="check" class="text-primary" data-acorn-size="14"></i>
                      </span>
                      <div class="h-100 d-flex flex-column justify-content-between card-body align-items-center">
                        <div class="sw-8 sh-8 rounded-xl d-flex justify-content-center align-items-center border border-primary">
                          <i data-acorn-icon="heart" class="text-primary"></i>
                        </div>
                        <div class="text-center mb-0 sh-8 d-flex align-items-center lh-1-5">
                          Heart
                          <br />
                          Rate
                        </div>
                        <div class="display-6 text-primary">93</div>
                      </div>
                    </div>
                  </div>
                  <div class="glide__slide">
                    <div class="card mb-5 hover-border-primary">
                      <span class="position-absolute e-3 t-4 z-index-1">
                        <i data-acorn-icon="chevron-bottom" class="text-primary" data-acorn-size="14"></i>
                      </span>
                      <div class="h-100 d-flex flex-column justify-content-between card-body align-items-center">
                        <div class="sw-8 sh-8 rounded-xl d-flex justify-content-center align-items-center border border-primary">
                          <i data-acorn-icon="laboratory" class="text-primary"></i>
                        </div>
                        <div class="text-center mb-0 sh-8 d-flex align-items-center lh-1-5">
                          Glucose
                          <br />
                          Level
                        </div>
                        <div class="display-6 text-primary">82</div>
                      </div>
                    </div>
                  </div>
                  <div class="glide__slide">
                    <div class="card mb-5 hover-border-primary">
                      <span class="position-absolute e-3 t-4 z-index-1">
                        <i data-acorn-icon="chevron-top" class="text-primary" data-acorn-size="14"></i>
                      </span>
                      <div class="h-100 d-flex flex-column justify-content-between card-body align-items-center">
                        <div class="sw-8 sh-8 rounded-xl d-flex justify-content-center align-items-center border border-primary">
                          <i data-acorn-icon="weight" class="text-primary"></i>
                        </div>
                        <div class="text-center mb-0 sh-8 d-flex align-items-center lh-1-5">
                          Body Mass
                          <br />
                          Index
                        </div>
                        <div class="display-6 text-primary">19.4</div>
                      </div>
                    </div>
                  </div>
                  <div class="glide__slide">
                    <div class="card mb-5 hover-border-primary">
                      <span class="position-absolute e-3 t-4 z-index-1">
                        <i data-acorn-icon="check" class="text-primary" data-acorn-size="14"></i>
                      </span>
                      <div class="h-100 d-flex flex-column justify-content-between card-body align-items-center">
                        <div class="sw-8 sh-8 rounded-xl d-flex justify-content-center align-items-center border border-primary">
                          <i data-acorn-icon="thermometer" class="text-primary"></i>
                        </div>
                        <div class="text-center mb-0 sh-8 d-flex align-items-center lh-1-5">
                          Body
                          <br />
                          Temperature
                        </div>
                        <div class="display-6 text-primary">37.2</div>
                      </div>
                    </div>
                  </div>
                  <div class="glide__slide">
                    <div class="card mb-5 hover-border-primary">
                      <span class="position-absolute e-3 t-4 z-index-1">
                        <i data-acorn-icon="check" class="text-primary" data-acorn-size="14"></i>
                      </span>
                      <div class="h-100 d-flex flex-column justify-content-between card-body align-items-center">
                        <div class="sw-8 sh-8 rounded-xl d-flex justify-content-center align-items-center border border-primary">
                          <i data-acorn-icon="blood-bag" class="text-primary"></i>
                        </div>
                        <div class="text-center mb-0 sh-8 d-flex align-items-center lh-1-5">
                          Blood
                          <br />
                          Count
                        </div>
                        <div class="display-6 text-primary">4.2</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Stats End -->

        <div class="row">
          <!-- Appointments Start -->
          <div class="col-xl-6 mb-5">
            <div class="d-flex justify-content-between">
              <h2 class="small-title">Appointments</h2>
              <button class="btn btn-icon btn-icon-end btn-xs btn-background-alternate p-0 text-small" type="button">
                <span class="align-bottom">Add New</span>
                <i data-acorn-icon="chevron-right" class="align-middle" data-acorn-size="12"></i>
              </button>
            </div>
            <div class="card h-xl-100-card">
              <div class="card-header border-0 pb-0 d-flex justify-content-center">
                <div class="glide-tab-container">
                  <div class="glide glide-tab" id="appointmentsCarousel">
                    <div id="calendar" class="compact h-100"></div>
                    <div class="glide__track" data-glide-el="track">
                      <div class="glide__slides nav nav-pills" role="tablist">
                        <div class="glide__slide active" data-bs-toggle="tab" data-bs-target="#dayOne" role="tab" aria-selected="true">
                          <button class="btn btn-foreground hover-outline px-1 py-3 rounded-xl sw-4" type="button">
                            <div class="text-alternate mb-2">Mo</div>
                            <div class="text-primary">18</div>
                          </button>
                        </div>
                        <div class="glide__slide" data-bs-toggle="tab" data-bs-target="#dayNone" role="tab" aria-selected="false">
                          <button class="btn btn-foreground hover-outline px-1 py-3 rounded-xl sw-4" type="button">
                            <div class="text-separator mb-2">Tu</div>
                            <div class="text-separator">19</div>
                          </button>
                        </div>
                        <div class="glide__slide" data-bs-toggle="tab" data-bs-target="#dayTwo" role="tab" aria-selected="false">
                          <button class="btn btn-foreground hover-outline px-1 py-3 rounded-xl sw-4" type="button">
                            <div class="text-alternate mb-2">We</div>
                            <div class="text-primary">20</div>
                          </button>
                        </div>
                        <div class="glide__slide" data-bs-toggle="tab" data-bs-target="#dayThree" role="tab" aria-selected="false">
                          <button class="btn btn-foreground hover-outline px-1 py-3 rounded-xl sw-4" type="button">
                            <div class="text-alternate mb-2">Th</div>
                            <div class="text-primary">21</div>
                          </button>
                        </div>

                        <div class="glide__slide" data-bs-toggle="tab" data-bs-target="#dayNone" role="tab" aria-selected="false">
                          <button class="btn btn-foreground hover-outline px-1 py-3 rounded-xl sw-4" type="button">
                            <div class="text-separator mb-2">Fr</div>
                            <div class="text-separator">22</div>
                          </button>
                        </div>
                        <div class="glide__slide" data-bs-toggle="tab" data-bs-target="#dayNone" role="tab" aria-selected="false">
                          <button class="btn btn-foreground hover-outline px-1 py-3 rounded-xl sw-4" type="button">
                            <div class="text-separator mb-2">St</div>
                            <div class="text-separator">23</div>
                          </button>
                        </div>
                        <div class="glide__slide" data-bs-toggle="tab" data-bs-target="#dayNone" role="tab" aria-selected="false">
                          <button class="btn btn-foreground hover-outline px-1 py-3 rounded-xl sw-4" type="button">
                            <div class="text-separator mb-2">Su</div>
                            <div class="text-separator">24</div>
                          </button>
                        </div>
                        <div class="glide__slide" data-bs-toggle="tab" data-bs-target="#dayNone" role="tab" aria-selected="false">
                          <button class="btn btn-foreground hover-outline px-1 py-3 rounded-xl sw-4" type="button">
                            <div class="text-separator mb-2">Mo</div>
                            <div class="text-separator">25</div>
                          </button>
                        </div>
                        <div class="glide__slide" data-bs-toggle="tab" data-bs-target="#dayNone" role="tab" aria-selected="false">
                          <button class="btn btn-foreground hover-outline px-1 py-3 rounded-xl sw-4" type="button">
                            <div class="text-separator mb-2">Tu</div>
                            <div class="text-separator">26</div>
                          </button>
                        </div>
                        <div class="glide__slide" data-bs-toggle="tab" data-bs-target="#dayNone" role="tab" aria-selected="false">
                          <button class="btn btn-foreground hover-outline px-1 py-3 rounded-xl sw-4" type="button">
                            <div class="text-separator mb-2">We</div>
                            <div class="text-separator">27</div>
                          </button>
                        </div>
                        <div class="glide__slide" data-bs-toggle="tab" data-bs-target="#dayNone" role="tab" aria-selected="false">
                          <button class="btn btn-foreground hover-outline px-1 py-3 rounded-xl sw-4" type="button">
                            <div class="text-separator mb-2">Th</div>
                            <div class="text-separator">28</div>
                          </button>
                        </div>
                        <div class="glide__slide" data-bs-toggle="tab" data-bs-target="#dayNone" role="tab" aria-selected="false">
                          <button class="btn btn-foreground hover-outline px-1 py-3 rounded-xl sw-4" type="button">
                            <div class="text-separator mb-2">Fr</div>
                            <div class="text-separator">29</div>
                          </button>
                        </div>
                      </div>
                    </div>
                    <div class="glide__arrows" data-glide-el="controls">
                      <button class="btn btn-icon btn-icon-only btn-link left-arrow btn-sm mt-3" data-glide-dir="<">
                        <i data-acorn-icon="chevron-left"></i>
                      </button>
                      <button class="btn btn-icon btn-icon-only btn-link right-arrow btn-sm mt-3" data-glide-dir=">">
                        <i data-acorn-icon="chevron-right"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-body pt-3">
                <div class="tab-content">
                  <div class="tab-pane fade active show mb-n3" id="dayOne" role="tabpanel">
                    <div class="mb-4 text-primary text-center">18 December 2021, Monday</div>
                    <div class="row g-0 mb-3">
                      <div class="col-auto">
                        <div class="sw-5 d-inline-block d-flex align-items-center pt-1">
                          <i data-acorn-icon="lungs" class="text-primary"></i>
                        </div>
                      </div>
                      <div class="col">
                        <div class="card-body d-flex flex-column ps-0 pt-0 pb-0 h-100 justify-content-center">
                          <div class="d-flex flex-column">
                            <div class="text-body">Rheumatologist</div>
                            <div class="text-muted">12:00</div>
                            <div class="text-muted">Zayn Hartley, M.D.</div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row g-0 mb-3">
                      <div class="col-auto">
                        <div class="sw-5 d-inline-block d-flex align-items-center pt-1">
                          <i data-acorn-icon="surgery" class="text-primary"></i>
                        </div>
                      </div>
                      <div class="col">
                        <div class="card-body d-flex flex-column ps-0 pt-0 pb-0 h-100 justify-content-center">
                          <div class="d-flex flex-column">
                            <div class="text-body">Surgeon</div>
                            <div class="text-muted">14:00</div>
                            <div class="text-muted">Carmelo Avril, M.B.B.S.</div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row g-0 mb-3">
                      <div class="col-auto">
                        <div class="sw-5 d-inline-block d-flex align-items-center pt-1">
                          <i data-acorn-icon="stomach" class="text-primary"></i>
                        </div>
                      </div>
                      <div class="col">
                        <div class="card-body d-flex flex-column ps-0 pt-0 pb-0 h-100 justify-content-center">
                          <div class="d-flex flex-column">
                            <div class="text-body">Endocrinologist</div>
                            <div class="text-muted">14:30</div>
                            <div class="text-muted">Wiebe Rodolfo, M.D.</div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade mb-n3" id="dayTwo" role="tabpanel">
                    <div class="mb-4 text-primary text-center">20 December 2021, Wednesday</div>
                    <div class="row g-0 mb-3">
                      <div class="col-auto">
                        <div class="sw-5 d-inline-block d-flex align-items-center pt-1">
                          <i data-acorn-icon="xray" class="text-primary"></i>
                        </div>
                      </div>
                      <div class="col">
                        <div class="card-body d-flex flex-column ps-0 pt-0 pb-0 h-100 justify-content-center">
                          <div class="d-flex flex-column">
                            <div class="text-body">Ophthalmologist</div>
                            <div class="text-muted">10:00</div>
                            <div class="text-muted">Zayn Hartley, M.D.</div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row g-0 mb-3">
                      <div class="col-auto">
                        <div class="sw-5 d-inline-block d-flex align-items-center pt-1">
                          <i data-acorn-icon="gynecology" class="text-primary"></i>
                        </div>
                      </div>
                      <div class="col">
                        <div class="card-body d-flex flex-column ps-0 pt-0 pb-0 h-100 justify-content-center">
                          <div class="d-flex flex-column">
                            <div class="text-body">Surgeon</div>
                            <div class="text-muted">11:30</div>
                            <div class="text-muted">Carmelo Avril, M.B.B.S.</div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row g-0 mb-3">
                      <div class="col-auto">
                        <div class="sw-5 d-inline-block d-flex align-items-center pt-1">
                          <i data-acorn-icon="dna" class="text-primary"></i>
                        </div>
                      </div>
                      <div class="col">
                        <div class="card-body d-flex flex-column ps-0 pt-0 pb-0 h-100 justify-content-center">
                          <div class="d-flex flex-column">
                            <div class="text-body">Otolaryngologist</div>
                            <div class="text-muted">11:45</div>
                            <div class="text-muted">Kathryn Mengel, M.D.</div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade mb-n3" id="dayThree" role="tabpanel">
                    <div class="mb-4 text-primary text-center">21 December 2021, Thursday</div>
                    <div class="row g-0 mb-3">
                      <div class="col-auto">
                        <div class="sw-5 d-inline-block d-flex align-items-center pt-1">
                          <i data-acorn-icon="dermatology" class="text-primary"></i>
                        </div>
                      </div>
                      <div class="col">
                        <div class="card-body d-flex flex-column ps-0 pt-0 pb-0 h-100 justify-content-center">
                          <div class="d-flex flex-column">
                            <div class="text-body">Dermatologist</div>
                            <div class="text-muted">12:00</div>
                            <div class="text-muted">Carmelo Avril, M.B.B.S.</div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row g-0 mb-3">
                      <div class="col-auto">
                        <div class="sw-5 d-inline-block d-flex align-items-center pt-1">
                          <i data-acorn-icon="gynecology" class="text-primary"></i>
                        </div>
                      </div>
                      <div class="col">
                        <div class="card-body d-flex flex-column ps-0 pt-0 pb-0 h-100 justify-content-center">
                          <div class="d-flex flex-column">
                            <div class="text-body">Surgeon</div>
                            <div class="text-muted">14:00</div>
                            <div class="text-muted">Carmelo Avril, M.B.B.S.</div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row g-0 mb-3">
                      <div class="col-auto">
                        <div class="sw-5 d-inline-block d-flex align-items-center pt-1">
                          <i data-acorn-icon="stomach" class="text-primary"></i>
                        </div>
                      </div>
                      <div class="col">
                        <div class="card-body d-flex flex-column ps-0 pt-0 pb-0 h-100 justify-content-center">
                          <div class="d-flex flex-column">
                            <div class="text-body">Neurologist</div>
                            <div class="text-muted">18:30</div>
                            <div class="text-muted">Wiebe Rodolfo, M.D.</div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="dayNone" role="tabpanel">
                    <div class="mb-4 text-primary text-center">19 December 2021, Tuesday</div>
                    <div class="text-center">
                      <img src="img/illustration/icon-appointment.webp" class="theme-filter" alt="launch" />
                      <p>No appointments for the day!</p>
                      <button class="btn btn-icon btn-icon-start btn-primary" type="button">
                        <i data-acorn-icon="calendar"></i>
                        <span>New Appointment</span>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Appointments End -->

          <!-- Your Doctors Start -->
          <div class="col-xl-6 mb-5">
            <h2 class="small-title">Your Doctors</h2>
            <div class="card">
              <div class="card-body mb-n3 border-last-none">
                <div class="mb-3 pb-3 border-bottom border-separator-light">
                  <div class="row g-0 sh-6">
                    <div class="col-auto">
                      <a href="Doctors.Detail.html">
                        <img src="img/profile/profile-14.webp" class="card-img rounded-xl sh-6 sw-6" alt="thumb" />
                      </a>
                    </div>
                    <div class="col">
                      <div class="card-body d-flex flex-row pt-0 pb-0 ps-3 pe-0 h-100 align-items-center justify-content-between">
                        <div class="d-flex flex-column">
                          <a href="Doctors.Detail.html" class="body-link">Karter Kidd, M.D.</a>
                          <div class="text-small text-muted">Neurologist</div>
                        </div>
                        <div class="d-flex">
                          <button class="btn btn-outline-secondary btn-sm ms-1" type="button">Schedule</button>
                          <button class="btn btn-sm btn-icon btn-icon-only btn-outline-secondary ms-1" type="button">
                            <i data-acorn-icon="more-vertical"></i>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="mb-3 pb-3 border-bottom border-separator-light">
                  <div class="row g-0 sh-6">
                    <div class="col-auto">
                      <a href="Doctors.Detail.html">
                        <img src="img/profile/profile-12.webp" class="card-img rounded-xl sh-6 sw-6" alt="thumb" />
                      </a>
                    </div>
                    <div class="col">
                      <div class="card-body d-flex flex-row pt-0 pb-0 ps-3 pe-0 h-100 align-items-center justify-content-between">
                        <div class="d-flex flex-column">
                          <a href="Doctors.Detail.html" class="body-link">Carmelo Avril, M.B.B.S.</a>
                          <div class="text-small text-muted">Rheumatologist</div>
                        </div>
                        <div class="d-flex">
                          <button class="btn btn-outline-secondary btn-sm ms-1" type="button">Schedule</button>
                          <button class="btn btn-sm btn-icon btn-icon-only btn-outline-secondary ms-1" type="button">
                            <i data-acorn-icon="more-vertical"></i>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="mb-3 pb-3 border-bottom border-separator-light">
                  <div class="row g-0 sh-6">
                    <div class="col-auto">
                      <a href="Doctors.Detail.html">
                        <img src="img/profile/profile-13.webp" class="card-img rounded-xl sh-6 sw-6" alt="thumb" />
                      </a>
                    </div>
                    <div class="col">
                      <div class="card-body d-flex flex-row pt-0 pb-0 ps-3 pe-0 h-100 align-items-center justify-content-between">
                        <div class="d-flex flex-column">
                          <a href="Doctors.Detail.html" class="body-link">Wiebe Rodolfo, M.D.</a>
                          <div class="text-small text-muted">Psychiatrist</div>
                        </div>
                        <div class="d-flex">
                          <button class="btn btn-outline-secondary btn-sm ms-1" type="button">Schedule</button>
                          <button class="btn btn-sm btn-icon btn-icon-only btn-outline-secondary ms-1" type="button">
                            <i data-acorn-icon="more-vertical"></i>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="mb-3 pb-3 border-bottom border-separator-light">
                  <div class="row g-0 sh-6">
                    <div class="col-auto">
                      <a href="Doctors.Detail.html">
                        <img src="img/profile/profile-15.webp" class="card-img rounded-xl sh-6 sw-6" alt="thumb" />
                      </a>
                    </div>
                    <div class="col">
                      <div class="card-body d-flex flex-row pt-0 pb-0 ps-3 pe-0 h-100 align-items-center justify-content-between">
                        <div class="d-flex flex-column">
                          <a href="Doctors.Detail.html" class="body-link">Alma Holder, D.M.S.</a>
                          <div class="text-small text-muted">Ophthalmologist</div>
                        </div>
                        <div class="d-flex">
                          <button class="btn btn-outline-secondary btn-sm ms-1" type="button">Schedule</button>
                          <button class="btn btn-sm btn-icon btn-icon-only btn-outline-secondary ms-1" type="button">
                            <i data-acorn-icon="more-vertical"></i>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="mb-3 border-bottom border-separator-light">
                  <div class="row g-0 sh-6">
                    <div class="col-auto">
                      <a href="Doctors.Detail.html">
                        <img src="img/profile/profile-16.webp" class="card-img rounded-xl sh-6 sw-6" alt="thumb" />
                      </a>
                    </div>
                    <div class="col">
                      <div class="card-body d-flex flex-row pt-0 pb-0 ps-3 pe-0 h-100 align-items-center justify-content-between">
                        <div class="d-flex flex-column">
                          <a href="Doctors.Detail.html" class="body-link">Isaac Mckee, D.O.</a>
                          <div class="text-small text-muted">Neurologist</div>
                        </div>
                        <div class="d-flex">
                          <button class="btn btn-outline-secondary btn-sm ms-1" type="button">Schedule</button>
                          <button class="btn btn-sm btn-icon btn-icon-only btn-outline-secondary ms-1" type="button">
                            <i data-acorn-icon="more-vertical"></i>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Your Doctors End -->
        </div>
      </div>
    </div>

    <div class="row">
      <!-- Results Start -->
      <div class="col-xl-6 mb-5">
        <h2 class="small-title">Results</h2>
        <div class="card mb-2 sh-11 sh-md-8">
          <div class="card-body pt-0 pb-0 h-100">
            <div class="row g-0 h-100 align-content-center">
              <div class="col-11 col-md-7 d-flex align-items-center mb-1 mb-md-0 order-1 order-md-1">
                <a href="Results.Detail.html" class="body-link text-truncate">
                  <i data-acorn-icon="file-text" class="sw-2 me-2 text-alternate" data-acorn-size="17"></i>
                  <span class="align-middle">blood-analysis.pdf</span>
                </a>
              </div>
              <div class="col-12 col-md-3 d-flex align-items-center justify-content-md-center text-muted order-3 order-md-2">12.11.2021</div>
              <div class="col-1 col-md-2 d-flex align-items-center text-muted text-medium justify-content-end order-2 order-md-3">
                <button class="btn btn-icon btn-icon-only btn-link btn-sm p-1" type="button">
                  <i data-acorn-icon="arrow-bottom"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
        <div class="card mb-2 sh-11 sh-md-8">
          <div class="card-body pt-0 pb-0 h-100">
            <div class="row g-0 h-100 align-content-center">
              <div class="col-11 col-md-7 d-flex align-items-center mb-1 mb-md-0 order-1 order-md-1">
                <a href="Results.Detail.html" class="body-link text-truncate">
                  <i data-acorn-icon="image" class="sw-2 me-2 text-alternate" data-acorn-size="17"></i>
                  <span class="align-middle">hearth-imaging.pdf</span>
                </a>
              </div>
              <div class="col-12 col-md-3 d-flex align-items-center justify-content-md-center text-muted order-3 order-md-2">05.11.2021</div>
              <div class="col-1 col-md-2 d-flex align-items-center text-muted text-medium justify-content-end order-2 order-md-3">
                <button class="btn btn-icon btn-icon-only btn-link btn-sm p-1" type="button">
                  <i data-acorn-icon="arrow-bottom"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
        <div class="card mb-2 sh-11 sh-md-8">
          <div class="card-body pt-0 pb-0 h-100">
            <div class="row g-0 h-100 align-content-center">
              <div class="col-11 col-md-7 d-flex align-items-center mb-1 mb-md-0 order-1 order-md-1">
                <a href="Results.Detail.html" class="body-link text-truncate">
                  <i data-acorn-icon="file-text" class="sw-2 me-2 text-alternate" data-acorn-size="17"></i>
                  <span class="align-middle">blood-analysis.pdf</span>
                </a>
              </div>
              <div class="col-12 col-md-3 d-flex align-items-center justify-content-md-center text-muted order-3 order-md-2">02.11.2021</div>
              <div class="col-1 col-md-2 d-flex align-items-center text-muted text-medium justify-content-end order-2 order-md-3">
                <button class="btn btn-icon btn-icon-only btn-link btn-sm p-1" type="button">
                  <i data-acorn-icon="arrow-bottom"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
        <div class="card sh-11 sh-md-8">
          <div class="card-body pt-0 pb-0 h-100">
            <div class="row g-0 h-100 align-content-center">
              <div class="col-11 col-md-7 d-flex align-items-center mb-1 mb-md-0 order-1 order-md-1">
                <a href="Results.Detail.html" class="body-link text-truncate">
                  <i data-acorn-icon="file-text" class="sw-2 me-2 text-alternate" data-acorn-size="17"></i>
                  <span class="align-middle">allergy-test.pdf</span>
                </a>
              </div>
              <div class="col-12 col-md-3 d-flex align-items-center justify-content-md-center text-muted order-3 order-md-2">02.11.2021</div>
              <div class="col-1 col-md-2 d-flex align-items-center text-muted text-medium justify-content-end order-2 order-md-3">
                <button class="btn btn-icon btn-icon-only btn-link btn-sm p-1" type="button">
                  <i data-acorn-icon="arrow-bottom"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Results End -->

      <!-- Check Up Start -->
      <div class="col-xl-6 mb-5">
        <h2 class="small-title">Check Up</h2>
        <div class="card w-100 sh-100 h-xl-100-card hover-img-scale-up position-relative">
          <img src="img/banner/cta-doctor.webp" class="card-img h-100 scale position-absolute" alt="card image" />
          <div class="card-img-overlay d-flex flex-column justify-content-between bg-transparent">
            <div>
              <div class="cta-2 mb-0 text-black w-75 w-sm-50">Check Yourself Up</div>
              <div class="cta-2 mb-3 text-black w-75 w-sm-50">30% Off</div>
              <div class="w-50 text-black mb-3">
                Liquorice caramels chupa chups bonbon. Jelly-o candy sugar chocolate cake caramels apple pie lollipop jujubes.
              </div>
            </div>
            <div>
              <a href="Appointments.New.html" class="btn btn-icon btn-icon-start btn-primary mt-3 stretched-link">
                <i data-acorn-icon="chevron-right"></i>
                <span>View</span>
              </a>
            </div>
          </div>
        </div>
      </div>
      <!-- Check Up End -->
    </div>
  </div>
@endsection


