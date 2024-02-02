@extends('layouts.admin')
@section('page-title')
    {{__('Manage Contract')}}
@endsection
@push('script-page')
<script>
    function branchcustomer(id) {
        var company = $('#companyselect').val();
        $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url: "{{ route('branch.company') }}",
                        type: "POST",
                        data: {id: id},
                        dataType: 'json',
                        success: function (result)
                        {
                            console.log(result);
                            if(result.status == 'success'){
                                $('#companyselect').empty();
                                $('#companyselect').append($('<option>', {
                                    value: '',
                                    text: 'select Company'
                                }));
                                // console.log(result);
                                for (var i = 0; i < result.company.length; i++) {
                                    var company = result.company[i];
                                    $('#companyselect').append($('<option>', {
                                        value: company.id,
                                        text: company.name
                                    }));
                                }


                            } 
                            if(result.status == 'error'){
                            }
                            
                        }
                    });
        // Add more code as needed
    }

    document.getElementById('branchcustomer').addEventListener('change', function() {
        var id = this.value;
        branchcustomer(id);
    });
</script>
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Contract')}}</li>
@endsection
@section('action-btn')
    <div class="float-end">
        <a href="{{ route('contract.grid') }}"  data-bs-toggle="tooltip" title="{{__('Grid View')}}" class="btn btn-sm btn-primary">
            <i class="ti ti-layout-grid"></i>
        </a>
        @if(\Auth::user()->type == 'company' || \Auth::user()->type == 'branch')
            <a href="#" data-size="lg" data-url="{{ route('contract.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Create New Contract')}}" class="btn btn-sm btn-primary">
                <i class="ti ti-plus"></i>
            </a>
            <a href="#" data-size="lg" data-url="{{ route('createvirtualoffice') }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Create New Virtual Office Contract')}}" class="btn btn-sm btn-primary">
                <i class="ti ti-plus"></i>
            </a>
        @endif
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="mt-2 " id="multiCollapseExample1">
                <div class="card">
                    <div class="card-body">
                        {{ Form::open(['route' => ['contract.index'], 'method' => 'GET', 'id' => 'company_submit']) }}
                        <div class="row d-flex justify-content-end ">
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mr-2">
                                <div class="btn-box">
                                    {{ Form::label('issue_date', __('Start Date'),['class'=>'form-label'])}}
                                    {{ Form::date('issue_date', isset($_GET['issue_date'])?$_GET['issue_date']:'', array('class' => 'form-control month-btn','id'=>'pc-daterangepicker-1')) }}
                                </div>
                            </div>
                            @if(\Auth::user()->type == 'company')
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mr-2">
                                    <div class="btn-box">
                                        {{ Form::label('branches', __('Branches'),['class'=>'form-label'])}}
                                        {{ Form::select('branches', $branches, isset($_GET['branches']) ? $_GET['branches'] : '', ['class' => 'form-control select' , 'onchange' => 'branchcustomer(this.value)']) }}
                                    </div>  
                                </div>
                            @endif                             
                            <div class="col-xl-2 col-lg-3 col-md-6 col-sm-12 col-12">
                                <div class="btn-box">
                                    {{ Form::label('company', __('Company'),['class'=>'form-label'])}}
                                    {{ Form::select('company', $company, isset($_GET['company']) ? $_GET['company'] : '', ['class' => 'form-control select' , 'id' => 'companyselect']) }}
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-3 col-md-6 col-sm-12 col-12">
                                <div class="btn-box">
                                    {{ Form::label('status', __('Status'), ['class' => 'form-label']) }}
                                    {{ Form::select('status', ['' => 'Select Status', 'open' => 'Open', 'closed' => 'Closed'], isset($_GET['status']) ? $_GET['status'] : '', ['class' => 'form-control select']) }}
                                </div>                                
                            </div>
                            <div class="col-auto float-end ms-2 mt-4">
                                <a href="#" class="btn btn-sm btn-primary"
                                    onclick="document.getElementById('company_submit').submit(); return false;"
                                    data-toggle="tooltip" data-original-title="{{ __('apply') }}">
                                    <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                                </a>
                                <a href="{{ route('contract.index') }}" class="btn btn-sm btn-danger" data-toggle="tooltip"
                                    data-original-title="{{ __('Reset') }}">
                                    <span class="btn-inner--icon"><i class="ti ti-trash-off text-white-off"></i></span>
                                </a>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                            <tr>
                                <th scope="col">{{__('#')}}</th>
                                <th scope="col">{{__('Subject')}}</th>
                                @if(\Auth::user()->type!='client')
                                    <th scope="col">{{__('Client')}}</th>
                                @endif
                                <th scope="col">{{__('Company')}}</th>

                                <th scope="col">{{__('Contract Type')}}</th>
                                <th scope="col">{{__('Contract Value')}}</th>
                                <th scope="col">{{__('Start Date')}}</th>
                                <th scope="col">{{__('End Date')}}</th>
                                <th scope="col" >{{__('Action')}}</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($contracts as $contract)

                                <tr class="font-style">
                                    <td>
                                        <a href="{{ route('contract.show', \Crypt::encrypt($contract->id)) }}" class="btn btn-outline-primary">{{ Auth::user()->contractNumberFormat($contract->id) }}</a>

                                        {{-- <a href="{{route('contract.show',$contract->id)}}" class="btn btn-outline-primary">{{\Auth::user()->contractNumberFormat($contract->id)}}</a> --}}
                                    </td>
                                    <td>{{ $contract->subject}}</td>
                                    @if(\Auth::user()->type!='client')
                                        <td>{{ !empty($contract->clients)?$contract->clients->name:'-' }}</td>
                                    @endif
                                    <td>{{ !empty($contract->company)?$contract->company->name:'-' }}</td>
                                    <td>{{ !empty($contract->types)?$contract->types->name:'' }}</td>
                                    <td>{{ \Auth::user()->priceFormat($contract->value) }}</td>
                                    <td>{{  \Auth::user()->dateFormat($contract->start_date )}}</td>
                                    <td>{{  \Auth::user()->dateFormat($contract->end_date )}}</td>
                                    {{--                                    <td>--}}
                                    {{--                                        <a href="#" class="action-item" data-url="{{ route('contract.description',$contract->id) }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Desciption')}}" data-title="{{__('Desciption')}}"><i class="fa fa-comment"></i></a>--}}
                                    {{--                                    </td>--}}

                                    <td class="action ">
                                        @if(\Auth::user()->type=='company')
                                            @if($contract->status=='accept')
                                                <div class="action-btn bg-primary ms-2">
                                                    <a href="#" data-size="lg"
                                                       data-url="{{ route('contract.copy', $contract->id) }}"
                                                       data-ajax-popup="true"
                                                       data-title="{{ __('Copy Contract') }}"
                                                       class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                                       data-bs-toggle="tooltip" data-bs-placement="top"
                                                       title="{{ __('Duplicate') }}"><i
                                                            class="ti ti-copy text-white"></i>
                                                    </a>
                                                </div>
                                            @endif
                                        @endif
                                        @can('show contract')
                                            <div class="action-btn bg-warning ms-2">
                                                <a href="{{ route('contract.show',\Crypt::encrypt($contract->id)) }}"
                                                   class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                                   data-bs-whatever="{{__('View Budget Planner')}}" data-bs-toggle="tooltip"
                                                   data-bs-original-title="{{__('View')}}"> <span class="text-white"> <i class="ti ti-eye"></i></span></a>
                                            </div>
                                            @if($contract->close_date == null)
                                                <div class="action-btn bg-info ms-2">
                                                    <a href="{{ route('contract_status',\Crypt::encrypt($contract->id)) }}" class="mx-3 btn btn-sm d-inline-flex align-items-center"   data-bs-toggle="tooltip" title="{{__('Close Contract')}}" >
                                                        <i class="ti ti-lock text-white"></i>
                                                    </a>
                                                </div>
                                            @endif
                                        @endcan
                                        @can('edit contract')
                                            <div class="action-btn bg-info ms-2">
                                                <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-url="{{ route('contract.edit',$contract->id) }}" data-ajax-popup="true" data-size="lg" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-title="{{__('Edit Contract')}}">
                                                    <i class="ti ti-pencil text-white"></i>
                                                </a></div>
                                        @endcan
                                        @can('delete contract')
                                            <div class="action-btn bg-danger ms-2">
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['contract.destroy', $contract->id]]) !!}
                                                <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}"><i class="ti ti-trash text-white"></i></a>
                                                {!! Form::close() !!}
                                            </div>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
