<?php

namespace App\Http\Controllers;

use App\Models\ClientDeal;
use App\Models\ClientPermission;
use App\Models\ClientUserDetails;
use App\Models\Company;
use App\Models\Contract;
use App\Models\CustomField;
use App\Models\Estimation;
use App\Models\Invoice;
use App\Models\Plan;
use App\Models\User;
use App\Models\Utility;
use http\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;

class ClientUserController extends Controller
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

    public function index()
    {
        if(\Auth::user()->can('manage clientuser'))
        {
            if(\Auth::user()->type == 'company'){
                $user    = \Auth::user();
                $clients = User::where('created_by', '=', $user->creatorId())->where('type', '=', 'clientuser')->get();
            }else{
                $user    = \Auth::user();
                $clients = User::where('owned_by', '=', $user->id)->where('type', '=', 'clientuser')->get();
            }
            

            return view('clientuser.index', compact('clients'));
        }
        else
        {

            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function create(Request $request)
    {

        if(\Auth::user()->can('create clientuser'))
        {
            if($request->ajax)
            {
                return view('clientuser.createAjax');
            }
            else
            {
                $customFields = CustomField::where('module', '=', 'clientuser')->get();
                if(\Auth::user()->type == 'company'){
                    $user    = \Auth::user();
                    $company = Company::where('created_by', '=', $user->creatorId())->pluck('name','id');
                }else{
                    $user    = \Auth::user();
                    $company = Company::where('owned_by', '=', $user->id)->pluck('name','id');
                }

                return view('clientuser.create', compact('customFields','company'));
            }
        }
        else
        {
            return response()->json(['error' => __('Permission Denied.')], 401);
        }
    }

    public function store(Request $request)
    {
        if(\Auth::user()->can('create clientuser'))
        {
            $default_language = DB::table('settings')->select('value')->where('name', 'default_language')->where('created_by', '=', \Auth::user()->creatorId())->first();

            $user      = \Auth::user();
            $validator = \Validator::make(
                $request->all(), [
                    'name' => 'required', 
                    'email' => 'required|email|unique:users',
                    'password' => 'required',
                    'company' => 'required',
                    'cnic' => 'required',
                    // 'phone','required'
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
            $total_client = User::where('created_by', '=', \Auth::user()->creatorId())->where('type','client')->count();
//             dd($total_client);
            $plan           = Plan::find($creator->plan);
            if($total_client < $plan->max_clients || $plan->max_clients == -1)
            {
                $role = Role::findByName('clientuser');
                $client = User::create(
                    [
                        'name' => $request->name,
                        'email' => $request->email,
                        'company_id' => $request->company,
                        'job_title' => $request->job_title,
                        'password' => Hash::make($request->password),
                        'type' => 'clientuser',
                        'lang' => !empty($default_language) ? $default_language->value : 'en',
                        'owned_by' => $user->id,
                        'created_by' => $user->creatorId(),
                        'email_verified_at' => date('Y-m-d H:i:s'),
                    ]
                );

                ClientUserDetails::create ([
                    'user_id' => $client->id,
                    'cnic' => $request->cnic,
                    'phone' =>$request->phone
                ]);

                // Send Email
                $setings = Utility::settings();

                if($setings['new_client'] == 1)
                {
                    $role_r = Role::findByName('clientuser');
                    $client->assignRole($role_r);
                    $client->password = $request->password;

                    $clientArr = [
                        'client_name' => $client->name,
                        'client_email' => $client->email,
                        'client_password' =>  $client->password,
                    ];
                    $resp = Utility::sendEmailTemplate('new_client', [$client->email], $clientArr);
                    return redirect()->route('clientuser.index')->with('success', __('Client successfully added.') . ((!empty($resp) && $resp['is_success'] == false && !empty($resp['error'])) ? '<br> <span class="text-danger">' . $resp['error'] . '</span>' : ''));
                }
                return redirect()->route('clientuser.index')->with('success', __('Client successfully created.'));
            }
            else
            {
                return redirect()->back()->with('error', __('Your user limit is over, Please upgrade plan.'));
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

    public function show(User $client)
    {
        $usr = Auth::user();
        if(!empty($client) && $usr->id == $client->creatorId() && $client->id != $usr->id && $client->type == 'client')
        {
            // For Estimations
            $estimations = $client->clientEstimations()->orderByDesc('id')->get();
            $curr_month  = $client->clientEstimations()->whereMonth('issue_date', '=', date('m'))->get();
            $curr_week   = $client->clientEstimations()->whereBetween(
                'issue_date', [
                                \Carbon\Carbon::now()->startOfWeek(),
                                \Carbon\Carbon::now()->endOfWeek(),
                            ]
            )->get();
            $last_30days = $client->clientEstimations()->whereDate('issue_date', '>', \Carbon\Carbon::now()->subDays(30))->get();
            // Estimation Summary
            $cnt_estimation                = [];
            $cnt_estimation['total']       = Estimation::getEstimationSummary($estimations);
            $cnt_estimation['this_month']  = Estimation::getEstimationSummary($curr_month);
            $cnt_estimation['this_week']   = Estimation::getEstimationSummary($curr_week);
            $cnt_estimation['last_30days'] = Estimation::getEstimationSummary($last_30days);

            $cnt_estimation['cnt_total']       = $estimations->count();
            $cnt_estimation['cnt_this_month']  = $curr_month->count();
            $cnt_estimation['cnt_this_week']   = $curr_week->count();
            $cnt_estimation['cnt_last_30days'] = $last_30days->count();

            // For Contracts
            $contracts   = $client->clientContracts()->orderByDesc('id')->get();
            $curr_month  = $client->clientContracts()->whereMonth('start_date', '=', date('m'))->get();
            $curr_week   = $client->clientContracts()->whereBetween(
                'start_date', [
                                \Carbon\Carbon::now()->startOfWeek(),
                                \Carbon\Carbon::now()->endOfWeek(),
                            ]
            )->get();
            $last_30days = $client->clientContracts()->whereDate('start_date', '>', \Carbon\Carbon::now()->subDays(30))->get();

            // Contracts Summary
            $cnt_contract                = [];
            $cnt_contract['total']       = Contract::getContractSummary($contracts);
            $cnt_contract['this_month']  = Contract::getContractSummary($curr_month);
            $cnt_contract['this_week']   = Contract::getContractSummary($curr_week);
            $cnt_contract['last_30days'] = Contract::getContractSummary($last_30days);

            $cnt_contract['cnt_total']       = $contracts->count();
            $cnt_contract['cnt_this_month']  = $curr_month->count();
            $cnt_contract['cnt_this_week']   = $curr_week->count();
            $cnt_contract['cnt_last_30days'] = $last_30days->count();

            return view('clients.show', compact('client', 'estimations', 'cnt_estimation', 'contracts', 'cnt_contract'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function edit(User $clientuser)
    {
        // dd($clientuser->created_by );
        if(\Auth::user()->can('edit clientuser'))
        {
            $user = \Auth::user();
            if($clientuser->created_by == $user->creatorId())
            {
                $clientuser->customField = CustomField::getData($clientuser, 'clientuser');
                $customFields        = CustomField::where('module', '=', 'clientuser')->get();
                if(\Auth::user()->type == 'company'){
                    $user    = \Auth::user();
                    $company = Company::where('created_by', '=', $user->creatorId())->pluck('name','id');
                }else{
                    $user    = \Auth::user();
                    $company = Company::where('owned_by', '=', $user->id)->pluck('name','id');
                }
                $clients = User::with('clientuser')->where('id',$clientuser->id)->first();
                // dd($clients);

                return view('clientuser.edit', compact('clients', 'customFields','company'));
            }
            else
            {
                return response()->json(['error' => __('Invalid Client.')], 401);
            }
        }
        else
        {
            return response()->json(['error' => __('Permission Denied.')], 401);
        }
    }

    public function update(User $clientuser, Request $request)
    {
        if(\Auth::user()->can('edit client'))
        {
            $user = \Auth::user();
            if($clientuser->created_by == $user->creatorId())
            {
                $validation = [
                    'name' => 'required',
                    'email' => 'required|email|unique:users,email,' . $clientuser->id,
                    'cnic' => 'required',
                ];

                $post         = [];
                $post['name'] = $request->name;
                $post['company_id'] = $request->company;
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
                $post['name'] = $request->name;
                $post['email'] = $request->email;
                $post['company_id'] = $request->company;

                $clientuser->update($post);

                ClientUserDetails::where('user_id', $clientuser->id)->update([
                    // 'user_id' => $client->id,
                    'cnic' => $request->cnic,
                    'phone' =>$request->phone
                ]);

                CustomField::saveData($clientuser, $request->customField);

                return redirect()->back()->with('success', __('Client Updated Successfully!'));
            }
            else
            {
                return redirect()->back()->with('error', __('Invalid Client.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function destroy(User $clientuser)
    {
        $user = \Auth::user();
            if($clientuser->created_by == $user->creatorId())
            {
                $estimation = Estimation::where('client_id', '=', $clientuser->id)->first();
                if(empty($estimation))
                {
                  /*  ClientDeal::where('client_id', '=', $client->id)->delete();
                    ClientPermission::where('client_id', '=', $client->id)->delete();*/
                    $clientuser->delete();
                    return redirect()->back()->with('success', __('Client Deleted Successfully!'));
                }
                else
                {
                    return redirect()->back()->with('error', __('This client has assigned some estimation.'));
                }
            }
            else
            {
                return redirect()->back()->with('error', __('Invalid Client.'));
            }
        }

    public function clientPassword($id)
    {
        $eId        = \Crypt::decrypt($id);
        $user = User::find($eId);
        $client = User::where('created_by', '=', $user->creatorId())->where('type', '=', 'client')->first();


        return view('clients.reset', compact('user', 'client'));
    }

    public function clientPasswordReset(Request $request, $id)
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


        $user                 = User::where('id', $id)->first();
        $user->forceFill([
                             'password' => Hash::make($request->password),
                         ])->save();

        return redirect()->route('clients.index')->with(
            'success', 'Client Password successfully updated.'
        );


    }


}
