
{{ Form::model($isvisitor, array('route' => array('isvisitor.update', $isvisitor->id), 'method' => 'PUT')) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group">
            {{ Form::label('name', __('Name'),['class'=>'form-label']) }}
            {{ Form::text('name', null, array('class' => 'form-control','placeholder'=>__('Enter Spacetype Name'),'required'=>'required')) }}
        </div>
        <div class="form-group">
            {{ Form::label('cnic', __('CNIC'),['class'=>'form-label']) }}
            {{ Form::text('cnic', null, array('class' => 'form-control','placeholder'=>__('Enter Visitor CNIC'))) }}
        </div>
        <div class="form-group">
            <label for="datetimeInput" class="form-label">{{ __('Date Time') }}</label>
            <input type="datetime-local" class="form-control" id="datetimeInput" name="date" value="{{$isvisitor->date_time}}">
        </div>
        {{-- <div class="form-group">
            {{ Form::label('price', __('Price'),['class'=>'form-label']) }}
            {{ Form::number('price', null, array('class' => 'form-control','placeholder'=>__('Enter Price'),'required'=>'required')) }}
        </div>
        <div class="form-group">
            {{ Form::label('type', __('Type'), ['class' => 'form-label']) }}
            {{ Form::select('type', ['dedicated' =>'Dedicated','flexible' =>'Flexible'], null, ['class' => 'form-control', 'required' => 'required']) }}
        </div> --}}

        @if(!$customFields->isEmpty())
            @include('custom_fields.formBuilder')
        @endif

    </div>
</div>

<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Update')}}" class="btn  btn-primary">
</div>

{{Form::close()}}


