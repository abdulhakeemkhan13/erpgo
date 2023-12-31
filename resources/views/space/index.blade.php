@extends('layouts.admin')
@php
   // $profile=asset(Storage::url('uploads/avatar/'));
    $profile=\App\Models\Utility::get_file('uploads/avatar/');
@endphp
@section('page-title')
    {{__('Manage Space')}}
@endsection
@push('script-page')
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('All Space')}}</li>
@endsection
@section('action-btn')
    <div class="float-end">
        <a href="#" data-size="md" data-url="{{ route('space.create') }}" data-ajax-popup="true"  data-bs-toggle="tooltip" title="{{__('Create')}}"  class="btn btn-sm btn-primary">
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
                                    <th>{{__('Type')}}</th>
                                    <th>{{__('Capacity')}}</th>
                                    <th>{{__('Price')}}</th>
                                    <th>{{__('Meeting')}}</th>
                                    <th>{{__('Window')}}</th>
                                    <th style="max-width:300px">{{__('Description')}}</th>
                                    <th width="200px">{{__('Action')}}</th>
    
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($spaces as $type)
                                    <tr>
                                    
                                        <td>
                                            {{ (!empty($type->name)) ? $type->name : '-' }}
                                        </td>
                                        <td>
                                            {{ (!empty($type->type)) ? $type->type->name : '-' }}
                                        </td>
                                        <td>
                                            {{ (!empty($type->capacity)) ? $type->capacity : '-' }}
                                        </td>
                                        <td>
                                            {{ (!empty($type->price)) ? $type->price : '-' }}
                                        </td>
                                        <td>
                                            {{ (!empty($type->meeting)) ? $type->meeting : '-' }}
                                        </td>
                                        <td>
                                            {{ (!empty($type->window)) ? $type->window : '-' }}
                                        </td>
                                        <td style="max-width:300px !important; overflow-y: auto;">
                                            {{ (!empty($type->description)) ? $type->description : '-' }}
                                        </td>
                                        @if(Gate::check('edit space') || Gate::check('delete space'))
                                            <td>
                                                    @can('edit space')
                                                    <div class="action-btn bg-primary ms-2">
                                                      
                                                        <a href="#!"data-url="{{route('space.edit',$type->id)}}"  data-ajax-popup="true" class="mx-3 btn btn-sm align-items-center" data-bs-toggle="tooltip" title="{{__('Edit')}}"
                                                         data-original-title="{{__('Edit')}}"><i class="ti ti-pencil text-white"></i></a>
                                                    </div>
    
                                                    @endcan
                                                    @can('delete space')
                                                    <div class="action-btn bg-danger ms-2">
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['space.destroy', $type->id],'id'=>'delete-form-'.$type->id]) !!}
    
                                                        <a href="#" class="mx-3 btn btn-sm align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$type->id}}').submit();"><i class="ti ti-trash text-white"></i></a>
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
