<?php

namespace App\Http\Controllers;

use App\Models\Chair;
use App\Models\CustomField;
use App\Models\Plan;
use App\Models\SpaceType;
use App\Models\Space;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class SpaceController extends Controller
{

    public function __construct()
    {
        $this->middleware(
            [
                'auth',
                'XSS',
            ]
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(\Auth::user()->can('view space'))
        {
            if(\Auth::user()->type == 'company'){
            $user    = \Auth::user();
            $spaces = Space::where('created_by', '=', $user->creatorId())->get();

        }else{
            $user    = \Auth::user();
            $spaces = Space::where('owned_by', '=', $user->id)->get();
            }
            return view('space.index', compact('spaces'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if(\Auth::user()->can('create space'))
        {
            if($request->ajax)
            {
                return view('space.createAjax');
            }
            else
            {
                $customFields = CustomField::where('module', '=', 'space')->get();
                
                if(\Auth::user()->type == 'company'){
                    $user    = \Auth::user();
                    $spacetype = SpaceType::where('created_by', '=', $user->creatorId())->pluck('name','id');
        
                }else{
                    $user    = \Auth::user();
                    $spacetype = SpaceType::where('owned_by', '=', $user->id)->pluck('name','id');
                }

                return view('space.create', compact('customFields','spacetype'));
            }
        }
        else
        {
            return response()->json(['error' => __('Permission Denied.')], 401);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        if(\Auth::user()->can('create space'))
        {
            $user      = \Auth::user();
            $validator = \Validator::make(
                $request->all(), [
                    'name' => 'required',
                    'type_id' => 'required',
                    'capacity' => 'required',
                    'price' => 'required',
                ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();
                if($request->ajax)
                {
                    return response()->json(['error' => $messages->first()], 401);
                }
                else
                {
                    return redirect()->back()->with('error', $messages->first());
                }
            }
           
                $branches = Space::create(
                    [
                        'name' => $request->name,
                        'type_id' => $request->type_id,
                        'capacity' => $request->capacity,
                        'price' => $request->price,
                        'window' => $request->window,
                        'meeting' => $request->meeting,
                        'description' => $request->description,
                        'owned_by' => $user->id,
                        'created_by' => $user->creatorId(),
                    ]
                );
                if($branches->capacity > 0){
                    for ($i=1; $i <=$branches->capacity ; $i++) {
                         Chair::create(
                            [
                                'name' => 'chair'.$i,
                                'space_id' => $branches->id,
                                'type' => 'none',
                                'price' => '0',
                                'owned_by' => $user->id,
                                'created_by' => $user->creatorId(),
                            ]
                        );
                    }
                }

                return redirect()->route('space.index')->with('success', __('Space successfully created.'));

        }
        else
        {
            if($request->ajax)
            {
                return response()->json(['error' => __('Permission Denied.')], 401);
            }
            else
            {
                return redirect()->back()->with('error', __('Permission Denied.'));
            }
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Space $space)
    {
        if(\Auth::user()->can('edit space'))
        {
            $user = \Auth::user();
            if($space->created_by == $user->creatorId() || $space->owned_by == $user->id)
            {

                $space->customField = CustomField::getData($space, 'space');
                $customFields        = CustomField::where('module', '=', 'space')->get();

                if(\Auth::user()->type == 'company'){
                    $user    = \Auth::user();
                    $spacetype = SpaceType::where('created_by', '=', $user->creatorId())->pluck('name','id');
        
                }else{
                    $user    = \Auth::user();
                    $spacetype = SpaceType::where('owned_by', '=', $user->id)->pluck('name','id');
                }

                return view('space.edit', compact('space', 'customFields','spacetype'));
            }
            else
            {
                return response()->json(['error' => __('Invalid Space.')], 401);
            }
        }
        else
        {
            return response()->json(['error' => __('Permission Denied.')], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Space $space, Request $request)
    {
        if(\Auth::user()->can('edit space'))
        {
            $user = \Auth::user();
            if($space->created_by == $user->creatorId() || $space->owned_by == $user->id)
            {
                $validation = [
                    'name' => 'required',
                    'type_id' => 'required',
                    'capacity' => 'required',
                    'price' => 'required',
                ];

                $room         = [];
                $room['name'] = $request->name;
                $room['type_id'] = $request->type_id;
                $room['capacity'] = $request->capacity;
                $room['price'] = $request->price;
                $room['meeting'] = $request->meeting;
                $room['window'] = $request->window;
                $room['description'] = $request->description;

                $validator = \Validator::make($request->all(), $validation);
                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $space->update($room);
             
                $chair = Chair::where('space_id',$space->id)->count();
                if($room['capacity'] > 0 && $room['capacity'] != $chair){
                    if($room['capacity'] > $chair){
                        $diffchair = $room['capacity'] - $chair;
                        $a=$chair;
                        for ($i=1; $i <=$diffchair; $i++) {
                            Chair::create(
                               [
                                   'name' => 'chair'.++$a,
                                   'space_id' => $space->id,
                                   'type' => 'none',
                                   'price' => '0',
                                   'owned_by' => $user->id,
                                   'created_by' => $user->creatorId(),
                               ]
                           );
                        }
                        
                    }else{
                        $diffchair = $chair - $room['capacity']; 
                        $a=$chair;
                        for ($i=1; $i <=$diffchair; $i++) {
                            Chair::where('name','chair'.$a--)->where('space_id',$space->id)->delete();
                        }

                    }
                }

                CustomField::saveData($space, $request->customField);

                return redirect()->back()->with('success', __('Space Updated Successfully!'));
            }
            else
            {
                return redirect()->back()->with('error', __('Invalid Space.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Space $space)
    {
        $user = \Auth::user();
        if($space->created_by == $user->creatorId()  || $space->owned_by == $user->id)
        {
            Chair::where('space_id',$space->id)->delete();
            $space->delete();
            return redirect()->back()->with('success', __('Space Deleted Successfully!'));

        }
        else
        {
            return redirect()->back()->with('error', __('Invalid Space.'));
        }
    }


}
