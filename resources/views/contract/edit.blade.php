{{-- {{ Form::model($contract, ['route' => ['contract.update', $contract->id], 'method' => 'PUT']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-12">
            {{ Form::label('subject', __('Subject'), ['class' => 'form-label']) }}
            {{ Form::text('subject', null, ['class' => 'form-control', 'required' => 'required']) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('client_name', __('Client'), ['class' => 'form-label']) }}
            {{ Form::select('client_name', $clients, null, ['class' => 'form-control select client_select', 'id' => 'client_select']) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('project', __('Project'), ['class' => 'form-label']) }}
            <div class="project-div">
                {{ Form::select('project', $project, null, ['class' => 'form-control  project_select', 'id' => 'project_id', 'name' => 'project_id']) }}
            </div>
        </div>

        <div class="form-group col-md-6">
            {{ Form::label('type', __('Contract Type'), ['class' => 'form-label']) }}
            {{ Form::select('type', $contractTypes, null, ['class' => 'form-control', 'data-toggle' => 'select', 'required' => 'required']) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('value', __('Contract Value'), ['class' => 'form-label']) }}
            {{ Form::number('value', null, ['class' => 'form-control', 'required' => 'required', 'stage' => '0.01']) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('start_date', __('Start Date'), ['class' => 'form-label']) }}
            {{ Form::date('start_date', null, ['class' => 'form-control', 'required' => 'required']) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('end_date', __('End Date'), ['class' => 'form-label']) }}
            {{ Form::date('end_date', null, ['class' => 'form-control', 'required' => 'required']) }}
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-12">
            {{ Form::label('description', __('Description'), ['class' => 'form-label']) }}
            {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => '3']) !!}
        </div>
    </div>
</div>
</div>
<div class="modal-footer">
    <input type="button" value="{{ __('Cancel') }}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Update') }}" class="btn  btn-primary">
</div>
{{ Form::close() }} --}}
{{ Form::model($contract, ['route' => ['contract.update', $contract->id], 'method' => 'PUT']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            {{ Form::label('subject', __('Subject'), ['class' => 'form-label']) }}
            {{ Form::text('subject', null, ['class' => 'form-control', 'required' => 'required']) }}
        </div>
      <input type="hidden" id="con_id" value="{{$contract->id}}">
        <div class="form-group col-md-6 row">
            <div class="col-md-9">
                {{ Form::label('company_id', __('Company'), ['class' => 'form-label']) }}
            </div>
            {{-- <div class="col-md-3 d-flex">
                {{ Form::label('addpropcheck', __('New'), ['class' => 'form-check-label']) }}
                {{ Form::checkbox('new', '1', false, ['class' => 'form-check-input', 'id' => 'addpropcheck']) }}
            </div> --}}
            {{-- {{ Form::text('newcompany', '', ['class' => 'form-control d-none companyText req' ]) }} --}}
            <select name="company_id" id="companySelect" class="form-control">
                @foreach ($company as $comp)
                    <option value="{{ $comp->id }}" disabled @if($comp->id == $contract->company_id) selected @endif >{{ $comp->name }} </option>
                @endforeach
            </select>
            {{-- {{ Form::select('company_id', $company, null, ['class' => 'form-control', 'placeholder' => __('Select Company'), 'id' => 'companySelect']) }} --}}
        </div>  

        {{-- <div class="form-group col-md-6 d-none companyText">
            {{ Form::label('phone_no', __('Phone No'), ['class' => 'form-label']) }}
            {{ Form::number('phone_no', '', ['class' => 'form-control req']) }}
        </div>
        <div class="form-group col-md-6 d-none companyText">
            {{ Form::label('ntn', __('NTN'), ['class' => 'form-label']) }}
            {{ Form::text('ntn', '', ['class' => 'form-control req']) }}
        </div>

        <div class="form-group col-md-12 d-none companyText">
            {{ Form::label('email', __('Email'), ['class' => 'form-label']) }}
            {{ Form::email('email', '', ['class' => 'form-control req','placeholder' =>'123@gmail.com']) }}
        </div> --}}
        
        <div class="form-group col-md-6">
            {{ Form::label('space', __('Space'), ['class' => 'form-label']) }}
            <select name="space" class="form-control select space_select" id="space" required
                onchange="getchairs(this.value)">
                <option value="" disabled selected>Select a Space</option>
                @foreach ($spaces as $space)
                    <option value="{{ $space->id }}" @if($space->id == @$roomassign[0]->space_id) selected @endif>{{ $space->name }} ( {{ @$space->type->name }} )</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-6" id="ch">
            {{ Form::label('chair', __('Chair'), ['class' => 'form-label']) }}
            <select name="chair[]" class="form-control select chair_select" id="chair" multiple="multiple">
                <option value="" disabled>Select Chairs</option>
                @foreach ($chairs as $chair)
                <option value="{{ $chair->id }}"  @if(in_array($chair->id, $chairused)) disabled @endif  @if(in_array($chair->id, $chairget)) selected @endif>{{ $chair->name }} </option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-md-6">
            {{ Form::label('type', __('Contract Type'), ['class' => 'form-label']) }}
            {{ Form::select('type', $contractTypes, null, ['class' => 'form-control', 'data-toggle="select"', 'required' => 'required']) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('value', __('Contract Value'), ['class' => 'form-label']) }}
            {{ Form::number('value', null, ['class' => 'form-control', 'required' => 'required', 'stage' => '0.01']) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('start_date', __('Start Date'), ['class' => 'form-label']) }}
            {{ Form::date('start_date', null, ['class' => 'form-control', 'required' => 'required']) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('end_date', __('End Date'), ['class' => 'form-label']) }}
            {{ Form::date('end_date', null  , ['class' => 'form-control', 'required' => 'required']) }}
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-12">
            {{ Form::label('description', __('Description'), ['class' => 'form-label']) }}
            {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => '3']) !!}
        </div>
    </div>
    <div class="row">
        {{ Form::label('meeting_hours', 'Meeting Room & Board Room Hours', ['class' => 'form-label']) }}
        @foreach ($ismeeting as $meeting)
        <?php
        $space_houre = App\Models\Contract::spaceContract($contract->id,$meeting->id);
        ?>
            <div class="d-flex col-md-12">
                <label class="form-label m-1"  style="width: 25%" for="{{ $meeting->id }}">{{ ucfirst($meeting->name) }} : </label>
                <input type="hidden" name="room_hours_ids[]" value="{{ $meeting->id }}"  class="form-label m-1"
                    style="width: 25%">
                <input type="number" name="room_hours[]" value="{{@$space_houre->assign_hour}}" id="{{ $meeting->id }}" class="form-label m-1"
                    style="width: 25%" required>
                <label class="form-label m-1" for="{{ $meeting->id }}"> Hrs</label>
                <input type="number" name="hourly_rate[]" value="{{@$space_houre->hourly_rate}}" id="hour{{ $meeting->id }}" class="form-label m-1"
                    style="width: 25%" required>
                <label class="form-label m-1" for="hour{{ $meeting->id }}"> Hourly Rate</label>
            </div>
        @endforeach
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{ __('Cancel') }}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" id="myButton" value="{{ __('Create') }}" class="btn  btn-primary">
</div>
{{ Form::close() }}

<script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>
<script>
        document.getElementById('myButton').disabled = true;
        setTimeout(function() {
            document.getElementById('myButton').disabled = false;
        }, 3000); 

    if ($(".multi-select").length > 0) {
        $($(".multi-select")).each(function(index, element) {
            var id = $(element).attr('id');
            var multipleCancelButton = new Choices(
                '#' + id, {
                    removeItemButton: true,
                }
            );
        });
    }
</script>
<script>
    if ($(".chair_select").length > 0) {
        $($(".chair_select")).each(function(index, element) {
            var id = $(element).attr('id');
            var multipleCancelButton = new Choices(
                '#' + id, {
                    removeItemButton: true,
                }
            );
        });
    }
</script>

<script type="text/javascript">
    $(".client_select").change(function() {

        var client_id = $(this).val();
        getparent(client_id);
    });

    function getparent(bid) {

        $.ajax({
            url: `{{ url('contract/clients/select') }}/${bid}`,
            type: 'GET',
            success: function(data) {
                console.log(data);
                $("#project_id").html('');
                $('#project_id').append(
                    '<select class="form-control" id="project_id" name="project_id[]"  ></select>');
                //var sdfdsfd = JSON.parse(data);
                $.each(data, function(i, item) {
                    console.log(item);
                    $('#project_id').append('<option value="' + item.id + '">' + item.name +
                        '</option>');
                });

                // var multipleCancelButton = new Choices('#project_id', {
                //     removeItemButton: true,
                // });

                if (data == '') {
                    $('#project_id').empty();
                }
            }
        });
    }

    $('#addpropcheck').on('change', function() {
        if ($(this).is(":checked")) {
            $('#companySelect').css('display', 'none');
            $('.companyText').removeClass('d-none');
            $('#companySelect').prop('required', false);
            $('.req').prop('required', true);
        } else {
            $('#companySelect').prop('required', true);
            $('.req').prop('required', false);
            $('.companyText').addClass('d-none');
            $('#companySelect').css('display', 'block');
        }
    });


    function getchairs(ids) {
        var a =$('#con_id').val();
        $.ajax({
            url: `{{ url('space_chair') }}/${ids}/${a}`,
            type: 'GET',
            success: function(data) {
                console.log(data);
                if (data.success == 'true') {
                    var s = ` {{ Form::label('chair', __('Chair'), ['class' => 'form-label']) }}
                <select name="chair[]"  class="form-control select chair_select" id="chair"   multiple="multiple">
                <option value="" disabled >Select Chairs</option> `;
                    $("#ch").empty();

                    for (var i = 0; i < data.data.length; i++) {
                        s += `<option value="` + data.data[i]['id'] +
                            `"${data.assignchair.indexOf(data.data[i]['id']) !== -1 ? 'disabled' : ''}${data.conchair.indexOf(data.data[i]['id']) !== -1 ? 'selected' : ''}>` +
                            data.data[i]['name'] + `</option>`;
                    }
                    s += `</select>`;
                    $('#ch').html(s);
                    if ($(".chair_select").length > 0) {
                        $($(".chair_select")).each(function(index, element) {
                            var id = $(element).attr('id');
                            var multipleCancelButton = new Choices(
                                '#' + id, {
                                    removeItemButton: true,
                                }
                            );
                        });
                    }
                }
            }
        });
    }
</script>


{{-- <script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>
<script>
    if ($(".multi-select").length > 0) {
        $($(".multi-select")).each(function(index, element) {
            var id = $(element).attr('id');
            var multipleCancelButton = new Choices(
                '#' + id, {
                    removeItemButton: true,
                }
            );
        });
    }
</script>

<script type="text/javascript">
    $(".client_select").change(function() {

        var client_id = $(this).val();
        getparent(client_id);
    });

    function getparent(bid) {

        $.ajax({
            url: `{{ url('contract/clients/select') }}/${bid}`,
            type: 'GET',
            success: function(data) {
                console.log(data);
                $("#project_id").html('');
                $('#project_id').append(
                    '<select class="form-control" id="project_id" name="project_id[]"  ></select>');
                //var sdfdsfd = JSON.parse(data);
                $.each(data, function(i, item) {
                    //console.log(item.name);
                    $('#project_id').append('<option value="' + item.id + '">' + item.name +
                        '</option>');
                });

                // var multipleCancelButton = new Choices('#project_id', {
                //     removeItemButton: true,
                // });

                if (data == '') {
                    $('#project_id').empty();
                }
            }
        });
    }
</script> --}}
