@extends('layouts.admin')
@section('page-title')
    {{__('Dashboard')}}
@endsection
@push('script-page')
    <script>

    </script>
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}" class="text-primary">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item text-primary">{{__('CRM')}}</li>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-4 col-md-12 dashboard-card">
            <div class="card  hover-border-primary">
                <div class="card-body">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mb-3 mb-sm-0">
                            <div class="d-flex align-items-center">
                            <div class="account-dashboard-svg">
                            <svg fill="#1b98d0" xmlns="http://www.w3.org/2000/svg" width="64px" height="64px" viewBox="-52 -52 204.00 204.00" enable-background="new 0 0 100 100" xml:space="preserve" stroke="#1b98d0"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M37.1,62.3H77c1.1,0,2,0.9,2,2v4c0,1.1-0.9,2-2,2H37.1c-1.1,0-2-0.9-2-2v-4C35.1,63.2,36,62.3,37.1,62.3z"></path> <path d="M25,70.3h-4c-1.1,0-2-0.9-2-2v-4c0-1.1,0.9-2,2-2h4c1.1,0,2,0.9,2,2v4c0.1,1-0.7,1.9-1.8,2 C25.1,70.3,25,70.3,25,70.3z"></path> <path d="M25,52.4h-4c-1.1,0-2-0.9-2-2v-4c0-1.1,0.9-2,2-2h4c1.1,0,2,0.9,2,2v4c0.1,1-0.7,1.9-1.8,2 C25.1,52.4,25,52.4,25,52.4z"></path> <path d="M25,34.5h-4c-1.1,0-2-0.9-2-2v-4c0-1.1,0.9-2,2-2h4c1.1,0,2,0.9,2,2v4c0.1,1-0.7,1.9-1.8,2 C25.1,34.5,25,34.5,25,34.5z"></path> <path d="M37.1,44.4h35.1c1.1,0,2,0.9,2,2v4c0,1.1-0.9,2-2,2H37.1c-1.1,0-2-0.9-2-2v-4C35.1,45.3,36,44.4,37.1,44.4z"></path> <path d="M37.1,26.6H77c1.1,0,2,0.9,2,2v4c0,1.1-0.9,2-2,2H37.1c-1.1,0-2-0.9-2-2v-4C35.1,27.5,36,26.6,37.1,26.6z"></path> </g></svg>
                            </div>
                                <div class="ms-3">
                                    <small class="text-muted">{{ __('Total') }}</small>
                                    <h6 class="m-0">{{ __('Lead') }}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto text-end">
                            <h4 class="m-0">{{$crm_data['total_leads']}}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-12 dashboard-card">
            <div class="card  hover-border-primary">
                <div class="card-body">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mb-3 mb-sm-0">
                            <div class="d-flex align-items-center">
                            <div class="account-dashboard-svg">
                            <svg width="64px" height="64px" viewBox="-512 -512 2048.00 2048.00" fill="#1b98d0" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" stroke="#1b98d0"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M545.5395 1023.356c-12.29 0-24.57-4.678-33.922-14.022a7.988 7.988 0 0 1 0-11.304 7.992 7.992 0 0 1 11.306 0c12.49 12.474 32.79 12.458 45.25-0.016 12.454-12.468 12.446-32.752-0.032-45.218a7.988 7.988 0 0 1 0-11.304 7.988 7.988 0 0 1 11.304 0c18.706 18.69 18.72 49.114 0.032 67.828-9.354 9.35-21.652 14.036-33.938 14.036zM624.7095 944.236c-12.828 0-24.882-4.996-33.946-14.068a7.988 7.988 0 0 1 0-11.304 7.988 7.988 0 0 1 11.304 0c12.07 12.078 33.14 12.11 45.218 0.032 12.468-12.466 12.46-32.76-0.016-45.234l-62.176-62.208a7.992 7.992 0 1 1 11.304-11.304l62.176 62.208c18.714 18.706 18.714 49.146 0.016 67.844-9.038 9.046-21.074 14.034-33.88 14.034zM703.8195 865.08c-12.29 0-24.568-4.676-33.922-14.03l-62.176-62.178a7.992 7.992 0 1 1 11.304-11.304l62.176 62.178c12.476 12.474 32.76 12.474 45.234 0 12.476-12.476 12.476-32.776 0-45.252l-62.192-62.16c-3.124-3.122-3.124-8.182 0-11.304s8.184-3.124 11.304 0l62.192 62.16c18.714 18.708 18.714 49.156 0 67.862-9.35 9.352-21.63 14.028-33.92 14.028zM782.9675 785.932c-12.28 0-24.558-4.67-33.914-14.008l-62.2-62.214a7.992 7.992 0 0 1 0-11.304 7.988 7.988 0 0 1 11.304 0l62.192 62.208c12.476 12.446 32.76 12.46 45.22 0 12.474-12.476 12.474-32.774 0-45.25L596.4175 506.222a7.988 7.988 0 0 1 0-11.304 7.988 7.988 0 0 1 11.304 0l209.154 209.138c18.712 18.708 18.712 49.154 0 67.86-9.336 9.346-21.618 14.016-33.908 14.016zM195.5575 666.348a7.988 7.988 0 0 1-7.128-4.366c-34.624-67.914-46.016-134.68-46.484-137.492a7.996 7.996 0 0 1 6.566-9.196c4.396-0.656 8.47 2.224 9.204 6.566 0.11 0.672 11.5 67.234 44.954 132.864a7.988 7.988 0 0 1-7.112 11.624zM434.9495 381.682a7.964 7.964 0 0 1-3.084-0.618c-55.508-23.242-93.164-42.814-93.538-43.01a8.004 8.004 0 0 1-3.388-10.79 7.974 7.974 0 0 1 10.79-3.388c0.368 0.196 37.466 19.48 92.304 42.432a8 8 0 0 1-3.084 15.374zM814.9335 676.154a7.992 7.992 0 0 1-6.504-12.64c47.724-66.914 56.922-162.708 57.008-163.668 0.406-4.388 4.176-7.682 8.69-7.238a8 8 0 0 1 7.236 8.69c-0.376 4.09-9.704 101.104-59.91 171.508a8.002 8.002 0 0 1-6.52 3.348zM477.7015 1000.76h-0.008c-12.804 0-24.85-4.996-33.906-14.05-18.69-18.684-18.69-49.118-0.008-67.838l33.922-33.922c18.144-18.126 49.732-18.112 67.83 0.016 18.698 18.698 18.698 49.13 0 67.83l-33.9 33.898c-9.072 9.07-21.12 14.066-33.93 14.066z m33.922-113.86a31.83 31.83 0 0 0-22.626 9.362l-33.906 33.906c-12.452 12.484-12.46 32.776 0 45.236a31.756 31.756 0 0 0 22.602 9.368h0.008c8.542 0 16.576-3.332 22.624-9.382l33.9-33.898c12.466-12.468 12.466-32.754 0-45.22a31.72 31.72 0 0 0-22.602-9.372zM398.5515 921.62c-12.804 0-24.842-4.988-33.898-14.044-18.69-18.712-18.69-49.146 0-67.86l45.22-45.22c18.128-18.104 49.748-18.12 67.828 0 18.706 18.708 18.706 49.14 0 67.846l-45.218 45.218c-9.066 9.064-21.12 14.06-33.932 14.06z m45.25-125.172a31.792 31.792 0 0 0-22.624 9.352l-45.22 45.22c-12.46 12.474-12.46 32.776 0 45.25a31.746 31.746 0 0 0 22.594 9.362 31.82 31.82 0 0 0 22.626-9.376l45.218-45.218c12.468-12.468 12.468-32.768 0-45.236a31.7 31.7 0 0 0-22.594-9.354zM319.4175 842.462c-12.82 0-24.858-4.98-33.9-14.04-9.064-9.046-14.06-21.094-14.068-33.906a47.664 47.664 0 0 1 14.038-33.938l33.93-33.914c18.12-18.136 49.74-18.122 67.844 0.016 9.064 9.042 14.054 21.08 14.054 33.898 0 12.804-4.99 24.852-14.054 33.914l-33.93 33.93c-9.064 9.06-21.11 14.04-33.914 14.04z m33.916-113.858a31.756 31.756 0 0 0-22.61 9.368l-33.93 33.914a31.77 31.77 0 0 0-9.352 22.624 31.808 31.808 0 0 0 9.384 22.61c12.054 12.07 33.118 12.07 45.204 0l33.93-33.93a31.772 31.772 0 0 0 9.37-22.61c0-8.54-3.326-16.558-9.362-22.586a31.778 31.778 0 0 0-22.634-9.39zM240.2775 763.33h-0.008c-12.812 0-24.85-4.982-33.898-14.04-18.7-18.712-18.7-49.144 0-67.844l22.61-22.61c18.12-18.128 49.692-18.098 67.812 0.016 9.064 9.062 14.054 21.102 14.062 33.906s-4.982 24.844-14.046 33.906l-22.61 22.61c-9.066 9.066-21.112 14.056-33.922 14.056z m22.594-102.548a31.74 31.74 0 0 0-22.586 9.362l-22.61 22.61c-12.46 12.468-12.46 32.758 0 45.234a31.734 31.734 0 0 0 22.594 9.354h0.008c8.542 0 16.574-3.326 22.618-9.37l22.61-22.61c6.042-6.042 9.362-14.068 9.362-22.602s-3.334-16.558-9.376-22.602c-6.054-6.042-14.08-9.376-22.62-9.376zM409.8875 548.506c-12.29 0-24.578-4.684-33.93-14.038-18.698-18.698-18.698-49.114 0-67.812l73.482-73.512c68.922-68.922 224.082-91.758 230.646-92.702 4.326-0.696 8.418 2.404 9.05 6.784a7.998 7.998 0 0 1-6.786 9.048c-1.562 0.218-156.464 23.03-221.608 88.174l-73.48 73.512c-12.46 12.46-12.46 32.744 0 45.204 12.468 12.476 32.75 12.476 45.22 0.016 4.154-4.154 102.328-101.134 152.63-50.886a7.992 7.992 0 0 1 0 11.304 7.988 7.988 0 0 1-11.304 0c-32.432-32.384-104.852 25.732-130.022 50.886-9.344 9.346-21.624 14.022-33.898 14.022zM907.3315 497.26a7.96 7.96 0 0 1-5.652-2.342L686.8715 280.096a7.992 7.992 0 0 1 0-11.304 7.988 7.988 0 0 1 11.304 0l214.808 214.822a7.992 7.992 0 0 1-5.652 13.646zM986.4795 463.33a7.96 7.96 0 0 1-5.652-2.342L720.7855 200.962a7.992 7.992 0 0 1 0-11.304 7.988 7.988 0 0 1 11.304 0l260.042 260.026a7.992 7.992 0 0 1-5.652 13.646z" fill=""></path><path d="M692.5235 282.438a7.992 7.992 0 0 1-5.652-13.646l33.914-33.916a7.992 7.992 0 1 1 11.304 11.304l-33.914 33.916a7.96 7.96 0 0 1-5.652 2.342zM907.3315 497.26a7.96 7.96 0 0 1-5.652-2.342 7.988 7.988 0 0 1 0-11.304l33.914-33.916a7.992 7.992 0 1 1 11.304 11.306l-33.914 33.914a7.968 7.968 0 0 1-5.652 2.342zM726.4375 203.304a7.992 7.992 0 0 1-5.652-13.646l186.672-186.67a7.992 7.992 0 1 1 11.304 11.304l-186.672 186.67a7.96 7.96 0 0 1-5.652 2.342zM986.4795 463.33a7.96 7.96 0 0 1-5.652-2.342 7.988 7.988 0 0 1 0-11.304l29.528-29.496a7.992 7.992 0 1 1 11.304 11.304l-29.528 29.496a7.966 7.966 0 0 1-5.652 2.342zM115.9175 519.838a7.992 7.992 0 0 1-5.654-13.646L325.0855 291.4c3.122-3.124 8.182-3.124 11.304 0s3.124 8.182 0 11.304L121.5695 517.496a7.978 7.978 0 0 1-5.652 2.342zM36.7835 485.94a7.966 7.966 0 0 1-5.652-2.342 7.988 7.988 0 0 1 0-11.304l260.042-260.026a7.988 7.988 0 0 1 11.304 0 7.988 7.988 0 0 1 0 11.304L42.4355 483.598a7.968 7.968 0 0 1-5.652 2.342z" fill=""></path><path d="M115.9175 519.838a7.98 7.98 0 0 1-5.654-2.342l-33.914-33.898c-3.124-3.124-3.124-8.182 0-11.304s8.182-3.124 11.304 0l33.916 33.898a7.992 7.992 0 0 1-5.652 13.646zM330.7395 305.046a7.966 7.966 0 0 1-5.652-2.342l-33.916-33.914a7.988 7.988 0 0 1 0-11.304 7.988 7.988 0 0 1 11.304 0l33.916 33.914a7.988 7.988 0 0 1 0 11.304 7.968 7.968 0 0 1-5.652 2.342zM36.7835 485.94a7.966 7.966 0 0 1-5.652-2.342l-28.2-28.2a7.994 7.994 0 0 1 11.304-11.306l28.2 28.2a7.988 7.988 0 0 1 0 11.304 7.962 7.962 0 0 1-5.652 2.344zM296.8235 225.914a7.978 7.978 0 0 1-5.652-2.342L81.9555 14.354c-3.124-3.124-3.124-8.182 0-11.304s8.182-3.124 11.304 0l209.216 209.216a7.988 7.988 0 0 1 0 11.304 7.964 7.964 0 0 1-5.652 2.344zM23.9635 415.784a23.848 23.848 0 0 1-16.974-7.026c-9.33-9.376-9.314-24.584 0.016-33.914 9.026-9.056 24.882-9.064 33.922 0.008a23.778 23.778 0 0 1 7.01 16.942 23.796 23.796 0 0 1-7.018 16.964 23.78 23.78 0 0 1-16.956 7.026z m0-31.978c-2.14 0-4.146 0.828-5.644 2.334a8.024 8.024 0 0 0-0.008 11.328c2.982 2.974 8.284 2.998 11.296-0.008a7.944 7.944 0 0 0 2.342-5.66c0-2.14-0.828-4.146-2.334-5.652a7.912 7.912 0 0 0-5.652-2.342z" fill=""></path></g></svg>
                            </div>
                            <div class="ms-3">
                                    <small class="text-muted">{{ __('Total') }}</small>
                                    <h6 class="m-0">{{ __('Deal') }}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto text-end">
                            <h4 class="m-0">{{$crm_data['total_deals']}}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-12 dashboard-card">
            <div class="card  hover-border-primary">
                <div class="card-body">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mb-3 mb-sm-0">
                            <div class="d-flex align-items-center">
                            <div class="account-dashboard-svg">

                            <svg width="64px" height="64px" viewBox="-12.72 -12.72 49.44 49.44" xmlns="http://www.w3.org/2000/svg" fill="#1b98d0" stroke="#1b98d0"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <defs> <style>.cls-1,.cls-2{fill:none;stroke:#1b98d0;stroke-miterlimit:10;stroke-width:0.984;}.cls-1{stroke-linecap:square;}</style> </defs> <g id="agreement"> <rect class="cls-1" x="3.41" y="1.5" width="17.18" height="21"></rect> <path class="cls-1" d="M16.77,7.23h0Z"></path> <path class="cls-1" d="M16.77,11.05h0Z"></path> <polyline class="cls-2" points="8.18 19.64 8.18 18.68 10.09 15.82 11.04 18.68 12.96 17.73 13.91 18.68 16.77 18.68"></polyline> </g> </g></svg>

                            </div>
                                <div class="ms-3">
                                    <small class="text-muted">{{ __('Total') }}</small>
                                    <h6 class="m-0">{{ __('Contract') }}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto text-end">
                            <h4 class="m-0">{{$crm_data['total_contracts']}}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card  hover-border-primary">
                <div class="card-header">
                    <h5>{{__('Lead Status')}}</h5>
                </div>
                <div class="card-body">
                    <div class="row ">
                        @foreach($crm_data['lead_status'] as $status => $val)
                            <div class="col-md-6 col-sm-6 mb-5">
                                <div class="align-items-start">
                                    <div class="ms-2">
                                        <p class="text-muted text-sm mb-0">{{$val['lead_stage']}}</p>
                                        <h3 class="mb-0 text-primary">{{ $val['lead_percentage'] }}%</h3>
                                        <div class="progress mb-0">
                                            <div class="progress-bar bg-primary" style="width:{{$val['lead_percentage']}}%;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card  hover-border-primary">
                <div class="card-header">
                    <h5>{{__('Deal Status')}}</h5>
                </div>
                <div class="card-body">
                    <div class="row ">
                        @foreach($crm_data['deal_status'] as $status => $val)
                            <div class="col-md-6 col-sm-6 mb-5">
                                <div class="align-items-start">
                                    <div class="ms-2">
                                        <p class="text-muted text-sm mb-0">{{$val['deal_stage']}}</p>
                                        <h3 class="mb-0 text-primary">{{ $val['deal_percentage'] }}%</h3>
                                        <div class="progress mb-0">
                                            <div class="progress-bar bg-primary" style="width:{{$val['deal_percentage']}}%;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-12">
            <div class="card  hover-border-primary">
                <div class="card-header">
                    <h5 class="mt-1 mb-0">{{__('Latest Contract')}}</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th></th>
                                <th>{{__('Subject')}}</th>
                                @if(\Auth::user()->type!='client')
                                <th>{{__('Client')}}</th>
                                @endif
                                <th>{{__('Project')}}</th>
                                <th>{{__('Contract Type')}}</th>
                                <th>{{__('Contract Value')}}</th>
                                <th>{{__('Start Date')}}</th>
                                <th>{{__('End Date')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($crm_data['latestContract'] as $contract)
                                <tr>
                                    <td>
                                        <a href="{{route('contract.show',$contract->id)}}" class="btn btn-outline-primary">{{\Auth::user()->contractNumberFormat($contract->id)}}</a>
                                    </td>
                                    <td>{{ $contract->subject}}</td>
                                    @if(\Auth::user()->type!='client')
                                        <td>{{ !empty($contract->clients)?$contract->clients->name:'-' }}</td>
                                    @endif
                                    <td>{{ !empty($contract->projects)?$contract->projects->project_name:'-' }}</td>
                                    <td>{{ !empty($contract->types)?$contract->types->name:'' }}</td>
                                    <td>{{ \Auth::user()->priceFormat($contract->value) }}</td>
                                    <td>{{ \Auth::user()->dateFormat($contract->start_date )}}</td>
                                    <td>{{ \Auth::user()->dateFormat($contract->end_date )}}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">
                                        <div class="text-center">
                                            <h6>{{__('There is no latest contract')}}</h6>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
