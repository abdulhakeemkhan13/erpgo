<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        if(\Auth::user()->can('manage department'))
        {
            if (\Auth::user()->type == 'company') {
                $branches = User::where('type', '=', 'branch')->get()->pluck('name', 'id');
                $branches->prepend(\Auth::user()->name, \Auth::user()->id);               
                $branches->prepend('Select Branch', '');
                $query = Department::where('created_by', '=', \Auth::user()->creatorId());
            }else{
                $branches = User::where('id', '=', \Auth::user()->ownedId())->get()->pluck('name', 'id');
                $branches->prepend('Select Branch', '');
                $query = Department::where('owned_by', '=', \Auth::user()->ownedId());
            }
            if (!empty($request->branches)) {
                $query->where('owned_by', '=', $request->branches);
            }
            $departments = $query->get();

            return view('department.index', compact('departments','branches'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        if(\Auth::user()->can('create department'))
        {
            if (\Auth::user()->type == 'company') {
                $branch = Branch::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            }else{
                $branch = Branch::where('owned_by', \Auth::user()->ownedId())->get()->pluck('name', 'id');
            }
            return view('department.create', compact('branch'));
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function store(Request $request)
    {
        if(\Auth::user()->can('create department'))
        {

            $validator = \Validator::make(
                $request->all(), [
                                   'branch_id' => 'required',
                                   'name' => 'required|max:20',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $department             = new Department();
            $department->branch_id  = $request->branch_id;
            $department->name       = $request->name;
            $department->owned_by = \Auth::user()->ownedId();
            $department->created_by = \Auth::user()->creatorId();
            $department->save();

            return redirect()->route('department.index')->with('success', __('Department  successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function show(Department $department)
    {
        return redirect()->route('department.index');
    }

    public function edit(Department $department)
    {
        if(\Auth::user()->can('edit department'))
        {
            if($department->created_by == \Auth::user()->creatorId())
            {
                $branch = Branch::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');

                return view('department.edit', compact('department', 'branch'));
            }
            else
            {
                return response()->json(['error' => __('Permission denied.')], 401);
            }
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function update(Request $request, Department $department)
    {
        if(\Auth::user()->can('edit department'))
        {
            if($department->created_by == \Auth::user()->creatorId())
            {
                $validator = \Validator::make(
                    $request->all(), [
                                       'branch_id' => 'required',
                                       'name' => 'required|max:20',
                                   ]
                );
                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $department->branch_id = $request->branch_id;
                $department->name      = $request->name;
                $department->save();

                return redirect()->route('department.index')->with('success', __('Department successfully updated.'));
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

    public function destroy(Department $department)
    {
        if(\Auth::user()->can('delete department'))
        {
            if($department->created_by == \Auth::user()->creatorId())
            {
                $department->delete();

                return redirect()->route('department.index')->with('success', __('Department successfully deleted.'));
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
