@extends('layouts.admin')
@php
   // $profile=asset(Storage::url('uploads/avatar/'));
    $profile=\App\Models\Utility::get_file('uploads/avatar/');
@endphp
@section('page-title')
    {{__('Manage Visitor')}}
@endsection
@push('script-page')
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('All Visitor')}}</li>
@endsection
@section('action-btn')
    <div class="float-end">
        <a href="#" data-size="md" data-url="{{ route('isvisitor.create') }}" data-ajax-popup="true"  data-bs-toggle="tooltip" title="{{__('Create')}}"  class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i>
        </a>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
            <div class="card-body table-border-style">
                        <div class="table-responsive">
                        <table class="table datatable">
                                <thead>
                                <tr>
                                    <th>{{__('Name')}}</th>
                                    <th>{{__('Date')}}</th>
                                    <th>{{__('CNIC')}}</th>
                                    <th width="200px">{{__('Action')}}</th>
    
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($isvisitors as $isvisitor)
                                    <tr>
                                    
                                        <td>
                                            {{ (!empty($isvisitor->name)) ? $isvisitor->name : '-' }}
                                        </td>
                                        <td>
                                            {{ (!empty($isvisitor->date_time)) ? $isvisitor->date_time : '-' }}
                                        </td>
                                        <td>
                                            {{ (!empty($isvisitor->cnic)) ? $isvisitor->cnic : '-' }}
                                        </td>
                                        @if(Gate::check('edit chair') || Gate::check('delete chair'))
                                            <td>
                                                    @can('edit chair')
                                                    <div class="action-btn bg-primary ms-2">
                                                      
                                                        <a href="#!"data-url="{{route('isvisitor.edit',$isvisitor->id)}}"  data-ajax-popup="true" class="mx-3 btn btn-sm align-items-center" data-bs-toggle="tooltip" title="{{__('Edit')}}"
                                                         data-original-title="{{__('Edit')}}"><i class="ti ti-pencil text-white"></i></a>
                                                    </div>
    
                                                    @endcan
                                                    @can('delete chair')
                                                    <div class="action-btn bg-danger ms-2">
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['isvisitor.destroy', $isvisitor->id],'id'=>'delete-form-'.$isvisitor->id]) !!}
    
                                                        <a href="#" class="mx-3 btn btn-sm align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$isvisitor->id}}').submit();"><i class="ti ti-trash text-white"></i></a>
                                                        {!! Form::close() !!}
                                                    </div>
                                                    @endcan
                                                {{-- @else
    
                                                    <i class="ti ti-lock"></i>
                                                @endif --}}
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
