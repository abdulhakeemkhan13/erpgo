@extends('layouts.admin')

@section('page-title')
    {{__('Manage Department')}}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Department')}}</li>
@endsection


@section('action-btn')
    <div class="float-end">
    @can('create department')
            <a href="#" data-url="{{ route('department.create') }}" data-ajax-popup="true" data-title="{{__('Create New Department')}}" data-bs-toggle="tooltip" title="{{__('Create')}}"  class="btn btn-sm btn-primary">
                <i class="ti ti-plus"></i>
            </a>

        @endcan
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-3">
            @include('layouts.hrm_setup')
        </div>
        <div class="col-9">
            @if(\Auth::user()->type == 'company')
            <div class="row">
                <div class="col-sm-12">
                    <div class="mt-2 " id="multiCollapseExample1">
                        <div class="card">
                            <div class="card-body">
                                {{ Form::open(['route' => ['department.index'], 'method' => 'GET', 'id' => 'department_submit']) }}
                                <div class="row d-flex justify-content-end ">
                
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mr-2">
                                        <div class="btn-box">
                                            {{ Form::label('branches', __('Branches'),['class'=>'form-label'])}}
                                            {{ Form::select('branches', $branches, isset($_GET['branches']) ? $_GET['branches'] : '', ['class' => 'form-control select' , 'onchange' => 'branchtype(this.value)']) }}
                                        </div>                               
                                    </div>
        
                                    <div class="col-auto float-end ms-2 mt-4">
                                        <a href="#" class="btn btn-sm btn-primary"
                                            onclick="document.getElementById('department_submit').submit(); return false;"
                                            data-toggle="tooltip" data-original-title="{{ __('apply') }}">
                                            <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                                        </a>
                                        <a href="{{ route('department.index') }}" class="btn btn-sm btn-danger" data-toggle="tooltip"
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
            @endif
            <div class="card">
            <div class="card-body table-border-style">
                    <div class="table-responsive">
                    <table class="table datatable">
                            <thead>
                            <tr>
                                <th>{{__('Branch')}}</th>
                                <th>{{__('Department')}}</th>
                                <th width="200px">{{__('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody class="font-style">
                            @foreach ($departments as $department)
                                <tr>
                                    <td>{{ !empty($department->branch)?$department->branch->name:'' }}</td>
                                    <td>{{ $department->name }}</td>

                                    <td class="Action">
                                        <span>
                                            @can('edit department')
                                            <div class="action-btn bg-primary ms-2">

                                                <a href="#" data-url="{{ URL::to('department/'.$department->id.'/edit') }}"  data-ajax-popup="true" data-title="{{__('Edit Department')}}" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}">
                                                    <i class="ti ti-pencil text-white"></i></a>
                                            </div>
                                                @endcan
                                            @can('delete department')
                                                    <div class="action-btn bg-danger ms-2">
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['department.destroy', $department->id],'id'=>'delete-form-'.$department->id]) !!}


                                                <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$department->id}}').submit();"><i class="ti ti-trash text-white"></i></a>
                                                {!! Form::close() !!}
                                                    </div>
                                            @endcan
                                        </span>
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
