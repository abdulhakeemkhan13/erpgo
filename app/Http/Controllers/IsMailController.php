<?php

namespace App\Http\Controllers;

use App\Models\Chair;
use App\Models\CustomField;
use App\Models\IsMail;
use App\Models\Plan;
use App\Models\Roomassign;
use App\Models\SpaceType;
use App\Models\User;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;


class IsMailController extends Controller
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
        if(\Auth::user()->can('view chair'))
        {
            if(\Auth::user()->type == 'company'){
                $user    = \Auth::user();
                $chair = IsMail::where('created_by', '=', $user->creatorId())->get();
            }else{
                $user    = \Auth::user();
                $chair = IsMail::where('owned_by', '=', $user->id)->get();
            }
            return view('ismail.index', compact('chair'));
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
        if(\Auth::user()->can('create chair'))
        {
            if($request->ajax)
            {
                return view('ismail.createAjax');
            }
            else
            {
                $customFields = CustomField::where('module', '=', 'ismail')->get();

                return view('ismail.create', compact('customFields'));
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
        if(\Auth::user()->can('create chair'))
        {
            $user      = \Auth::user();
            $validator = \Validator::make(
                $request->all(), [
                    'date' => 'required',
                    // 'price' => 'required',
                    // 'type' => 'required',
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
           
                $chair = IsMail::create(
                    [
                        'company_id' => $user->company_id,
                        'date' => $request->date,
                        'user_id' => $user->id,
                        'type' => $request->type,
                        'owned_by' => $user->owned_by,
                        'created_by' => $user->creatorId(),
                    ]
                );

                return redirect()->route('ismail.index')->with('success', __('IsMail successfully created.'));

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
    public function edit(IsMail $mail)
    {
        if(\Auth::user()->can('edit chair'))
        {
            $user = \Auth::user();
            if($mail->created_by == $user->creatorId() || $mail->owned_by == $user->id)
            {

                $mail->customField = CustomField::getData($chair, 'chair');
                $customFields        = CustomField::where('module', '=', 'chair')->get();

                return view('ismail.edit', compact('mail', 'customFields'));
            }
            else
            {
                return response()->json(['error' => __('Invalid Chair.')], 401);
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
    public function update(Chair $chair, Request $request)
    {
        if(\Auth::user()->can('edit chair'))
        {
            $user = \Auth::user();
            if($chair->created_by == $user->creatorId() || $chair->owned_by == $user->id)
            {
                $validation = [
                    'name' => 'required',
                    'price' => 'required',
                    'type' => 'required',
                ];

                $post         = [];
                $post['name'] = $request->name;
                $post['price'] = $request->price;
                $post['type'] = $request->type;
               

                $validator = \Validator::make($request->all(), $validation);
                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $chair->update($post);

                CustomField::saveData($chair, $request->customField);

                return redirect()->back()->with('success', __('Chair Updated Successfully!'));
            }
            else
            {
                return redirect()->back()->with('error', __('Invalid Chair.'));
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
    public function destroy(Chair $chair)
    {
        $user = \Auth::user();
        if($chair->created_by == $user->creatorId()  || $chair->owned_by == $user->id)
        {
    
            $chair->delete();
            return redirect()->back()->with('success', __('Chair Deleted Successfully!'));

        }
        else
        {
            return redirect()->back()->with('error', __('Invalid Chair.'));
        }
    }

    public function space_chair($id,$con=null)
    {
        // dd($con);
        $user = \Auth::user();
        if(\Auth::user()->type == 'branch'){
            $chair = Chair::where('space_id',$id)->where('owned_by', '=', $user->id)->get();
            $assignchair = Roomassign::where('space_id',$id)->pluck('chair_id')->toArray();
        }else{
            $chair = Chair::where('space_id',$id)->where('created_by', '=', $user->creatorId())->get();
            $assignchair = Roomassign::where('space_id',$id)->pluck('chair_id')->toArray();
        }
        if($con != null){
            $conchair = Roomassign::where('space_id',$id)->where('contract_id',$con)->pluck('chair_id')->toArray();
            return response()->json(['success' => 'true','data' => $chair, 'assignchair'=>$assignchair ,'conchair'=>$conchair ], 201);
        }
        // $conchair = Roomassign::where('space_id',$id)->where('contract_id',$con)->pluck('chair_id')->toArray();
        return response()->json(['success' => 'true','data' => $chair, 'assignchair'=>$assignchair ], 201);
    }


}
