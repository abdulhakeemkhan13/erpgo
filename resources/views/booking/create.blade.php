{{ Form::open(['route' => ['booking.store']]) }}
<div class="modal-body">
    {{-- start for ai module--}}
    @php
        $plan= \App\Models\Utility::getChatGPTSettings();
    @endphp

    <div class="row">
        <input type="hidden" class="form-control" value="{{$space_id}}" name="space_id">
        <div class="col-12 form-group">
            {{-- {{ Form::label('start_time', __('Start Time'), ['class' => 'form-label']) }}
            {{ Form::datetime('start_time', null, ['class' => 'form-control']) }}         --}}
            <label for="datetimeInput" class="form-label">{{ __('Start Time') }}</label>
            <input type="datetime-local" class="form-control" id="datetimeInput" name="start_time">
   
        </div>
        <div class="col-12 form-group">
            <label for="datetimeInputend" class="form-label">{{__('End Time')}}</label>
            <input type="datetime-local" class="form-control" id="datetimeInputend" name="end_time">
            {{-- {{ Form::label('end_time', __('End Time'), ['class' => 'form-label']) }}
            {{ Form::datetime('end_time', null, ['class' => 'form-control']) }} --}}
        </div>
        {{-- <div class="col-6 form-group">
            {{ Form::label('client_name', __('Client'), ['class' => 'form-label']) }}
            {{ Form::select('client_name', $clients, null, ['class' => 'form-control select client_select', 'id' => 'client_select']) }}
        </div>
        <div class="col-6 form-group">
            {{ Form::label('email', __('Email'),['class'=>'form-label']) }}
            {{ Form::text('email', null, array('class' => 'form-control','required'=>'required')) }}
        </div>
        <div class="col-6 form-group">
            {{ Form::label('phone', __('Phone'),['class'=>'form-label']) }}
            {{ Form::text('phone', null, array('class' => 'form-control','required'=>'required')) }}
        </div> --}}
    </div>
</div>

<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
</div>

{{Form::close()}}

