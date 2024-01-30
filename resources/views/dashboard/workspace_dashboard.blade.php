@extends('layouts.admin')
@section('page-title')
    {{ __('Dashboard') }}
@endsection
@push('css-page')
    <style>
        .glide__slide {
            width:200px !important;
        }
    </style>
@endpush
@push('script-page')
    <script></script>
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('clientuser.dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Workspace') }}</li>
@endsection
@php
    $setting = \App\Models\Utility::settings();
@endphp
{{-- @php
    $stat = 'Welcome';
    date_default_timezone_set('Asia/Karachi'); // Set the timezone to Pakistan
    $currentTime = date('H:i'); // Get the current time in 24-hour format
    if ($currentTime >= '05:00' && $currentTime < '11:30') {
        $stat = 'Good Morning';
    } elseif ($currentTime >= '11:30' && $currentTime < '17:30') {
        $stat = 'Good Afternoon';
    } elseif ($currentTime >= '17:30' && $currentTime < '20:00') {
        $stat = 'Good Evening';
    } else {
        $stat = 'Good Night';
    }
@endphp --}}
@section('content')
    <div class=" row">
        {{-- <!-- Title and Top Buttons Start -->
        <div class="page-title-container">
            <div class="row">
                <!-- Title Start -->
                <div class="col-12 col-md-7">
                    <span class="align-middle text-muted d-inline-block lh-1 pb-2 pt-2 text-small">Home</span>
                    <h1 class="mb-0 pb-0 display-6" id="title">{{ $stat }}, {{ $user->name }}</h1>
                </div>
                <!-- Title End -->
            </div>
        </div>
        <!-- Title and Top Buttons End --> --}}

        <div class="row">
            <div class="col-xl-12">
                <!-- Stats Start -->
                <h2 class="small-title">Stats</h2>
                <div class="row gx-2">
                    <div class="col-12 p-0">
                        <div class="glide glide-small" id="statsCarousel">
                            <div class="glide__track" data-glide-el="track">
                                <div class="glide__slides">
                                    <div class="glide__slide">
                                        <div class="card mb-5 hover-border-primary">
                                            <div class="h-100 d-flex flex-column justify-content-between card-body align-items-center">
                                                <div class="sw-8 sh-8 rounded-xl d-flex justify-content-center align-items-center border border-primary">
                                                    <i data-acorn-icon="blood" class="text-primary"></i>
                                                </div>
                                                <a href="{{ route('space.index') }}">
                                                    <div class="text-center mb-0 sh-8 d-flex align-items-center lh-1-5">
                                                        Total
                                                        <br />
                                                        Space
                                                    </div>
                                                    <div class="display-6 text-primary">{{ $space }}</div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="glide__slide">
                                        <div class="card mb-5 hover-border-primary">
                                            <div class="h-100 d-flex flex-column justify-content-between card-body align-items-center">
                                                <div class="sw-8 sh-8 rounded-xl d-flex justify-content-center align-items-center border border-primary">
                                                    <i data-acorn-icon="heart" class="text-primary"></i>
                                                </div>
                                                <a href="{{ route('space_details',['type' => 'used']) }}">
                                                    <div class="text-center mb-0 sh-8 d-flex align-items-center lh-1-5">
                                                        Used
                                                        <br />
                                                        space
                                                    </div>
                                                    <div class="display-6 text-primary">{{ $use_space }}</div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="glide__slide">
                                        <div class="card mb-5 hover-border-primary">
                                            <div class="h-100 d-flex flex-column justify-content-between card-body align-items-center">
                                                <div class="sw-8 sh-8 rounded-xl d-flex justify-content-center align-items-center border border-primary">
                                                    <i data-acorn-icon="laboratory" class="text-primary"></i>
                                                </div>
                                                <a href="{{ route('space_details',['type' => 'vacant']) }}">
                                                    <div class="text-center mb-0 sh-8 d-flex align-items-center lh-1-5">
                                                        Vacant
                                                        <br />
                                                        Space
                                                    </div>
                                                </a>
                                                <div class="display-6 text-primary">{{ $free_space }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="glide__slide">
                                        <div class="card mb-5 hover-border-primary">
                                            <div class="h-100 d-flex flex-column justify-content-between card-body align-items-center">
                                                <div class="sw-8 sh-8 rounded-xl d-flex justify-content-center align-items-center border border-primary">
                                                    <i data-acorn-icon="weight" class="text-primary"></i>
                                                </div>
                                                <a href="{{ route('space.index') }}">
                                                    <div class="text-center mb-0 sh-8 d-flex align-items-center lh-1-5">
                                                        Total
                                                        <br />
                                                        Visiter
                                                    </div>
                                                    <div class="display-6 text-primary">{{ $visit }}</div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="glide__slide">
                                        <div class="card mb-5 hover-border-primary">
                                            <div class="h-100 d-flex flex-column justify-content-between card-body align-items-center">
                                                <div class="sw-8 sh-8 rounded-xl d-flex justify-content-center align-items-center border border-primary">
                                                    <i data-acorn-icon="weight" class="text-primary"></i>
                                                </div>
                                                <a href="{{ route('space.index') }}">
                                                    <div class="text-center mb-0 sh-8 d-flex align-items-center lh-1-5">
                                                        Total
                                                        <br />
                                                        Mail
                                                    </div>
                                                    <div class="display-6 text-primary">{{ $mail }}</div>
                                                </a>
                                            </div>
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
                <!-- Booking Start -->
                <div class="col-xl-12 mb-5">
                    <div class="d-flex justify-content-between">
                        <h2 class="small-title">Bookings</h2>
                        <button class="btn btn-icon btn-icon-end btn-xs btn-background-alternate p-0 text-small"
                            type="button">
                            <a href="#" data-size="md" data-url="{{ route('bookings.create') }}"
                                data-ajax-popup="true" data-title="{{ __('Create Booking') }}" id="createBookingLink"><span
                                    class="align-bottom">Add New Booking</span></a>
                            <i data-acorn-icon="chevron-right" class="align-middle" data-acorn-size="12"></i>
                        </button>
                    </div>
                    <div class="card h-xl-100-card hover-border-primary">
                        <div class="card-header border-0 pb-0 ">
                            <div class="row">
                                <div class="col-lg-12">
                                    {{-- <a href="#" data-size="md" data-url="{{ route('bookings.create') }}" style="float: right; margin:1%" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Booking')}}" data-title="{{__('Create Booking')}}"  id="createBookingLink" class="btn btn-sm btn-primary">
                                            <i class="ti ti-plus"></i>
                                        </a> --}}
                                    <select class="form-control" name="space_id" id="space_id"
                                        style="float: right;width: 150px;" onchange="get_data()">\
                                        @foreach ($spaces as $space)
                                            <option value="{{ $space->id }}">{{ $space->name }}</option>
                                        @endforeach
                                    </select>

                                    <input type="hidden" id="task_calendar" value="{{ url('/') }}">
                                </div>

                            </div>
                        </div>
                        <div class="card-body pt-3">
                            <div id='calendar' class='calendar'></div>
                        </div>
                    </div>
                </div>
                <!-- Booking End -->
                <div class="col-xl-6 mb-5">
                    <div class="d-flex justify-content-between">
                        <h2 class="small-title"></h2>
                        <button class="btn btn-icon btn-icon-end btn-xs btn-background-alternate p-0 text-small"
                            type="button">
                            <a href="#" data-size="md" data-url="{{ route('isvisitor.create') }}" data-ajax-popup="true"  data-title="{{ __('Create Visitor') }}"><span class="align-bottom">Add New Visitor</span></a>
                            <i data-acorn-icon="chevron-right" class="align-middle" data-acorn-size="12"></i>
                        </button>
                    </div>

                    <div class="card hover-border-primary">
                        <div class="card-header">
                            <h5>Your Vistors</h5>
                        </div>
                        <div class="card-body" style="min-height: 250px;">
                            <div class="table-responsive">
                                @if (count($visitors) > 0)
                                    <table class="table align-items-center">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Name') }}</th>
                                                <th>{{ __('Date') }}</th>
                                                <th>{{ __('Time') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody class="list">
                                            @foreach ($visitors as $visitor)
                                                <tr>
                                                    <td>{{ $visitor->name }}</td>
                                                    <td>{{ \Auth::user()->dateFormat($visitor->date_time) }}</td>
                                                    <td>{{ \Auth::user()->timeFormat($visitor->date_time) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <div class="p-2 text-primary">
                                        {{ __('No visitors yet.') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-xl-6 mb-5">
                    <div class="d-flex justify-content-between">
                        <h2 class="small-title"></h2>
                        <button class="btn btn-icon btn-icon-end btn-xs btn-background-alternate p-0 text-small" type="button">
                            <a href="#" data-size="md" data-url="{{ route('ismail.create') }}" data-ajax-popup="true" data-title="{{ __('Create Mail') }}""  >Add New Mail</span></a>
                            <i data-acorn-icon="chevron-right" class="align-middle" data-acorn-size="12"></i>
                        </button>
                       
                    </div>
        
                    <div class="card hover-border-primary">
                        <div class="card-header">
                            <h5>Your Mails</h5>
                        </div>
                        <div class="card-body" style="min-height: 250px;">
                            <div class="table-responsive">
                                @if (count($mails) > 0)
                                    <table class="table align-items-center">
                                        <thead>
                                            <tr>
                                                <th>{{__('Name')}}</th>
                                                <th>{{__('Date')}}</th>
                                                <th>{{__('Price')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody class="list">
                                            @foreach ($mails as $mail)
                                                <tr>
                                                    <td>
                                                        {{ (!empty($mail->name)) ? $mail->name : '-' }}
                                                    </td>
                                                    <td>
                                                        {{ (!empty($mail->date)) ? $mail->date : '-' }}
                                                    </td>
                                                    <td>
                                                        {{ (!empty($mail->price)) ? $mail->price : '-' }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <div class="p-2 text-primary">
                                        {{ __('No visitors yet.') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
        
                </div>
            </div>
        </div>
    </div>


    </div>
@endsection


@push('script-page')
    <script src="{{ asset('assets/js/plugins/main.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#createBookingLink").on("click", function() {
                var space_id = $('#space_id :selected').val();
                $("#createBookingLink").attr("data-url", "{{ route('bookings.create') }}/" + space_id);
            });

            get_data();
        });

        function get_data() {
            var calender_type = 'local_calender';
            var space_id = $('#space_id :selected').val();
            $('#calendar').removeClass('local_calender');
            $('#calendar').removeClass('goggle_calender');
            if (calender_type == undefined) {
                $('#calendar').addClass('local_calender');
            }
            $('#calendar').addClass(calender_type);
            $.ajax({
                url: $("#task_calendar").val() + "/bookingcalendar/get_task_data",

                method: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    'calender_type': calender_type,
                    'space_id': space_id
                },
                success: function(data) {
                    // console.log(data);
                    (function() {
                        var etitle;
                        var etype;
                        var etypeclass;
                        var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {

                            headerToolbar: {
                                left: 'prev,next today',
                                center: 'title',
                                right: 'dayGridMonth,timeGridWeek,timeGridDay'
                            },
                            buttonText: {
                                timeGridDay: "{{ __('Day') }}",
                                timeGridWeek: "{{ __('Week') }}",
                                dayGridMonth: "{{ __('Month') }}"
                            },

                            themeSystem: 'bootstrap',
                            slotDuration: '00:15:00',
                            slotMinTime: '07:00:00', // Set your desired start time here
                            slotMaxTime: '23:00:00', // Set your desired end time here
                            allDaySlot: true,
                            navLinks: true,
                            droppable: true,
                            selectable: true,
                            selectMirror: true,
                            editable: true,
                            dayMaxEvents: true,
                            handleWindowResize: true,
                            initialView: 'dayGridMonth',
                            dayMaxEvents: true,
                            height: 'auto',
                            events: data,
                        });

                        calendar.render();
                    })();
                }
            });
        }
    </script>
@endpush
