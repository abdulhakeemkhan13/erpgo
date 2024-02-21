@extends('layouts.admin')
@section('page-title')
    {{__('Manage Branch')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Branch')}}</li>
@endsection

@section('action-btn')
    <div class="float-end">
        @can('create branch')
            <a href="#" data-url="{{ route('branch.create') }}" data-ajax-popup="true" data-title="{{__('Create New Branch')}}" data-bs-toggle="tooltip" title="{{__('Create')}}"  class="btn btn-sm btn-primary">
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
                                {{ Form::open(['route' => ['branch.index'], 'method' => 'GET', 'id' => 'branch_submit']) }}
                                <div class="row d-flex justify-content-end ">
                
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mr-2">
                                        <div class="btn-box">
                                            {{ Form::label('branches', __('Branches'),['class'=>'form-label'])}}
                                            {{ Form::select('branches_comp', $branches_comp, isset($_GET['branches_comp']) ? $_GET['branches_comp'] : '', ['class' => 'form-control select' ]) }}
                                        </div>                               
                                    </div>
        
                                    <div class="col-auto float-end ms-2 mt-4">
                                        <a href="#" class="btn btn-sm btn-primary"
                                            onclick="document.getElementById('branch_submit').submit(); return false;"
                                            data-toggle="tooltip" data-original-title="{{ __('apply') }}">
                                            <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                                        </a>
                                        <a href="{{ route('branch.index') }}" class="btn btn-sm btn-danger" data-toggle="tooltip"
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
                                <th width="200px">{{__('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody class="font-style">
                            @foreach ($branches as $branch)
                                <tr>
                                    <td>{{ $branch->name }}</td>
                                    <td class="Action text-end">
                                        <span>
                                            @can('edit branch')
                                                <div class="action-btn bg-primary ms-2">

                                                <a href="#" class="mx-3 btn btn-sm align-items-center" data-url="{{ URL::to('branch/'.$branch->id.'/edit') }}"  data-ajax-popup="true" data-title="{{__('Edit Branch')}}" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}"><i class="ti ti-pencil text-white"></i></a>
                                            </div>
                                            @endcan
                                            @can('delete branch')
                                                <div class="action-btn bg-danger ms-2">
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['branch.destroy', $branch->id],'id'=>'delete-form-'.$branch->id]) !!}

                                                <a href="#" class="mx-3 btn btn-sm align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$branch->id}}').submit();"><i class="ti ti-trash text-white text-white"></i></a>
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
