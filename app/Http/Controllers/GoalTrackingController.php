<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Employee;
use App\Models\GoalTracking;
use App\Models\GoalType;
use App\Models\User;
use Illuminate\Http\Request;

class GoalTrackingController extends Controller
{

    public function index(Request $request)
    {
        if(\Auth::user()->can('manage goal tracking'))
        {
            $user = \Auth::user();
            if($user->type == 'company')
            {
                $branches = User::where('type', '=', 'branch')->get()->pluck('name', 'id');
                $branches->prepend(\Auth::user()->name, \Auth::user()->id);               
                $branches->prepend('Select Branch', '');
                if($user->type == 'Employee')
                {
                    $employee      = Employee::where('user_id', $user->id)->first();
                    $query = GoalTracking::where('created_by', '=', \Auth::user()->creatorId())->where('branch', $employee->branch_id);
                }
                else
                {
                    $query = GoalTracking::where('created_by', '=', \Auth::user()->creatorId());
                }
            }else{
                $branches = User::where('id', '=', \Auth::user()->ownedId())->get()->pluck('name', 'id');
                $branches->prepend('Select Branch', '');
                if($user->type == 'Employee')
                {
                    $employee      = Employee::where('user_id', $user->id)->first();
                    $query = GoalTracking::where('owned_by', '=', \Auth::user()->ownedId())->where('branch', $employee->branch_id);
                }
                else
                {
                    $query = GoalTracking::where('owned_by', '=', \Auth::user()->ownedId());
                }
            }
            if (!empty($request->branches)) {
                $query->where('owned_by', '=', $request->branches);
            }
            $goalTrackings = $query->get();

            return view('goaltracking.index', compact('goalTrackings','branches'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function create()
    {
        if(\Auth::user()->can('create goal tracking'))
        {
            if(\Auth::user()->type == 'company')
            {
                $brances = Branch::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
                $brances->prepend('Select Branch', '');
                $goalTypes = GoalType::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
                $goalTypes->prepend('Select Goal Type', '');

            }else{

                $brances = Branch::where('owned_by', '=', \Auth::user()->ownedId())->get()->pluck('name', 'id');
                $brances->prepend('Select Branch', '');
                $goalTypes = GoalType::where('owned_by', '=', \Auth::user()->ownedId())->get()->pluck('name', 'id');
                $goalTypes->prepend('Select Goal Type', '');
            }
                $status = GoalTracking::$status;

            return view('goaltracking.create', compact('brances', 'goalTypes','status'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function store(Request $request)
    {
        if(\Auth::user()->can('create goal tracking'))
        {

            $validator = \Validator::make(
                $request->all(), [
                                   'branch' => 'required',
                                   'goal_type' => 'required',
                                   'start_date' => 'required',
                                   'end_date' => 'required',
                                   'subject' => 'required',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $goalTracking                     = new GoalTracking();
            $goalTracking->branch             = $request->branch;
            $goalTracking->goal_type          = $request->goal_type;
            $goalTracking->start_date         = $request->start_date;
            $goalTracking->end_date           = $request->end_date;
            $goalTracking->subject            = $request->subject;
            $goalTracking->target_achievement = $request->target_achievement;
            $goalTracking->description        = $request->description;
            $goalTracking->owned_by           = \Auth::user()->ownedId();
            $goalTracking->created_by         = \Auth::user()->creatorId();
            $goalTracking->save();

            return redirect()->route('goaltracking.index')->with('success', __('Goal tracking successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function show(GoalTracking $goalTracking)
    {
        //
    }


    public function edit($id)
    {

        if(\Auth::user()->can('edit goal tracking'))
        {
            if(\Auth::user()->type == 'company')
            {
                $goalTracking = GoalTracking::find($id);
                $brances      = Branch::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
                $brances->prepend('Select Branch', '');
                $goalTypes = GoalType::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
                $goalTypes->prepend('Select Goal Type', '');
            }else{
                $goalTracking = GoalTracking::find($id);
                $brances      = Branch::where('owned_by', '=', \Auth::user()->ownedId())->get()->pluck('name', 'id');
                $brances->prepend('Select Branch', '');
                $goalTypes = GoalType::where('owned_by', '=', \Auth::user()->ownedId())->get()->pluck('name', 'id');
                $goalTypes->prepend('Select Goal Type', '');
            }
            $status = GoalTracking::$status;
            $ratings = json_decode($goalTracking->rating,true);

            return view('goaltracking.edit', compact('brances', 'goalTypes', 'goalTracking', 'ratings','status'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function update(Request $request, $id)
    {
        if(\Auth::user()->can('edit goal tracking'))
        {
            $goalTracking = GoalTracking::find($id);
            $validator    = \Validator::make(
                $request->all(), [
                                   'branch' => 'required',
                                   'goal_type' => 'required',
                                   'start_date' => 'required',
                                   'end_date' => 'required',
                                   'subject' => 'required',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $goalTracking->branch             = $request->branch;
            $goalTracking->goal_type          = $request->goal_type;
            $goalTracking->start_date         = $request->start_date;
            $goalTracking->end_date           = $request->end_date;
            $goalTracking->subject            = $request->subject;
            $goalTracking->target_achievement = $request->target_achievement;
            $goalTracking->status             = $request->status;
            $goalTracking->progress           = $request->progress;
            $goalTracking->description        = $request->description;
            $goalTracking->rating         = json_encode($request->rating, true);
            $goalTracking->rating        = $request->rating;
            $goalTracking->save();

            return redirect()->route('goaltracking.index')->with('success', __('Goal tracking successfully updated.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }



    public function destroy($id)
    {

        if(\Auth::user()->can('delete goal tracking'))
        {
            $goalTracking = GoalTracking::find($id);
            if($goalTracking->created_by == \Auth::user()->creatorId())
            {
                $goalTracking->delete();

                return redirect()->route('goaltracking.index')->with('success', __('GoalTracking successfully deleted.'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
