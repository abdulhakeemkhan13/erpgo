<div class="modal-body">
    <div class="row">
        {{-- @dd($task) --}}
        <div class="col-12 pb-2">
            <b>{{__(' Start Date Time')}}</b> : <span>{{ (!empty($task->start_date)) ? date('d-M-Y , h:i a', strtotime($task->start_date)): '-' }}</span>
        </div>
        <div class="col-12 pb-2">
            <b>{{__('End Date Time')}}</b> : <span>{{ (!empty($task->end_date)) ? date('d-M-Y , h:i a', strtotime($task->end_date)) : '-' }}</span>
        </div>
        <div class="col-12">
            <b>{{__('Total time')}}</b>  <span>{{ (!empty($task->total_min)) ? ($task->total_min).(' mint') : '-' }}</span>
            <hr/>
        </div>

        <div class="col-12 pb-4">
            {{-- <span class="text-sm">{{ @$task->taskProgress()['percentage'] }}</span>
            <div class="progress" style="top:0px">
                <div class="progress-bar bg-{{ @$task->taskProgress()['color'] }}" role="progressbar"
                     style="width: {{ @$task->taskProgress()['percentage'] }};">

                </div>
            </div> --}}
        </div>
    </div>

    <div class="row pb-2">
        <div class="col-6">
            {{-- @if(@$users = $task->users())
                @if(count($users) > 0)
                    <div class="avatar-group">
                        @foreach($users as $key => $user)
                            @if($key<3)
                                <a href="#" class="avatar rounded-circle avatar-sm">
                                    <img src="{{$user->getImgImageAttribute()}}" title="{{ $user->name }}">
                                </a>
                            @else
                                @break
                            @endif
                        @endforeach
                        @if(count($users) > 3)
                            <a href="#" class="avatar rounded-circle avatar-sm">
                                <img src="{{$user->getImgImageAttribute()}}" avatar="+ {{ count($users)-3 }}">
                            </a>
                        @endif
                    </div>
                @else
                    <p>{{__('No User Found.')}}</p>
                @endif
            @endif --}}
        </div>
        <div class="col-6 pt-2">
            <div class="row text-center">
                {{-- <div class="col-4" data-toggle="tooltip" data-placement="bottom" data-original-title="{{__('Attachment')}}">
                    <i class="ti ti-paperclip mr-2"></i>{{ count(@$task->taskFiles) }}
                </div>
                <div class="col-4" data-toggle="tooltip" data-placement="bottom" data-original-title="{{__('Comment')}}">
                    <i class="ti ti-brand-hipchat mr-2"></i>{{ count(@$task->comments) }}
                </div>
                <div class="col-4" data-toggle="tooltip" data-placement="bottom" data-original-title="{{__('Checklist')}}">
                    <i class="ti ti-list-check mr-2"></i>{{ @$task->countTaskChecklist() }}
                </div> --}}
            </div>
        </div>
    </div>
</div>
