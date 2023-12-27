<div class="card bg-none card-box">
    {{ Form::open(array('url' => 'spacetype')) }}
    <div class="row">
        <div class="col-6 form-group">
            {{ Form::label('name', __('Name'),['class'=>'form-label']) }}
            {{ Form::text('name', null, array('class' => 'form-control','required'=>'required')) }}
        </div>

        <div class="form-group mt-4 mb-0">
            {{ Form::hidden('ajax',true) }}
            <input type="submit" value="{{__('Create')}}" class="btn-create badge-blue">
        </div>
    </div>
    {{ Form::close() }}
</div>
