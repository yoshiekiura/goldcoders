<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Gateway;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request as ValidateRequest;

class PaymentController extends Controller
{
    public function index()
    {

        return Inertia::render('Payment/Index', [
            'payments' => Payment::with('paymaster', 'member')->get()
                ->transform(function ($field) {
                    return [
                        'id' => $field->id,
                        'paymaster_id' => $field->paymaster->id,
                        'paymaster_name' => $field->paymaster->name,

                        'member_id' => $field->member->id,
                        'member_name' => $field->member->name,

                        'amount' => $field->amount,
                        'date_enter' => $field->date_enter,
                        'activated' => $field->activated,
                    ];
                }),
        ]);
    }

    public function create()
    {

        $paymasters  = User::role('paymaster')->get();
        return Inertia::render('Payment/Create', [
            'paymasters'  => $paymasters,
            'gateways'  => Gateway::orderByName()->whereStatus(true)
                ->get()
                ->transform(function ($field) {
                    return [
                        'value' => $field->id,
                        'name' => $field->name,
                        'details' => $field->details,
                    ];
                }),
            'users' => User::orderByName()
                ->get()
                ->transform(function ($field) {
                    return [
                        'value' => $field->id,
                        'name' => $field->name,
                        'paymaster' => $field->paymaster_id,
                    ];
                }),
        ]);
    }


    public function getPaymasterMembers(User $user)
    {
        return UserResource::collection(User::where('paymaster_id', $user->id)->get());
    }

    public function store()
    {
        ValidateRequest::validate([
            'paymaster_id' => ['required', 'exists:users,id'],
            'member_id' => ['required', 'exists:users,id'],
            'date_enter' => ['required', 'date'],
            'amount' => ['required', 'numeric'],
            'gateway.value' => ['required', 'exists:gateways,id'],
            'gateway' => ['required']
        ]);

        $data = ValidateRequest::all();

        $pay = new Payment;
        $pay->paymaster_id = $data['paymaster_id'];
        $pay->member_id = $data['member_id'];
        $pay->gateway_id = $data['gateway']['value'];
        $pay->gateway_details = $data['gateway'];
        $pay->date_enter = $data['date_enter'];
        $pay->amount = $data['amount'];
        $pay->save();

        return Redirect::route('payment')->with('success', 'Payment was successfully created.');
    }

    public function delete(Request $request)
    {
        $payment = Payment::findorfail($request->id);
        $payment->delete();
        return Redirect::route('payment')->with('success', 'Payment  was successfully delete.');
    }

    public function edit(Payment $payment)
    {

        $paymasters  = User::role('paymaster')->get();
        return Inertia::render('Payment/Edit', [

            'payment' => [
                'id' => $payment->id,
                'paymaster_id' => $payment->paymaster_id,
                'member_id' => $payment->member_id,
                'amount' => $payment->amount,
                'date_enter' => $payment->date_enter,
                'gateway_id' => $payment->gateway_id,
                'gateway' => $payment->gateway_details,
            ],
            'paymasters'  => $paymasters,
            'gateways'  => Gateway::orderByName()->whereStatus(true)
                ->get()
                ->transform(function ($field) {
                    return [
                        'value' => $field->id,
                        'name' => $field->name,
                        'details' => $field->details,
                    ];
                }),
            'users' => User::orderByName()
                ->get()
                ->transform(function ($field) {
                    return [
                        'value' => $field->id,
                        'name' => $field->name,
                        'paymaster' => $field->paymaster_id,
                    ];
                }),
        ]);
    }

    public function update()
    {

        ValidateRequest::validate([
            'paymaster_id' => ['required', 'exists:users,id'],
            'member_id' => ['required', 'exists:users,id'],
            'date_enter' => ['required', 'date'],
            'amount' => ['required', 'numeric'],
            'gateway.value' => ['required', 'exists:gateways,id'],
            'gateway' => ['required']
        ]);

        $data = ValidateRequest::all();

        $pay = Payment::findorfail($data['id']);
        $pay->paymaster_id = $data['paymaster_id'];
        $pay->member_id = $data['member_id'];
        $pay->gateway_id = $data['gateway']['value'];
        $pay->gateway_details = $data['gateway'];
        $pay->date_enter = $data['date_enter'];
        $pay->amount = $data['amount'];
        $pay->save();

        // return Redirect::route('payment')->with('success', 'Payment was successfully created.');



        // $request = ValidateRequest::all();
        // $payment = payment::findorfail($request['id']);
        // $payment->update(
        //     ValidateRequest::validate([
        //         'name' => ['required', 'max:50'],
        //         'type' => ['required', 'max:50'],
        //         'status' => [],
        //         'details' => ['required'],
        //     ])
        // );
        return Redirect::route('payment.edit', $pay)->with('success', 'Payment was successfully updated.');
    }
}
