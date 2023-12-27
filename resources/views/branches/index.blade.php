@extends('layouts.admin')
@php
   // $profile=asset(Storage::url('uploads/avatar/'));
    $profile=\App\Models\Utility::get_file('uploads/avatar/');
@endphp
@section('page-title')
    {{__('Manage Branch')}}
@endsection
@push('script-page')
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('All Branch')}}</li>
@endsection
@section('action-btn')
    <div class="float-end">
        <a href="#" data-size="md" data-url="{{ route('branches.create') }}" data-ajax-popup="true"  data-bs-toggle="tooltip" title="{{__('Create')}}"  class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i>
        </a>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-xxl-12">
            <div class="row">
                @foreach($branches as $branch)
                    <div class="col-md-3">
                        <div class="card text-center">
                            <div class="card-header border-0 pb-0">

                                <div class="card-header-right">
                                    <div class="btn-group card-option">
                                        <button type="button" class="btn dropdown-toggle"
                                                data-bs-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                            <i class="ti ti-dots-vertical"></i>
                                        </button>

                                        <div class="dropdown-menu dropdown-menu-end">

                                            @can('edit companybranch')
                                                <a href="#!" data-size="md" data-url="{{ route('branches.edit',$branch->id) }}" data-ajax-popup="true" class="dropdown-item" data-bs-original-title="{{__('Edit Branch')}}">
                                                    <i class="ti ti-pencil"></i>
                                                    <span>{{__('Edit')}}</span>
                                                </a>
                                            @endcan

                                            @can('delete companybranch')
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['branches.destroy', $branch['id']],'id'=>'delete-form-'.$branch['id']]) !!}
                                                <a href="#!"  class="dropdown-item bs-pass-para">
                                                    <i class="ti ti-archive"></i>
                                                    <span> @if($branch->delete_status!=0){{__('Delete')}} @else {{__('Restore')}}@endif</span>
                                                </a>

                                                {!! Form::close() !!}
                                            @endcan

                                            <a href="#!" data-url="{{route('branch.reset',\Crypt::encrypt($branch->id))}}" data-ajax-popup="true" class="dropdown-item" data-bs-original-title="{{__('Reset Password')}}">
                                                <i class="ti ti-adjustments"></i>
                                                <span>  {{__('Reset Password')}}</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body full-card">
                                <div class="img-fluid rounded-circle card-avatar">
                                    <img src="{{(!empty($branch->avatar))? asset(Storage::url("uploads/avatar/".$branch->avatar)): asset(Storage::url("uploads/avatar/avatar.png"))}}"  class="img-user wid-80 rounded-circle">
                                </div>
                                <h4 class="mt-2 text-primary">{{ $branch->name }}</h4>
                                <p></p>
                                <div class="row">
                                    <div class="col-12 col-sm-12">
                                        <div class="d-grid text-primary">
                                            {{ $branch->email }}
                                        </div>
                                    </div>
                                </div>
                                <div class="align-items-center h6 mt-2" data-bs-toggle="tooltip" title="{{__('Last Login')}}">
                                    {{ (!empty($branch->last_login_at)) ? $branch->last_login_at : '' }}
                                </div>
                            </div>
                            <div class="card-footer p-3">
                                <div class="row">
                                    <div class="col-6">
                                        {{-- <h6 class="mb-0"> @if($branch->clientDeals)
                                                {{$client->clientDeals->count()}}
                                            @endif</h6> --}}
                                        <p class="text-muted text-sm mb-0">{{__('Deals')}}</p>
                                    </div>
                                    <div class="col-6">
                                        {{-- <h6 class="mb-0">@if($client->clientProjects)
                                                {{ $client->clientProjects->count() }}
                                            @endif</h6> --}}
                                        <p class="text-muted text-sm mb-0">{{__('Projects')}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
