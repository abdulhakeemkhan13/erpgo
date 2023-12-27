
{{ Form::model($ismail, array('route' => array('ismail.update', $ismail->id), 'method' => 'PUT')) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group">
            {{ Form::label('name', __('Price'),['class'=>'form-label']) }}
            {{ Form::text('name', null, array('class' => 'form-control','placeholder'=>__('Enter Name'),'required'=>'required')) }}
        </div>

        <div class="form-group">
            {{ Form::label('date', __('Date'),['class'=>'form-label']) }}
            {{ Form::date('date', null, array('class' => 'form-control','placeholder'=>__('Enter Date'),'required'=>'required')) }}
        </div>
        
        {{--<div class="form-group">
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


