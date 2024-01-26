@extends('layouts.admin')
@section('page-title')
    {{__('Dashboard')}}
@endsection
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
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}" class="text-primary">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item text-primary">{{__('HRM')}}</li>
@endsection
@php
    $setting = \App\Models\Utility::settings();
@endphp
@section('content')
    @if(\Auth::user()->type != 'client' && \Auth::user()->type != 'company' && \Auth::user()->type != 'branch')
        <div class="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-xxl-6">
                        <div class="card hover-border-primary">
                            <div class="card-header">
                                <h4>{{__('Mark Attandance')}}</h4>
                            </div>
                            <div class="card-body dash-card-body">
                                <p class="text-muted pb-0-5">{{__('My Office Time: '.$officeTime['startTime'].' to '.$officeTime['endTime'])}}</p>
                                <center>
                                    <div class="row">
                                        <div class="col-md-6">
                                            {{Form::open(array('url'=>'attendanceemployee/attendance','method'=>'post'))}}
                                            @if(empty($employeeAttendance) || $employeeAttendance->clock_out != '00:00:00')
                                                <button type="submit" value="0" name="in" id="clock_in" class="btn btn-success ">{{__('CLOCK IN')}}</button>
                                            @else
                                                <button type="submit" value="0" name="in" id="clock_in" class="btn btn-success disabled" disabled>{{__('CLOCK IN')}}</button>
                                            @endif
                                            {{Form::close()}}
                                        </div>
                                        <div class="col-md-6 ">
                                            @if(!empty($employeeAttendance) && $employeeAttendance->clock_out == '00:00:00')
                                                {{Form::model($employeeAttendance,array('route'=>array('attendanceemployee.update',$employeeAttendance->id),'method' => 'PUT')) }}
                                                <button type="submit" value="1" name="out" id="clock_out" class="btn btn-danger">{{__('CLOCK OUT')}}</button>
                                            @else
                                                <button type="submit" value="1" name="out" id="clock_out" class="btn btn-danger disabled" disabled>{{__('CLOCK OUT')}}</button>
                                            @endif
                                            {{Form::close()}}
                                        </div>
                                    </div>
                                </center>

                            </div>
                        </div>
                        <div class="card hover-border-primary">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h5>{{ __('Event') }}</h5>
                                    </div>
                                    <div class="col-lg-6">
                                        @if (isset($setting['google_calendar_enable']) && $setting['google_calendar_enable'] == 'on')
                                        <select class="form-control" name="calender_type" id="calender_type" style="float: right;width: 150px;" onchange="get_data()">
                                            <option value="goggle_calender">{{__('Google Calender')}}</option>
                                            <option value="local_calender" selected="true">{{__('Local Calender')}}</option>
                                        </select>
                                        @endif
                                        <input type="hidden" id="event_dashboard" value="{{url('/')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id='calendar' class='calendar e-height'></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-6">
                        <div class="card list_card">
                            <div class="card-header">
                                <h4>{{__('Announcement List')}}</h4>
                            </div>
                            <div class="card-body dash-card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">
                                        <thead>
                                        <tr>
                                            <th>{{__('Title')}}</th>
                                            <th>{{__('Start Date')}}</th>
                                            <th>{{__('End Date')}}</th>
                                            <th>{{__('description')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($announcements as $announcement)
                                            <tr>
                                                <td>{{ $announcement->title }}</td>
                                                <td>{{ \Auth::user()->dateFormat($announcement->start_date)  }}</td>
                                                <td>{{ \Auth::user()->dateFormat($announcement->end_date) }}</td>
                                                <td>{{ $announcement->description }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4">
                                                    <div class="text-center">
                                                        <h6>{{__('There is no Announcement List')}}</h6>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card list_card">
                            <div class="card-header">
                                <h4>{{__('Meeting List')}}</h4>
                            </div>
                            <div class="card-body dash-card-body">
                                @if(count($meetings) > 0)
                                    <div class="table-responsive">
                                        <table class="table align-items-center">
                                            <thead>
                                            <tr>
                                                <th>{{__('Meeting title')}}</th>
                                                <th>{{__('Meeting Date')}}</th>
                                                <th>{{__('Meeting Time')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @forelse($meetings as $meeting)
                                                <tr>
                                                    <td>{{ $meeting->title }}</td>
                                                    <td>{{ \Auth::user()->dateFormat($meeting->date) }}</td>
                                                    <td>{{ \Auth::user()->timeFormat($meeting->time) }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="p-2">
                                        {{__('No meeting scheduled yet.')}}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-xxl-12">
                <div class="card hover-border-primary">
                    <div class="card-header">
                        <h5>{{__("Today's Not Clock In")}}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row g-3 flex-nowrap team-lists horizontal-scroll-cards">
                                    @foreach($notClockIns as $notClockIn)
                                        <div class="col-auto">
                                            <img src="{{(!empty($notClockIn->user))? $notClockIn->user->profile : asset(Storage::url('uploads/avatar/avatar.png'))}}" alt="">
                                            <p class="mt-2">{{ $notClockIn->name }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-md-9">
                        <div class="card hover-border-primary">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h5>{{ __('Event') }}</h5>
                                    </div>
                                    <div class="col-lg-6">

                                        @if(isset($setting['google_calendar_enable']) && $setting['google_calendar_enable'] == 'on')
                                            <select class="form-control" name="calender_type" id="calender_type" style="float: right;width: 150px;" onchange="get_data()">
                                                <option value="goggle_calender">{{__('Google Calender')}}</option>
                                                <option value="local_calender" selected="true">{{__('Local Calender')}}</option>
                                            </select>
                                        @endif
                                        <input type="hidden" id="event_dashboard" value="{{url('/')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id='calendar' class='calendar'></div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-3">
                        <div class="col-xxl-12">
                            <div class="card hover-border-primary">
                                <div class="card-body">
                                    <h5>{{__('Staff')}}</h5>
                                    <div class="row  mt-4">
                                        <div class="col-md-6 col-sm-6">
                                            <div class="d-flex align-items-start mb-3">
                                                <svg width="64px" height="64px" viewBox="-102.4 -102.4 1228.80 1228.80" fill="#0ec4cb" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" stroke="#0ec4cb"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M1007.938 1023.934H815.96c-4.422 0-8-3.578-8-8v-26.418c0-19.608 12.89-26.074 24.964-30.59 13.688-5.14 28.324-13.608 31.214-17.17a8 8 0 0 1 15.844 1.546c0 13.966-31.714 26.95-41.434 30.59-12.574 4.718-14.59 7.874-14.59 15.624v18.42h175.976v-18.42c0-7.75-2.016-10.904-14.61-15.608-6.918-2.594-41.382-16.248-41.382-30.606a7.994 7.994 0 0 1 7.996-7.998 8.02 8.02 0 0 1 7.86 6.452c2.86 3.578 17.484 12.044 31.136 17.17 12.094 4.516 24.996 10.966 24.996 30.59v26.418a7.988 7.988 0 0 1-7.992 8z" fill=""></path><path d="M911.95 959.942c-27.34 0-63.96-37.918-63.96-76.678 0-38.37 27.496-67.302 63.96-67.302 37.074 0 63.992 28.308 63.992 67.302 0 38.76-36.638 76.678-63.992 76.678z m0-127.984c-27.792 0-47.964 21.576-47.964 51.306 0 32.59 32.168 60.68 47.964 60.68 15.808 0 47.992-28.09 47.992-60.68 0-29.73-20.184-51.306-47.992-51.306z" fill=""></path><path d="M951.942 951.3a7.992 7.992 0 0 1-7.996-7.998v-17.138a7.992 7.992 0 0 1 7.996-7.998c4.422 0 8 3.576 8 7.998v17.138a7.994 7.994 0 0 1-8 7.998zM871.984 951.3c-4.422 0-8-3.576-8-7.998v-17.138c0-4.422 3.578-7.998 8-7.998s8 3.576 8 7.998v17.138a7.994 7.994 0 0 1-8 7.998zM208.04 1023.934H16.066c-4.422 0-8-3.578-8-8v-26.418c0-19.608 12.896-26.074 24.99-30.59 13.67-5.14 28.31-13.608 31.184-17.17a8.006 8.006 0 0 1 7.85-6.452c4.422 0 8 3.578 8 7.998 0 13.982-31.708 26.95-41.416 30.59-12.592 4.718-14.608 7.888-14.608 15.624v18.42h175.978v-18.42c0-7.75-2.016-10.904-14.608-15.608-6.92-2.594-41.37-16.248-41.37-30.606a7.994 7.994 0 0 1 8-7.998 8.006 8.006 0 0 1 7.85 6.466c2.868 3.562 17.482 12.03 31.128 17.154 12.084 4.516 24.998 10.966 24.998 30.59v26.418a8 8 0 0 1-8.002 8.002z" fill=""></path><path d="M112.068 959.942c-27.34 0-63.976-37.918-63.976-76.678 0-38.37 27.504-67.302 63.976-67.302 37.082 0 63.992 28.308 63.992 67.302 0 38.76-36.644 76.678-63.992 76.678z m0-127.984c-27.8 0-47.978 21.576-47.978 51.306 0 32.59 32.182 60.68 47.978 60.68 15.802 0 47.994-28.09 47.994-60.68 0-29.73-20.186-51.306-47.994-51.306z" fill=""></path><path d="M152.064 951.3c-4.422 0-8-3.576-8-7.998v-17.138a7.994 7.994 0 0 1 8-7.998 7.994 7.994 0 0 1 7.998 7.998v17.138a7.994 7.994 0 0 1-7.998 7.998zM72.088 951.3c-4.422 0-8-3.576-8-7.998v-17.138c0-4.422 3.578-7.998 8-7.998s8 3.576 8 7.998v17.138a7.994 7.994 0 0 1-8 7.998zM1007.938 208.04H815.96c-4.422 0-8-3.578-8-8V173.622c0-19.606 12.89-26.074 24.964-30.59 13.688-5.14 28.324-13.608 31.214-17.168a8 8 0 0 1 15.844 1.546c0 13.966-31.714 26.95-41.434 30.59-12.574 4.718-14.59 7.876-14.59 15.624v18.42h175.976v-18.42c0-7.748-2.016-10.904-14.61-15.608-6.918-2.592-41.382-16.248-41.382-30.606a7.994 7.994 0 0 1 7.996-7.998 8.02 8.02 0 0 1 7.86 6.452c2.86 3.578 17.484 12.044 31.136 17.168 12.094 4.516 24.996 10.968 24.996 30.59v26.418c0.004 4.42-3.574 8-7.992 8z" fill=""></path><path d="M911.95 144.046c-27.34 0-63.96-37.916-63.96-76.678 0-38.37 27.496-67.302 63.96-67.302 37.074 0 63.992 28.308 63.992 67.302 0 38.762-36.638 76.678-63.992 76.678z m0-127.982c-27.792 0-47.964 21.574-47.964 51.304 0 32.59 32.168 60.68 47.964 60.68 15.808 0 47.992-28.09 47.992-60.68 0-29.73-20.184-51.304-47.992-51.304z" fill=""></path><path d="M951.942 135.408a7.994 7.994 0 0 1-7.996-8v-17.138c0-4.42 3.578-8 7.996-8 4.422 0 8 3.578 8 8v17.138c0 4.422-3.578 8-8 8zM871.984 135.408c-4.422 0-8-3.578-8-8v-17.138c0-4.42 3.578-8 8-8s8 3.578 8 8v17.138c0 4.422-3.578 8-8 8zM208.04 208.04H16.066c-4.422 0-8-3.578-8-8V173.622c0-19.606 12.896-26.074 24.99-30.59 13.67-5.14 28.31-13.608 31.184-17.168a8.006 8.006 0 0 1 7.85-6.452c4.422 0 8 3.578 8 7.998 0 13.982-31.708 26.95-41.416 30.59-12.592 4.718-14.608 7.89-14.608 15.624v18.42h175.978v-18.42c0-7.748-2.016-10.904-14.608-15.608-6.92-2.592-41.37-16.248-41.37-30.606a7.994 7.994 0 0 1 8-7.998 8.006 8.006 0 0 1 7.85 6.468c2.868 3.562 17.482 12.03 31.128 17.154 12.084 4.516 24.998 10.968 24.998 30.59v26.418a8 8 0 0 1-8.002 7.998z" fill=""></path><path d="M112.068 144.046c-27.34 0-63.976-37.916-63.976-76.678C48.092 28.998 75.596 0.066 112.068 0.066c37.082 0 63.992 28.308 63.992 67.302 0 38.762-36.644 76.678-63.992 76.678z m0-127.982c-27.8 0-47.978 21.574-47.978 51.304 0 32.59 32.182 60.68 47.978 60.68 15.802 0 47.994-28.09 47.994-60.68 0-29.73-20.186-51.304-47.994-51.304z" fill=""></path><path d="M152.064 135.408c-4.422 0-8-3.578-8-8v-17.138c0-4.42 3.578-8 8-8a7.994 7.994 0 0 1 7.998 8v17.138c0 4.422-3.578 8-7.998 8zM72.088 135.408c-4.422 0-8-3.578-8-8v-17.138c0-4.42 3.578-8 8-8s8 3.578 8 8v17.138c0 4.422-3.578 8-8 8z" fill=""></path><path d="M320.042 735.892c-4.42 0-8-3.578-8-7.998v-53.306c0-31.184 16.568-43.478 45.198-54.182 14.99-5.592 37.042-14.042 55.344-22.778a7.99 7.99 0 0 1 10.664 3.766c1.906 4 0.218 8.764-3.774 10.67-18.874 9.014-41.362 17.638-56.64 23.342-27.318 10.202-34.792 18.622-34.792 39.182v53.306a7.998 7.998 0 0 1-8 7.998zM703.976 735.892c-4.422 0-8-3.578-8-7.998v-53.306c0-20.56-7.484-28.98-34.792-39.182-15.214-5.688-37.652-14.296-56.68-23.404a8.004 8.004 0 0 1-3.766-10.67c1.906-4.016 6.704-5.656 10.672-3.766 18.45 8.844 40.43 17.28 55.368 22.84 28.622 10.704 45.196 22.998 45.196 54.182v53.306a7.994 7.994 0 0 1-7.998 7.998zM511.642 607.91c-45.206 0-119.984-71.946-119.984-153.918 0-4.42 3.578-8 7.998-8 4.422 0 8 3.578 8 8 0 71.116 64.874 137.918 103.986 137.918 39.104 0 103.972-66.802 103.972-137.918 0-4.42 3.578-8 7.996-8 4.422 0 8 3.578 8 8 0 81.972-74.77 153.918-119.968 153.918zM623.14 445.742a8 8 0 0 1-6.652-3.562l-28.45-42.666c-12.734 4.61-43.262 14.232-76.398 14.232-33.27 0-64.468-9.686-77.358-14.28l-28.472 42.714a7.96 7.96 0 0 1-8.618 3.312 7.992 7.992 0 0 1-6.006-6.998c-4.188-44.824 5.46-80.474 28.676-105.97 33.442-36.714 87.684-44.416 127.304-44.416 26.372 0 45.446 3.39 46.242 3.532 3.5 0.624 6.156 3.5 6.532 7.03s-1.624 6.89-4.906 8.248c-7.152 2.938-11.84 7.14-13.964 12.5-2.078 5.234-1.516 10.828-0.64 14.67 8.156 0.328 24.59 2.952 37.106 17.56 15.214 17.794 19.762 47.166 13.512 87.332a8.016 8.016 0 0 1-6.188 6.578 8.346 8.346 0 0 1-1.72 0.184z m-31.996-63.992c2.61 0 5.14 1.28 6.656 3.562l19.734 29.606c1.234-23.964-2.89-42.026-12.156-52.868-8.954-10.436-20.684-12-26.886-12-1.562 0-2.562 0.11-2.766 0.124-3.484 0.422-6.906-1.422-8.36-4.608-0.296-0.656-7.344-16.452-1.172-32.042a34 34 0 0 1 4.812-8.452c-34.028-2.764-102.532-2.17-139.318 38.23-15.788 17.326-24.27 40.556-25.34 69.224l18.146-27.214a7.96 7.96 0 0 1 9.694-2.968c0.376 0.156 38.05 15.404 77.452 15.404 39.464 0 76.038-15.216 76.398-15.374a8.086 8.086 0 0 1 3.106-0.624z" fill=""></path><path d="M623.61 461.99a7.994 7.994 0 0 1-7.996-8v-16.248c0-4.422 3.578-8 7.996-8 4.422 0 8 3.578 8 8v16.248c0 4.422-3.578 8-8 8zM399.656 461.99a7.994 7.994 0 0 1-7.998-8v-16.248c0-4.422 3.578-8 7.998-8 4.422 0 8 3.578 8 8v16.248c0 4.422-3.578 8-8 8zM480.27 639.904a8.026 8.026 0 0 1-5.656-2.342l-47.994-47.996a8 8 0 0 1 11.312-11.31l43.932 43.932 27.066-13.452c3.938-1.936 8.756-0.344 10.718 3.61a8.002 8.002 0 0 1-3.61 10.732l-32.214 15.998a7.93 7.93 0 0 1-3.554 0.828z" fill=""></path><path d="M544.246 639.904a8.038 8.038 0 0 1-3.562-0.828l-32.222-15.998a8.004 8.004 0 0 1-3.61-10.732c1.96-3.954 6.774-5.544 10.718-3.61l27.082 13.452 43.934-43.932a7.996 7.996 0 1 1 11.308 11.31l-47.992 47.996a8 8 0 0 1-5.656 2.342zM512.86 655.902a7.976 7.976 0 0 1-5.656-2.344l-15.998-15.996a8 8 0 1 1 11.312-11.312l15.998 15.998a7.996 7.996 0 0 1-5.656 13.654z" fill=""></path><path d="M512.86 655.902a7.996 7.996 0 0 1-5.656-13.654l16-15.998a8 8 0 0 1 11.308 11.312l-15.996 15.996a7.968 7.968 0 0 1-5.656 2.344z" fill=""></path><path d="M496.87 719.894a8.004 8.004 0 0 1-7.96-8.89l8-71.99c0.492-4.374 4.57-7.42 8.834-7.06a8.004 8.004 0 0 1 7.07 8.842l-8 71.99a8.006 8.006 0 0 1-7.944 7.108z" fill=""></path><path d="M528.844 719.894a8.006 8.006 0 0 1-7.938-7.11l-8-71.99a8 8 0 0 1 7.07-8.842c4.516-0.376 8.352 2.688 8.836 7.06l7.996 71.99a8.01 8.01 0 0 1-7.964 8.892z" fill=""></path><path d="M703.976 735.892H320.042c-4.42 0-8-3.578-8-7.998 0-4.422 3.578-8 8-8h383.936a7.992 7.992 0 0 1 7.996 8 7.994 7.994 0 0 1-7.998 7.998z" fill=""></path><path d="M207.9 847.958a8.008 8.008 0 0 1-5.648-2.328 8.018 8.018 0 0 1-0.016-11.328l79.772-79.988a8.024 8.024 0 0 1 11.31-0.016 8.016 8.016 0 0 1 0.016 11.326l-79.77 79.99a7.984 7.984 0 0 1-5.664 2.344z" fill=""></path><path d="M224.038 847.958h-16.138c-4.422 0-8-3.578-8-8s3.578-8 8-8h16.138c4.42 0 7.998 3.578 7.998 8s-3.578 8-7.998 8z" fill=""></path><path d="M208.04 847.738c-4.422 0-8-3.578-8-8v-15.78c0-4.422 3.578-7.998 8-7.998s8 3.576 8 7.998v15.78c0 4.422-3.578 8-8 8z" fill=""></path><path d="M815.96 847.958a8.012 8.012 0 0 1-5.672-2.344l-79.77-79.99a8.026 8.026 0 0 1 0.016-11.326c3.124-3.094 8.204-3.11 11.324 0.016l79.774 79.988a8.028 8.028 0 0 1-0.016 11.328 8.024 8.024 0 0 1-5.656 2.328z" fill=""></path><path d="M815.96 847.958h-16.122c-4.422 0-8-3.578-8-8s3.578-8 8-8h16.122c4.422 0 8 3.578 8 8s-3.578 8-8 8z" fill=""></path><path d="M815.836 847.738c-4.422 0-8-3.578-8-8v-15.78c0-4.422 3.578-7.998 8-7.998s8 3.576 8 7.998v15.78c0 4.422-3.578 8-8 8z" fill=""></path><path d="M287.67 336.022a7.98 7.98 0 0 1-5.664-2.344l-79.772-79.99a8.016 8.016 0 0 1 0.016-11.326 8.024 8.024 0 0 1 11.312 0.016l79.77 79.988a8.014 8.014 0 0 1-0.016 11.328 7.992 7.992 0 0 1-5.646 2.328z" fill=""></path><path d="M224.038 256.034h-16.138c-4.422 0-8-3.578-8-8a7.994 7.994 0 0 1 8-7.998h16.138a7.994 7.994 0 0 1 7.998 7.998c0 4.422-3.578 8-7.998 8z" fill=""></path><path d="M208.04 272.032c-4.422 0-8-3.578-8-8v-15.78c0-4.42 3.578-7.998 8-7.998s8 3.578 8 7.998v15.78c0 4.422-3.578 8-8 8z" fill=""></path><path d="M736.192 336.022a8.028 8.028 0 0 1-5.656-2.328 8.032 8.032 0 0 1-0.016-11.328l79.77-79.988c3.124-3.124 8.204-3.11 11.328-0.016a8.03 8.03 0 0 1 0.016 11.326l-79.774 79.99a8 8 0 0 1-5.668 2.344z" fill=""></path><path d="M815.96 256.034h-16.122c-4.422 0-8-3.578-8-8a7.994 7.994 0 0 1 8-7.998h16.122c4.422 0 8 3.578 8 7.998 0 4.422-3.578 8-8 8z" fill=""></path><path d="M815.836 272.032c-4.422 0-8-3.578-8-8v-15.78c0-4.42 3.578-7.998 8-7.998s8 3.578 8 7.998v15.78c0 4.422-3.578 8-8 8z" fill=""></path><path d="M672.95 96.13a7.974 7.974 0 0 1-5.656-2.342l-11.406-11.39a8 8 0 0 1 11.312-11.31l11.406 11.388a8.002 8.002 0 0 1-5.656 13.654z" fill=""></path><path d="M661.542 107.364a8 8 0 0 1-5.656-13.654l11.156-11.156a8 8 0 1 1 11.312 11.312l-11.156 11.156a7.97 7.97 0 0 1-5.656 2.342zM363.41 107.692a7.978 7.978 0 0 1-5.656-2.342l-11.388-11.39a8 8 0 0 1 11.31-11.312l11.388 11.39a8 8 0 0 1-5.654 13.654z" fill=""></path><path d="M352.254 96.224a8 8 0 0 1-5.654-13.654l11.154-11.154a7.996 7.996 0 1 1 11.31 11.31l-11.154 11.156a7.97 7.97 0 0 1-5.656 2.342z" fill=""></path><path d="M672.95 96.302H352.02a7.994 7.994 0 0 1-7.998-7.998c0-4.422 3.578-8 7.998-8h320.928a7.992 7.992 0 0 1 7.996 8 7.988 7.988 0 0 1-7.994 7.998z" fill=""></path><path d="M672.95 943.88a7.976 7.976 0 0 1-5.656-2.344l-11.406-11.404a8 8 0 0 1 11.312-11.31l11.406 11.404a8 8 0 0 1-5.656 13.654z" fill=""></path><path d="M661.542 955.098a7.996 7.996 0 0 1-5.656-13.654l11.156-11.154a8 8 0 0 1 11.312 11.31l-11.156 11.154a7.974 7.974 0 0 1-5.656 2.344zM363.41 955.442a8 8 0 0 1-5.664-2.344l-11.388-11.404a8.006 8.006 0 0 1 11.326-11.31l11.388 11.404a8 8 0 0 1-5.662 13.654z" fill=""></path><path d="M352.254 943.974a7.996 7.996 0 0 1-5.654-13.654l11.154-11.154a7.996 7.996 0 1 1 11.31 11.31l-11.154 11.154a7.964 7.964 0 0 1-5.656 2.344z" fill=""></path><path d="M672.95 944.038H352.02a7.994 7.994 0 0 1-7.998-7.998c0-4.422 3.578-8 7.998-8h320.928a7.992 7.992 0 0 1 7.996 8 7.99 7.99 0 0 1-7.994 7.998z" fill=""></path><path d="M912.012 672.462a7.996 7.996 0 0 1-5.656-13.654l11.406-11.388a7.996 7.996 0 1 1 11.308 11.31l-11.402 11.388a7.968 7.968 0 0 1-5.656 2.344z" fill=""></path><path d="M911.95 672.228a7.976 7.976 0 0 1-5.656-2.344l-11.156-11.154a8 8 0 0 1 11.312-11.31l11.156 11.154a8 8 0 0 1-5.656 13.654zM900.45 378.922a8 8 0 0 1-5.656-13.654l11.406-11.39a8 8 0 1 1 11.312 11.312l-11.406 11.39a7.978 7.978 0 0 1-5.656 2.342z" fill=""></path><path d="M923.07 378.922a7.966 7.966 0 0 1-5.652-2.342l-11.156-11.156a8 8 0 1 1 11.312-11.312l11.152 11.156a8 8 0 0 1-5.656 13.654z" fill=""></path><path d="M911.856 672.462c-4.422 0-8-3.578-8-7.998V359.536c0-4.422 3.578-8 8-8s8 3.578 8 8v304.93a7.994 7.994 0 0 1-8 7.996z" fill=""></path><path d="M112.13 672.462a8 8 0 0 1-5.654-13.654l11.404-11.388a8.006 8.006 0 0 1 11.318 0 8 8 0 0 1-0.008 11.31l-11.404 11.388a7.968 7.968 0 0 1-5.656 2.344z" fill=""></path><path d="M112.068 672.228a7.972 7.972 0 0 1-5.654-2.344l-11.156-11.154a8 8 0 0 1 11.312-11.31l11.154 11.154a7.996 7.996 0 0 1-5.656 13.654zM100.57 378.922a7.992 7.992 0 0 1-5.656-13.654l11.406-11.39a8.006 8.006 0 0 1 11.318 0 8.002 8.002 0 0 1-0.008 11.312l-11.404 11.39a7.974 7.974 0 0 1-5.656 2.342z" fill=""></path><path d="M123.192 378.922a7.978 7.978 0 0 1-5.656-2.342l-11.154-11.156a8 8 0 0 1 11.31-11.312l11.154 11.156a8 8 0 0 1-5.654 13.654z" fill=""></path><path d="M111.974 672.462a7.994 7.994 0 0 1-7.998-7.998V359.536c0-4.422 3.578-8 7.998-8 4.422 0 8 3.578 8 8v304.93a7.994 7.994 0 0 1-8 7.996z" fill=""></path></g></svg>
                                                <div class="ms-2">
                                                    <p class="text-primary text-sm mb-0">{{__('Total Staff')}}</p>
                                                    <h4 class="mb-0 text-success">{{ $countUser +   $countClient}}</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 my-3 my-sm-0">
                                            <div class="d-flex align-items-start mb-3">
                                                <svg fill="#0ec4cb" width="64px" height="64px" viewBox="-3.6 -3.6 43.20 43.20" xmlns="http://www.w3.org/2000/svg" stroke="#0ec4cb" stroke-width="0.00036"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>employee_group_line</title> <g id="e1709d41-49e9-409f-9912-e2615f9236f6" data-name="Layer 3"> <path d="M18.42,16.31a5.7,5.7,0,1,1,5.76-5.7A5.74,5.74,0,0,1,18.42,16.31Zm0-9.4a3.7,3.7,0,1,0,3.76,3.7A3.74,3.74,0,0,0,18.42,6.91Z"></path> <path d="M18.42,16.31a5.7,5.7,0,1,1,5.76-5.7A5.74,5.74,0,0,1,18.42,16.31Zm0-9.4a3.7,3.7,0,1,0,3.76,3.7A3.74,3.74,0,0,0,18.42,6.91Z"></path> <path d="M21.91,17.65a20.6,20.6,0,0,0-13,2A1.77,1.77,0,0,0,8,21.25v3.56a1,1,0,0,0,2,0V21.38a18.92,18.92,0,0,1,12-1.68Z"></path> <path d="M33,22H26.3V20.52a1,1,0,0,0-2,0V22H17a1,1,0,0,0-1,1V33a1,1,0,0,0,1,1H33a1,1,0,0,0,1-1V23A1,1,0,0,0,33,22ZM32,32H18V24h6.3v.41a1,1,0,0,0,2,0V24H32Z"></path> <rect x="21.81" y="27.42" width="5.96" height="1.4"></rect> <path d="M10.84,12.24a18,18,0,0,0-7.95,2A1.67,1.67,0,0,0,2,15.71v3.1a1,1,0,0,0,2,0v-2.9a16,16,0,0,1,7.58-1.67A7.28,7.28,0,0,1,10.84,12.24Z"></path> <path d="M33.11,14.23a17.8,17.8,0,0,0-7.12-2,7.46,7.46,0,0,1-.73,2A15.89,15.89,0,0,1,32,15.91v2.9a1,1,0,1,0,2,0v-3.1A1.67,1.67,0,0,0,33.11,14.23Z"></path> <path d="M10.66,10.61c0-.23,0-.45,0-.67a3.07,3.07,0,0,1,.54-6.11,3.15,3.15,0,0,1,2.2.89,8.16,8.16,0,0,1,1.7-1.08,5.13,5.13,0,0,0-9,3.27,5.1,5.1,0,0,0,4.7,5A7.42,7.42,0,0,1,10.66,10.61Z"></path> <path d="M24.77,1.83a5.17,5.17,0,0,0-3.69,1.55,7.87,7.87,0,0,1,1.9,1,3.14,3.14,0,0,1,4.93,2.52,3.09,3.09,0,0,1-1.79,2.77,7.14,7.14,0,0,1,.06.93,7.88,7.88,0,0,1-.1,1.2,5.1,5.1,0,0,0,3.83-4.9A5.12,5.12,0,0,0,24.77,1.83Z"></path> </g> </g></svg>
                                               
                                                <div class="ms-2">
                                                    <p class="text-primary text-sm mb-0">{{__('Total Employee')}}</p>
                                                    <h4 class="mb-0 text-primary">{{$countUser}}</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <div class="d-flex align-items-start mb-3">
                                                <svg fill="#0ec4cb" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="-76.37 -76.37 630.04 630.04" xml:space="preserve" width="64px" height="64px" stroke="#0ec4cb"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <g> <path d="M42.85,358.075c0-24.138,0-306.758,0-330.917c23.9,0,278.867,0,302.767,0c0,8.542,0,49.44,0,99.722 c5.846-1.079,11.842-1.812,17.99-1.812c3.149,0,6.126,0.647,9.232,0.928V0H15.649v385.233h224.638v-27.158 C158.534,358.075,57.475,358.075,42.85,358.075z"></path> <path d="M81.527,206.842h184.495c1.812-10.16,5.393-19.608,10.095-28.452H81.527V206.842z"></path> <rect x="81.527" y="89.432" width="225.372" height="28.452"></rect> <path d="M81.527,295.822h191.268c5.112-3.106,10.57-5.63,16.415-7.183c-5.544-6.45-10.095-13.697-13.978-21.269H81.527V295.822z"></path> <path d="M363.629,298.669c41.071,0,74.16-33.197,74.16-74.139c0-40.984-33.09-74.16-74.16-74.16 c-40.898,0-74.009,33.176-74.009,74.16C289.62,265.472,322.731,298.669,363.629,298.669z"></path> <path d="M423.143,310.706H304.288c-21.226,0-38.612,19.457-38.612,43.422v119.33c0,1.316,0.604,2.481,0.69,3.84h194.59 c0.086-1.337,0.69-2.524,0.69-3.84v-119.33C461.733,330.227,444.39,310.706,423.143,310.706z"></path> </g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> </g> </g></svg>
                                                <div class="ms-2">
                                                    <p class="text-primary text-sm mb-0">{{__('Total Client')}}</p>
                                                    <h4 class="mb-0 text-danger">{{$countClient}}</h4>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-12">
                            <div class="card hover-border-primary">
                                <div class="card-body">
                                    <h5>{{__('Job')}}</h5>
                                    <div class="row  mt-4">
                                        <div class="col-md-6 col-sm-6">
                                            <div class="d-flex align-items-start mb-3">
                                              <svg width="64px" height="64px" viewBox="-6.6 -6.6 73.20 73.20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#0ec4cb" stroke="#0ec4cb"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>job-desktop</title> <desc>Created with Sketch.</desc> <defs> </defs> <g id="People" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="Icon-11" fill="#0ec4cb"> <path d="M28,27 L28,30 L32,30 L32,27 L32,22 L28,22 L28,27 Z M8,27 C8,26.448 8.448,26 9,26 L26,26 L26,22 C26,20.897 26.897,20 28,20 L32,20 C33.103,20 34,20.897 34,22 L34,26 L51,26 C51.552,26 52,26.448 52,27 C52,27.552 51.552,28 51,28 L34,28 L34,30 C34,31.103 33.103,32 32,32 L28,32 C26.897,32 26,31.103 26,30 L26,28 L9,28 C8.448,28 8,27.552 8,27 L8,27 Z M30.03,29 C30.583,29 31.03,28.552 31.03,28 C31.03,27.448 30.583,27 30.03,27 L30.02,27 C29.468,27 29.025,27.448 29.025,28 C29.025,28.552 29.478,29 30.03,29 L30.03,29 Z M7,10 C6.449,10 6,10.449 6,11 L6,40 L54,40 L54,11 C54,10.449 53.551,10 53,10 L7,10 Z M26,8 L34,8 L34,6 L26,6 L26,8 Z M22,8 L24,8 L24,5 C24,4.448 24.448,4 25,4 L35,4 C35.552,4 36,4.448 36,5 L36,8 L38,8 L38,3 C38,2.449 37.551,2 37,2 L23,2 C22.449,2 22,2.449 22,3 L22,8 Z M7,8 L20,8 L20,3 C20,1.346 21.346,0 23,0 L37,0 C38.654,0 40,1.346 40,3 L40,8 L53,8 C54.654,8 56,9.346 56,11 L56,41 C56,41.552 55.552,42 55,42 L5,42 C4.448,42 4,41.552 4,41 L4,11 C4,9.346 5.346,8 7,8 L7,8 Z M39,54 L36,54 L36,53 C36,52.448 35.552,52 35,52 C34.448,52 34,52.448 34,53 L34,55 C34,55.552 34.448,56 35,56 L39,56 C40.123,56 41.295,56.914 41.775,58 L18.225,58 C18.705,56.914 19.877,56 21,56 L31,56 C31.552,56 32,55.552 32,55 C32,54.448 31.552,54 31,54 L26,54 L26,53 C26,52.448 25.552,52 25,52 C24.448,52 24,52.448 24,53 L24,54 L21,54 C18.43,54 16,56.43 16,59 C16,59.552 16.448,60 17,60 L43,60 C43.552,60 44,59.552 44,59 C44,56.43 41.57,54 39,54 L39,54 Z M30.02,44 C29.468,44 29.025,44.448 29.025,45 C29.025,45.552 29.478,46 30.03,46 C30.583,46 31.03,45.552 31.03,45 C31.03,44.448 30.583,44 30.03,44 L30.02,44 Z M60,9 L60,45 C60,47.804 57.804,50 55,50 L5,50 C1.898,50 0,45.468 0,43 L0,9 C0.191,6.167 2.386,4 5,4 L17,4 C17.552,4 18,4.448 18,5 C18,5.552 17.552,6 17,6 L5,6 C3.252,6 2.101,7.56 1.998,9.068 L2,43 C2,45.02 3.58,48 5,48 L55,48 C56.71,48 58,46.71 58,45 L58,9 C58,7.346 56.654,6 55,6 L43,6 C42.448,6 42,5.552 42,5 C42,4.448 42.448,4 43,4 L55,4 C57.757,4 60,6.243 60,9 L60,9 Z" id="job-desktop"> </path> </g> </g> </g></svg>
                                                <div class="ms-2">
                                                    <p class="text-primary text-sm mb-0">{{__('Total Jobs')}}</p>
                                                    <h4 class="mb-0 text-success">{{$activeJob + $inActiveJOb}}</h4>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 my-3 my-sm-0">
                                            <div class="d-flex align-items-start mb-3">
                                                <svg width="64px" height="64px" viewBox="-5.28 -5.28 58.56 58.56" id="b" xmlns="http://www.w3.org/2000/svg" fill="#0ec4cb" stroke="#0ec4cb"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <defs> <style>.c{fill:none;stroke:#0ec4cb;stroke-linecap:round;stroke-linejoin:round;}</style> </defs> <circle class="c" cx="24" cy="24" r="18.5946"></circle> <g> <path class="c" d="m24,5.4054v-2.9054"></path> <path class="c" d="m24,45.5v-2.9054"></path> <path class="c" d="m42.5946,24h2.9054"></path> <path class="c" d="m2.5,24h2.9054"></path> <path class="c" d="m42.5946,24l-9.2973-9.2973-16.4516,16.4516"></path> <path class="c" d="m24.3486,16.8469L7.8971,33.2985"></path> </g> </g></svg>
                                                <div class="ms-2">
                                                    <p class="text-primary text-sm mb-0">{{__('Active Jobs')}}</p>
                                                    <h4 class="mb-0 text-primary">{{$activeJob}}</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <div class="d-flex align-items-start mb-3">
                                                <svg width="64px" height="64px" viewBox="-2.4 -2.4 28.80 28.80" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#0ec4cb"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M19 21L16 18M16 18L19 15M16 18H22M15.5 3.29076C16.9659 3.88415 18 5.32131 18 7C18 8.67869 16.9659 10.1159 15.5 10.7092M12 15H8C6.13623 15 5.20435 15 4.46927 15.3045C3.48915 15.7105 2.71046 16.4892 2.30448 17.4693C2 18.2044 2 19.1362 2 21M13.5 7C13.5 9.20914 11.7091 11 9.5 11C7.29086 11 5.5 9.20914 5.5 7C5.5 4.79086 7.29086 3 9.5 3C11.7091 3 13.5 4.79086 13.5 7Z" stroke="#0ec4cb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                                <div class="ms-2">
                                                    <p class="text-primary text-sm mb-0">{{__('Inactive Jobs')}}</p>
                                                    <h4 class="mb-0 text-danger">{{$inActiveJOb}}</h4>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-12">
                            <div class="card hover-border-primary">
                                <div class="card-body">
                                    <h5>{{__('Training')}}</h5>
                                    <div class="row  mt-4">
                                        <div class="col-md-6 col-sm-6">
                                            <div class="d-flex align-items-start mb-3">
                                               <svg fill="#0ec4cb" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="-49.6 -49.6 595.20 595.20" xml:space="preserve" width="64px" height="64px" stroke="#0ec4cb"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <g> <path d="M432,336h-10.84c16.344-13.208,26.84-33.392,26.84-56v-32c0-30.872-25.128-56-56-56h-32c-2.72,0-5.376,0.264-8,0.64V48 h16V0H0v48h16v232H0v48h187.056l40,80H304v88h192v-96C496,364.712,467.288,336,432,336z M422.584,371.328l-32.472,13.92 L412.28,352h5.472L422.584,371.328z M358.944,352h34.112L376,377.576L358.944,352z M361.872,385.248l-32.472-13.92L334.24,352 h5.472L361.872,385.248z M432.008,280C432,310.872,406.872,336,376,336s-56-25.128-56-56h37.424 c14.12,0,27.392-5.504,37.368-15.48l4.128-4.128c8.304,10.272,20.112,16.936,33.088,18.92V280z M48,192v72h107.176 c0.128,0.28,0.176,0.584,0.312,0.856L163.056,280H32V48h304v149.48c-18.888,9.008-32,28.24-32,50.52v32h-65.064l-24.816-46.528 C208.368,222.696,197.208,216,185,216c-10.04,0-18.944,4.608-25,11.712V192H48z M144,208v40H64v-40H144z M360,208h32 c22.056,0,40,17.944,40,40v15.072c-9.168-2.032-17.32-7.48-22.656-15.48l-8.104-12.152l-17.768,17.768 c-6.96,6.96-16.208,10.792-26.048,10.792H320v-16C320,225.944,337.944,208,360,208z M16,16h336v16H16V16z M16,312v-16h155.056 l8,16H16z M256,392h-19.056L169.8,257.712c-1.176-2.36-1.8-4.992-1.8-7.608V249c0-9.376,7.624-17,17-17c6.288,0,12.04,3.456,15,9 l56,104.992V392z M247.464,296h58.392c1.28,5.616,3.232,10.968,5.744,16H256L247.464,296z M264.536,328h57.952 c2.584,2.872,5.352,5.568,8.36,8H268.8L264.536,328z M480,480h-32v-32h32V480z M480,432h-32v-32h-16v80H320v-88h-48v-40h45.76 l-7.168,28.672L376,408.704l65.416-28.032l-7.144-28.56C459.68,353.312,480,374.296,480,400V432z"></path> <path d="M160,128v-16h-16.808c-1.04-5.096-3.072-9.832-5.856-14.024l11.92-11.92l-11.312-11.312l-11.92,11.92 c-4.192-2.784-8.928-4.816-14.024-5.856V64H96v16.808c-5.096,1.04-9.832,3.072-14.024,5.856l-11.92-11.92L58.744,86.056 l11.92,11.92c-2.784,4.192-4.816,8.928-5.856,14.024H48v16h16.808c1.04,5.096,3.072,9.832,5.856,14.024l-11.92,11.92 l11.312,11.312l11.92-11.92c4.192,2.784,8.928,4.816,14.024,5.856V176h16v-16.808c5.096-1.04,9.832-3.072,14.024-5.856 l11.92,11.92l11.312-11.312l-11.92-11.92c2.784-4.192,4.816-8.928,5.856-14.024H160z M104,144c-13.232,0-24-10.768-24-24 s10.768-24,24-24s24,10.768,24,24S117.232,144,104,144z"></path> <polygon points="244.28,80 272,80 272,64 235.72,64 203.72,112 176,112 176,128 212.28,128 "></polygon> <rect x="288" y="64" width="32" height="16"></rect> <path d="M224,144h-48v48h48V144z M208,176h-16v-16h16V176z"></path> <rect x="240" y="160" width="32" height="16"></rect> <rect x="288" y="160" width="32" height="16"></rect> </g> </g> </g> </g></svg>
                                                <div class="ms-2">
                                                    <p class="text-primary text-sm mb-0">{{__('Total Training')}}</p>
                                                    <h4 class="mb-0 text-success">{{ $onGoingTraining +   $doneTraining}}</h4>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 my-3 my-sm-0">
                                            <div class="d-flex align-items-start mb-3">
                                                <svg width="64px" height="64px" viewBox="-2.4 -2.4 28.80 28.80" id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><defs><style>.cls-1{fill:none;stroke:#0ec4cb;stroke-miterlimit:10;stroke-width:1.91px;}</style></defs><path class="cls-1" d="M10.09,1.5h3.83a2.87,2.87,0,0,1,2.87,2.87V9.15A4.78,4.78,0,0,1,12,13.93h0A4.78,4.78,0,0,1,7.22,9.15V4.37A2.87,2.87,0,0,1,10.09,1.5Z"></path><path class="cls-1" d="M7.22,5.33h9.57a0,0,0,0,1,0,0v0A2.87,2.87,0,0,1,13.91,8.2H10.09A2.87,2.87,0,0,1,7.22,5.33v0A0,0,0,0,1,7.22,5.33Z"></path><path class="cls-1" d="M3.39,23.5v-1A8.62,8.62,0,0,1,12,13.93h0a8.62,8.62,0,0,1,8.61,8.61v1"></path><circle class="cls-1" cx="12" cy="20.63" r="0.96"></circle><line class="cls-1" x1="12.96" y1="23.5" x2="12.96" y2="20.63"></line><polyline class="cls-1" points="7.22 13.94 12 19.67 16.78 13.94"></polyline></g></svg>
                                                <div class="ms-2">
                                                    <p class="text-primary text-sm mb-0">{{__('Trainer')}}</p>
                                                    <h4 class="mb-0 text-primary">{{$countTrainer}}</h4>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <div class="d-flex align-items-start mb-3">
                                                <svg version="1.1" id="Icons" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="-3.52 -3.52 39.04 39.04" xml:space="preserve" width="64px" height="64px" fill="#0ec4cb" stroke="#0ec4cb"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <style type="text/css"> .st0{fill:none;stroke:#0ec4cb;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;} </style> <g> <path d="M23,11c2.2,0,4-1.8,4-4s-1.8-4-4-4s-4,1.8-4,4S20.8,11,23,11z"></path> <path d="M30.8,12.4c-0.3-0.4-1-0.5-1.4-0.2l-2.9,2.3c-0.8,0.7-2,0.6-2.7-0.2l-7.9-7.9c-1.6-1.6-4.1-1.6-5.7,0L7.3,9.3 c-0.4,0.4-0.4,1,0,1.4s1,0.4,1.4,0l2.8-2.8c0.8-0.8,2.1-0.8,2.9,0l1.6,1.6L11.6,14c-1,1-1.4,2.3-1.1,3.7c0.2,1.1,0.9,2,1.8,2.6 l-1.6,1.6c-0.4,0.4-1,0.4-1.4,0l-3.6-3.6c-0.4-0.4-1-0.4-1.4,0s-0.4,1,0,1.4l3.6,3.6c0.6,0.6,1.3,0.9,2.1,0.9s1.6-0.3,2.1-0.9 l2.1-2.1l2.5,1c0.7,0.3,1.2,1,1.2,1.8v6c0,0.6,0.4,1,1,1s1-0.4,1-1v-6c0-1.6-1-3.1-2.5-3.7l-1.7-0.7l5.2-5.2l1.4,1.4 c0.8,0.8,1.8,1.2,2.9,1.2c0.9,0,1.8-0.3,2.5-0.9l2.9-2.3C31.1,13.4,31.1,12.8,30.8,12.4z"></path> </g> </g></svg>
                                                <div class="ms-2">
                                                    <p class="text-primary text-sm mb-0">{{__('Active Training')}}</p>
                                                    <h4 class="mb-0 text-danger">{{$onGoingTraining}}</h4>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <div class="d-flex align-items-start mb-3">
                                                <svg width="64px" height="64px" viewBox="-1.68 -1.68 24.36 24.36" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>done [#0ec4cbec4cb]</title> <desc>Created with Sketch.</desc> <defs> </defs> <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="Dribbble-Light-Preview" transform="translate(-219.000000, -400.000000)" fill="#0ec4cb"> <g id="icons" transform="translate(56.000000, 160.000000)"> <path d="M181.9,258 L165.1,258 L165.1,242 L173.5,242 L173.5,240 L163,240 L163,260 L184,260 L184,250 L181.9,250 L181.9,258 Z M170.58205,245.121 L173.86015,248.243 L182.5153,240 L184,241.414 L173.86015,251.071 L173.86015,251.071 L173.8591,251.071 L169.09735,246.536 L170.58205,245.121 Z" id="done-[#0ec4cbec4cb]"> </path> </g> </g> </g> </g></svg>
                                                <div class="ms-2">
                                                    <p class="text-primary text-sm mb-0">{{__('Done Training')}}</p>
                                                    <h4 class="mb-0 text-secondary">{{$doneTraining}}</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card hover-border-primary">
                            <div class="card-header">

                                <h5>{{__('Announcement List')}}</h5>
                            </div>
                            <div class="card-body" style="min-height: 295px;">
                                <div class="table-responsive">
                                    @if(count($announcements) > 0)
                                        <table class="table align-items-center">
                                            <thead>
                                            <tr>
                                                <th>{{__('Title')}}</th>
                                                <th>{{__('Start Date')}}</th>
                                                <th>{{__('End Date')}}</th>

                                            </tr>
                                            </thead>
                                            <tbody class="list">
                                            @foreach($announcements as $announcement)
                                                <tr>
                                                    <td>{{ $announcement->title }}</td>
                                                    <td>{{ \Auth::user()->dateFormat($announcement->start_date) }}</td>
                                                    <td>{{ \Auth::user()->dateFormat($announcement->end_date) }}</td>

                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        <div class="p-2 text-primary">
                                            {{__('No accouncement present yet.')}}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card hover-border-primary">
                            <div class="card-header">
                                <h5>{{__('Meeting schedule')}}</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    @if(count($meetings) > 0)
                                        <table class="table align-items-center">
                                            <thead>
                                            <tr>
                                                <th>{{__('Title')}}</th>
                                                <th>{{__('Date')}}</th>
                                                <th>{{__('Time')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody class="list">
                                            @foreach($meetings as $meeting)
                                                <tr>
                                                    <td>{{ $meeting->title }}</td>
                                                    <td>{{ \Auth::user()->dateFormat($meeting->date) }}</td>
                                                    <td>{{  \Auth::user()->timeFormat($meeting->time) }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        <div class="p-2 text-primary">
                                            {{__('No meeting scheduled yet.')}}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    @endif
@endsection


