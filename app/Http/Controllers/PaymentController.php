<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\BillAccount;
use App\Models\BillPayment;
use App\Models\ChartOfAccount;
use App\Models\Payment;
use App\Models\ProductServiceCategory;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Utility;
use App\Models\Vender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{

    public function index(Request $request)
    {
        if(\Auth::user()->can('manage payment'))
        {
            if(\Auth::user()->type == ('company')){
                $branches = User::where('type', '=', 'branch')->get()->pluck('name', 'id');
                $branches->prepend(\Auth::user()->name, \Auth::user()->id);               
                $branches->prepend('Select Branch', '');

                $vender = Vender::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
                $vender->prepend('Select Vendor', '');

                $account = BankAccount::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('holder_name', 'id');
                $account->prepend('Select Account', '');

                $category = ProductServiceCategory::where('created_by', '=', \Auth::user()->creatorId())->where('type', '=', 'expense')->get()->pluck('name', 'id');
                $category->prepend('Select Category', '');

                $query = Payment::where('created_by', '=', \Auth::user()->creatorId());
            }else{
                $branches = User::where('id', '=', \Auth::user()->ownedId())->get()->pluck('name', 'id');
                $branches->prepend('Select Branch', '');

                $vender = Vender::where('owned_by', '=', \Auth::user()->ownedId())->get()->pluck('name', 'id');
                $vender->prepend('Select Vendor', '');

                $account = BankAccount::where('owned_by', '=', \Auth::user()->ownedId())->get()->pluck('holder_name', 'id');
                $account->prepend('Select Account', '');

                $category = ProductServiceCategory::where('owned_by', '=', \Auth::user()->ownedId())->where('type', '=', 'expense')->get()->pluck('name', 'id');
                $category->prepend('Select Category', '');

                $query = Payment::where('owned_by', '=', \Auth::user()->ownedId());
            }
                //    if(!empty($request->date))
                //    {
                //        $date_range = explode('to', $request->date);
                //        $query->whereBetween('date', $date_range);
                //    }
                if (!empty($request->branches)) {
                    $query->where('owned_by', '=', $request->branches);
                    $vender = Vender::where('owned_by', '=', $request->branches)->get()->pluck('name', 'id');
                    $vender->prepend('Select Vendor', '');
                    $account = BankAccount::where('owned_by', '=', $request->branches)->get()->pluck('holder_name', 'id');
                    $account->prepend('Select Account', '');
                    $category = ProductServiceCategory::where('owned_by', '=', $request->branches)->where('type', '=', 'expense')->get()->pluck('name', 'id');
                    $category->prepend('Select Category', '');
                }

                if(count(explode('to', $request->date)) > 1)
                {
                    $date_range = explode(' to ', $request->date);
                    $query->whereBetween('date', $date_range);
                }
                elseif(!empty($request->date))
                {
                    $date_range = [$request->date , $request->date];
                    $query->whereBetween('date', $date_range);
                }

                if(!empty($request->vender))
                {
                    $query->where('id', '=', $request->vender);
                }
                if(!empty($request->account))
                {
                    $query->where('account_id', '=', $request->account);
                }

                if(!empty($request->category))
                {
                    $query->where('category_id', '=', $request->category);
                }


                $payments = $query->get();


            return view('payment.index', compact('payments', 'account', 'category', 'vender','branches'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function create()
    {
        if(\Auth::user()->can('create payment'))
        {
            if(\Auth::user()->type == ('company')){
                $venders = Vender::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
                $venders->prepend('--', 0);

                //    $categories = ProductServiceCategory::where('created_by', '=', \Auth::user()->creatorId())->where('type', '=', 2)->get()->pluck('name', 'id');
                $categories     = ProductServiceCategory::where('created_by', \Auth::user()->creatorId())
                    ->whereNotIn('type', ['product & service', 'income',])
                    ->get()->pluck('name', 'id');
                $categories->prepend('Select Category', '');

                $accounts   = BankAccount::select('*', \DB::raw("CONCAT(bank_name,' (',holder_name,')') AS name"))->where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');

                $chartAccounts = ChartOfAccount::select(\DB::raw('CONCAT(code, " - ", name) AS code_name, id'))
                    ->where('created_by', \Auth::user()->creatorId())->get()
                    ->pluck('code_name', 'id');
                $chartAccounts->prepend('Select Account', '');
            }else{
                $venders = Vender::where('owned_by', '=', \Auth::user()->ownedId())->get()->pluck('name', 'id');
                $venders->prepend('--', 0);

                //    $categories = ProductServiceCategory::where('created_by', '=', \Auth::user()->creatorId())->where('type', '=', 2)->get()->pluck('name', 'id');
                $categories     = ProductServiceCategory::where('owned_by', \Auth::user()->ownedId())
                    ->whereNotIn('type', ['product & service', 'income',])
                    ->get()->pluck('name', 'id');
                $categories->prepend('Select Category', '');

                $accounts   = BankAccount::select('*', \DB::raw("CONCAT(bank_name,' (',holder_name,')') AS name"))->where('owned_by', \Auth::user()->ownedId())->get()->pluck('name', 'id');

                $chartAccounts = ChartOfAccount::select(\DB::raw('CONCAT(code, " - ", name) AS code_name, id'))
                    ->where('owned_by', \Auth::user()->ownedId())->get()
                    ->pluck('code_name', 'id');
                $chartAccounts->prepend('Select Account', '');
            }
            return view('payment.create', compact('venders', 'categories', 'accounts','chartAccounts'));
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }


    public function store(Request $request)
    {
        if(\Auth::user()->can('create payment'))
        {

            $validator = \Validator::make(
                $request->all(), [
                                   'date' => 'required',
                                   'amount' => 'required',
                                   'account_id' => 'required',
                                   'category_id' => 'required',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }
            DB::beginTransaction();
            try {
                    $payment                    = new Payment();
                    $payment->date              = $request->date;
                    $payment->amount            = $request->amount;
                    $payment->account_id        = $request->account_id;
                    //            $payment->chart_account_id  = $request->chart_account_id;
                    $payment->vender_id         = $request->vender_id;
                    $payment->category_id       = $request->category_id;
                    $payment->payment_method    = 0;
                    $payment->reference         = $request->reference;
                    if(!empty($request->add_receipt))
                    {

                        //storage limit
                        $image_size = $request->file('add_receipt')->getSize();
                        $result = Utility::updateStorageLimit(\Auth::user()->creatorId(), $image_size);
                        if($result==1)
                        {
                            if($payment->add_receipt)
                            {
                                $path = storage_path('uploads/payment' . $payment->add_receipt);
                            }
                            $fileName = time() . "_" .preg_replace('/[^A-Za-z0-9\-]/', '', $request->add_receipt->getClientOriginalName()) ;
                            //                    $fileName = time() . "_" . $request->add_receipt->getClientOriginalName();
                            $payment->add_receipt = $fileName;
                            $dir        = 'uploads/payment';
                            $path = Utility::upload_file($request,'add_receipt',$fileName,$dir,[]);
                            if($path['flag']==0){
                                return redirect()->back()->with('error', __($path['msg']));
                            }
                        }
                    }
                    
                    $payment->description    = $request->description;
                    $payment->owned_by     = \Auth::user()->ownedId();
                    $payment->created_by     = \Auth::user()->creatorId();
                    $payment->save();
        
                    $chartAccountId = ChartOfAccount::find($request->account_id);


                    $account = new BillAccount();
                    $account->chart_account_id = $chartAccountId;
                    $account->price = $request->amount;
                    $account->description = $request->description;
                    $account->type = 'Payment';
                    $account->ref_id = $payment->id;
                    $account->save();

                    $category            = ProductServiceCategory::where('id', $request->category_id)->first();
                    $payment->payment_id = $payment->id;
                    $payment->type       = 'Payment';
                    $payment->category   = $category->name;
                    $payment->user_id    = $payment->vender_id;
                    $payment->user_type  = 'Vender';
                    $payment->account    = $request->account_id;

                    Transaction::addTransaction($payment);

                    $vender          = Vender::where('id', $request->vender_id)->first();
                    $payment         = new BillPayment();
                    $payment->name   = !empty($vender) ? $vender['name'] : '' ;
                    $payment->method = '-';
                    $payment->date   = \Auth::user()->dateFormat($request->date);
                    $payment->amount = \Auth::user()->priceFormat($request->amount);
                    $payment->bill   = '';

                    if(!empty($vender))
                    {
                        Utility::userBalance('vendor', $vender->id, $request->amount, 'debit');
                    }

                    Utility::bankAccountBalance($request->account_id, $request->amount, 'debit');


                    //For Notification
                    $setting  = Utility::settings(\Auth::user()->creatorId());

                    //Twilio Notification
                    if(isset($setting['twilio_payment_notification']) && $setting['twilio_payment_notification'] ==1)
                    {

                        $vender = Vender::find($request->vender_id);
                        $paymentNotificationArr = [
                            'payment_amount' => \Auth::user()->priceFormat($request->amount),
                            'vendor_name' => $vender->name,
                            'payment_type' =>  'Payment',
                        ];
                        Utility::send_twilio_msg($request->contact,'bill_payment', $paymentNotificationArr);
                    }

                DB::commit();
                return redirect()->route('payment.index')->with('success', __('Payment successfully created'). ((isset($result) && $result!=1) ? '<br> <span class="text-danger">' . $result . '</span>' : ''));
            } catch (\Exception $e) {
                dd($e);
                DB::rollback();
                return redirect()->back()->with('error', $e);
            }

        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function edit(Payment $payment)
    {

        if(\Auth::user()->can('edit payment'))
        {
            if(\Auth::user()->type == ('company')){
                $venders = Vender::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
                $venders->prepend('--', 0);

                $categories     = ProductServiceCategory::where('created_by', \Auth::user()->creatorId())
                    ->whereNotIn('type', ['product & service', 'income',])
                    ->get()->pluck('name', 'id');
                $categories->prepend('Select Category', '');

                $accounts = BankAccount::select('*', \DB::raw("CONCAT(bank_name,' (',holder_name,')') AS name"))->where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');

                $chartAccounts = ChartOfAccount::select(\DB::raw('CONCAT(code, " - ", name) AS code_name, id'))
                    ->where('created_by', \Auth::user()->creatorId())->get()
                    ->pluck('code_name', 'id');
                $chartAccounts->prepend('Select Account', '');
            }else{
                $venders = Vender::where('owned_by', '=', \Auth::user()->ownedId())->get()->pluck('name', 'id');
                $venders->prepend('--', 0);

                $categories     = ProductServiceCategory::where('owned_by', \Auth::user()->ownedId())
                    ->whereNotIn('type', ['product & service', 'income',])
                    ->get()->pluck('name', 'id');
                $categories->prepend('Select Category', '');

                $accounts = BankAccount::select('*', \DB::raw("CONCAT(bank_name,' (',holder_name,')') AS name"))->where('owned_by', \Auth::user()->ownedId())->get()->pluck('name', 'id');

                $chartAccounts = ChartOfAccount::select(\DB::raw('CONCAT(code, " - ", name) AS code_name, id'))
                    ->where('owned_by', \Auth::user()->ownedId())->get()
                    ->pluck('code_name', 'id');
                $chartAccounts->prepend('Select Account', '');
            }

            return view('payment.edit', compact('venders', 'categories', 'accounts', 'payment','chartAccounts'));
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }


    public function update(Request $request, Payment $payment)
    {
        if(\Auth::user()->can('edit payment'))
        {

            $validator = \Validator::make(
                $request->all(), [
                                   'date' => 'required',
                                   'amount' => 'required',
                                   'account_id' => 'required',
                                   'vender_id' => 'required',
                                   'category_id' => 'required',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }
            $vender = Vender::where('id', $request->vender_id)->first();
            if(!empty($vender))
            {
                Utility::userBalance('vendor', $vender->id, $payment->amount, 'credit');
            }
            Utility::bankAccountBalance($payment->account_id, $payment->amount, 'credit');

            $payment->date              = $request->date;
            $payment->amount            = $request->amount;
            $payment->account_id        = $request->account_id;
//            $payment->chart_account_id  = $request->chart_account_id;
            $payment->vender_id         = $request->vender_id;
            $payment->category_id       = $request->category_id;
            $payment->payment_method    = 0;
            $payment->reference         = $request->reference;

            if(!empty($request->add_receipt))
            {
                //storage limit
                $file_path = '/uploads/payment/'.$payment->add_receipt;
                $image_size = $request->file('add_receipt')->getSize();
                $result = Utility::updateStorageLimit(\Auth::user()->creatorId(), $image_size);
                if($result==1)
                {
                    if($payment->add_receipt)
                    {
                        Utility::changeStorageLimit(\Auth::user()->creatorId(), $file_path);
                        $path = storage_path('uploads/payment' . $payment->add_receipt);
//                        if(file_exists($path))
//                        {
//                            \File::delete($path);
//                        }
                    }
                    $fileName = time() . "_" . $request->add_receipt->getClientOriginalName();
                    $payment->add_receipt = $fileName;
                    $dir        = 'uploads/payment';
                    $path = Utility::upload_file($request,'add_receipt',$fileName,$dir,[]);
                    if($path['flag']==0){
                        return redirect()->back()->with('error', __($path['msg']));
                    }
                }

            }

            $payment->description    = $request->description;
            $payment->save();

            $category            = ProductServiceCategory::where('id', $request->category_id)->first();
            $payment->category   = $category->name;
            $payment->payment_id = $payment->id;
            $payment->type       = 'Payment';
            $payment->account    = $request->account_id;
            Transaction::editTransaction($payment);

            if(!empty($vender))
            {
                Utility::userBalance('vendor', $vender->id, $request->amount, 'debit');
            }

            Utility::bankAccountBalance($request->account_id, $request->amount, 'debit');

            return redirect()->route('payment.index')->with('success', __('Payment Updated Successfully'). ((isset($result) && $result!=1) ? '<br> <span class="text-danger">' . $result . '</span>' : ''));

        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function destroy(Payment $payment)
    {
        if(\Auth::user()->can('delete payment'))
        {
            if($payment->created_by == \Auth::user()->creatorId())
            {
                if(!empty($payment->add_receipt))
                {
                    //storage limit
                    $file_path = '/uploads/payment/'.$payment->add_receipt;
                    $result = Utility::changeStorageLimit(\Auth::user()->creatorId(), $file_path);

                }

                $payment->delete();
                $type = 'Payment';
                $user = 'Vender';
                Transaction::destroyTransaction($payment->id, $type, $user);

                if($payment->vender_id != 0)
                {
                    Utility::userBalance('vendor', $payment->vender_id, $payment->amount, 'credit');
                }
                Utility::bankAccountBalance($payment->account_id, $payment->amount, 'credit');

                return redirect()->route('payment.index')->with('success', __('Payment successfully deleted.'));
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

    public function branch_payment_data(Request $request)
    {
        $vender = Vender::where('owned_by', '=', $request->id)->get();
        $account = BankAccount::where('owned_by', '=', $request->id)->get();
        $category = ProductServiceCategory::where('owned_by', '=', $request->id)->where('type', '=', 'expense')->get();      

            $result = [
                'status' => 'success',
                'account' => $account,
                'vender' => $vender,
                'category' => $category,
            ];
            return response()->json($result);
    }
}
