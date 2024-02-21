<?php

namespace App\Http\Controllers;

use App\Models\CustomField;
use App\Models\Plan;
use App\Models\User;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class BranchesController extends Controller
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
        if(\Auth::user()->can('view companybranch'))
        {
            $user    = \Auth::user();
            $branches = User::where('created_by', '=', $user->creatorId())->where('type', '=', 'branch')->get();

            return view('branches.index', compact('branches'));
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
        if(\Auth::user()->can('create companybranch'))
        {
            if($request->ajax)
            {
                return view('branches.createAjax');
            }
            else
            {
                $customFields = CustomField::where('module', '=', 'client')->get();

                return view('branches.create', compact('customFields'));
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
        if(\Auth::user()->can('create companybranch'))
        {
            $default_language = DB::table('settings')->select('value')->where('name', 'default_language')->where('created_by', '=', \Auth::user()->creatorId())->first();
            DB::beginTransaction();
            try {
            $user      = \Auth::user();
            $validator = \Validator::make(
                $request->all(), [
                    'name' => 'required',
                    'email' => 'required|email|unique:users',
                    'password' => 'required',
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
            $objCustomer    = \Auth::user();
            $creator        = User::find($objCustomer->creatorId());
            $total_branches = User::where('created_by', '=', \Auth::user()->creatorId())->where('type','branch')->count();
            $plan           = Plan::find($creator->plan);
           
            if($total_branches < $plan->max_branch || $plan->max_branch == -1)
            {
                $branches = User::create(
                    [
                        'name' => $request->name,
                        'email' => $request->email,
                        'job_title' => $request->job_title,
                        'password' => Hash::make($request->password),
                        'type' => 'branch',
                        'lang' => !empty($default_language) ? $default_language->value : 'en',
                        'owned_by' => $user->ownedId(),
                        'created_by' => $user->creatorId(),
                        'email_verified_at' => date('Y-m-d H:i:s'),
                    ]
                );

                $role_r = Role::findByName('branch');
                $branches->assignRole($role_r);
                // $branches->password = $request->password;

                $user->branchDefaultBankAccount($branches->id,$branches->created_by);

                Utility::chartOfAccountTypeDataBranch($branches->id,$branches->created_by);
                // Utility::chartOfAccountData($user);
                // default chart of account for new company
                Utility::chartOfAccountData1Branch($branches->id,$branches->created_by);
                Utility::virtual_office_branch($branches->id,$branches->created_by);
                Utility::services_branch($branches->id,$branches->created_by);
                Utility::security_services_branch($branches->id,$branches->created_by);

                // //Send Email
                // $setings = Utility::settings();

                // if($setings['new_client'] == 1)
                // {
               
                //     $clientArr = [
                //         'client_name' => $client->name,
                //         'client_email' => $client->email,
                //         'client_password' =>  $client->password,
                //     ];
                //     $resp = Utility::sendEmailTemplate('new_client', [$client->email], $clientArr);
                //     return redirect()->route('clients.index')->with('success', __('Client successfully added.') . ((!empty($resp) && $resp['is_success'] == false && !empty($resp['error'])) ? '<br> <span class="text-danger">' . $resp['error'] . '</span>' : ''));
                // }
                DB::commit();
                return redirect()->route('branches.index')->with('success', __('Branch successfully created.'));
            }
            else
            {
                return redirect()->back()->with('error', __('Your user limit is over, Please upgrade plan.'));
            }
            

        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return redirect()->back()->with('error', $e);
        }
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
    public function edit(User $branch)
    {
        if(\Auth::user()->can('edit companybranch'))
        {
            $user = \Auth::user();
            if($branch->created_by == $user->creatorId())
            {

                $branch->customField = CustomField::getData($branch, 'branch');
                $customFields        = CustomField::where('module', '=', 'branch')->get();

                return view('branches.edit', compact('branch', 'customFields'));
            }
            else
            {
                return response()->json(['error' => __('Invalid Branch.')], 401);
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
    public function update(User $branch, Request $request)
    {
        if(\Auth::user()->can('edit companybranch'))
        {
            $user = \Auth::user();
            if($branch->created_by == $user->creatorId())
            {
                $validation = [
                    'name' => 'required',
                    'email' => 'required|email|unique:users,email,' . $branch->id,
                ];

                $post         = [];
                $post['name'] = $request->name;
                if(!empty($request->password))
                {
                    $validation['password'] = 'required';
                    $post['password']       = Hash::make($request->password);
                }

                $validator = \Validator::make($request->all(), $validation);
                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }
                $post['email'] = $request->email;

                $branch->update($post);

                CustomField::saveData($branch, $request->customField);

                return redirect()->back()->with('success', __('Branch Updated Successfully!'));
            }
            else
            {
                return redirect()->back()->with('error', __('Invalid Branch.'));
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
    public function destroy(User $branch)
    {
        $user = \Auth::user();
        if($branch->created_by == $user->creatorId())
        {
    
            $branch->delete();
            return redirect()->back()->with('success', __('Branch Deleted Successfully!'));

        }
        else
        {
            return redirect()->back()->with('error', __('Invalid Branch.'));
        }
    }

    public function branchPassword($id)
    {
        $eId        = \Crypt::decrypt($id);
        $user = User::find($eId);
        $client = User::where('created_by', '=', $user->creatorId())->where('type', '=', 'branch')->first();


        return view('branches.reset', compact('user', 'client'));
    }

    public function branchPasswordReset(Request $request, $id)
    {
        $validator = \Validator::make(
            $request->all(), [
                               'password' => 'required|confirmed|same:password_confirmation',
                           ]
        );

        if($validator->fails())
        {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }


        $user = User::where('id', $id)->first();
        $user->forceFill([
                             'password' => Hash::make($request->password),
                         ])->save();

        return redirect()->route('branches.index')->with(
            'success', 'Branch Password successfully updated.'
        );


    }

}
