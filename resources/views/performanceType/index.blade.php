@extends('layouts.admin')
@push('script-page')
@endpush
@section('page-title')
    {{__('manage performance type')}}
@endsection
@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0 ">{{__('Performance Type')}}</h5>
    </div>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{__('Performance Type')}}</li>
@endsection




@section('action-btn')
    <div class="float-end">
        <a href="#" data-url="{{ route('performanceType.create') }}" data-ajax-popup="true" data-title="{{__('Create New Performance Type')}}" data-bs-toggle="tooltip" title="{{__('Create')}}"  class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i>
        </a>
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
                                {{ Form::open(['route' => ['performanceType.index'], 'method' => 'GET', 'id' => 'performanceType_submit']) }}
                                <div class="row d-flex justify-content-end ">
                
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mr-2">
                                        <div class="btn-box">
                                            {{ Form::label('branches', __('Branches'),['class'=>'form-label'])}}
                                            {{ Form::select('branches', $branches, isset($_GET['branches']) ? $_GET['branches'] : '', ['class' => 'form-control select' , 'onchange' => 'branchtype(this.value)']) }}
                                        </div>                               
                                    </div>
        
                                    <div class="col-auto float-end ms-2 mt-4">
                                        <a href="#" class="btn btn-sm btn-primary"
                                            onclick="document.getElementById('performanceType_submit').submit(); return false;"
                                            data-toggle="tooltip" data-original-title="{{ __('apply') }}">
                                            <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                                        </a>
                                        <a href="{{ route('performanceType.index') }}" class="btn btn-sm btn-danger" data-toggle="tooltip"
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
                                <th scope="col">{{__('Name')}}</th>
                                <th scope="col" class="">{{__('Action')}}</th>

                            </tr>
                            </thead>
                            <tbody class="list">
                            @foreach ($types as $type)
                                <tr class="font-style">
                                    <td>{{ $type->name }}</td>

                                    <td class="">

                                        <div class="action-btn bg-primary ms-2">
                                            <a href="#" data-url="{{ route('performanceType.edit',$type->id) }}" data-ajax-popup="true" title="{{__('Edit')}}" data-title="{{__('Edit Performance Type')}}" class="mx-3 btn btn-sm align-items-center" data-bs-toggle="tooltip" data-original-title="{{__('Edit')}}">
                                                <i class="ti ti-pencil text-white"></i>
                                            </a>
                                        </div>

                                        <div class="action-btn bg-danger ms-2">
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['performanceType.destroy', $type->id],'id'=>'delete-form-'.$type->id]) !!}
                                            <a href="#!" class="mx-3 btn btn-sm align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="document.getElementById('delete-form-{{$type->id}}').submit();">
                                                <i class="ti ti-trash text-white"></i>
                                            </a>
                                            {!! Form::close() !!}
                                        </div>

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

