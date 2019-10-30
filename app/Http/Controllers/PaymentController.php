<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Gateway;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request as ValidateRequest;

class PaymentController extends Controller
{
    public function create()
    {
        $this->authorize('create_payment');

        $paymasters = User::role('paymaster')->get();
        return Inertia::render('Payment/Create', [
            'paymasters' => $paymasters,
            'gateways'   => Gateway::orderByName()
                ->whereActive(true)->notPayout()
                ->get()
                ->transform(function ($field) {
                    return [
                        'value'   => $field->id,
                        'name'    => $field->name,
                        'details' => $field->details
                    ];
                }),
            'users'      => User::orderByName()
                ->get()
                ->transform(function ($field) {
                    return [
                        'value'     => $field->id,
                        'name'      => $field->name,
                        'paymaster' => $field->paymaster_id
                    ];
                })
        ]);
    }

    /**
     * @param Request $request
     */
    public function delete(Request $request)
    {
        $this->authorize('delete_payment');

        $payment = Payment::findorfail($request->id);
        $payment->delete();
        return Redirect::route('payment')->with('success', 'Payment  was successfully delete.');
    }

    /**
     * @param Payment $payment
     */
    public function edit(Payment $payment)
    {
        // $this->authorize('view_own_payment', $payment);

        $media  = $payment->getMedia('payments');
        $images = [];

        foreach ($media as $item) {
            array_push($images, $item->getFullUrl());
        }

        $paymasters = User::role('paymaster')->get();
        return Inertia::render('Payment/Edit', [
            'documents'  => $images,
            'payment'    => [
                'id'              => $payment->id,
                'paymaster_id'    => $payment->paymaster_id,
                'member_id'       => $payment->member_id,
                'amount'          => $payment->amount,
                'date_paid'       => $payment->date_paid,
                'gateway_id'      => $payment->gateway_id,
                'payment_details' => $payment->payment_details
            ],
            'paymasters' => $paymasters,
            'gateways'   => Gateway::orderByName()
                ->whereActive(true)->notPayout()
                ->get()
                ->transform(function ($field) {
                    return [
                        'value'   => $field->id,
                        'name'    => $field->name,
                        'details' => $field->details
                    ];
                }),
            'users'      => User::orderByName()
                ->get()
                ->transform(function ($field) {
                    return [
                        'value'     => $field->id,
                        'name'      => $field->name,
                        'paymaster' => $field->paymaster_id
                    ];
                })
        ]);
    }

    /**
     * @param User $user
     */
    public function getPaymasterMembers(User $user)
    {
        return UserResource::collection(User::where('paymaster_id', $user->id)->get());
    }

    public function index()
    {
        $this->authorize('view_payments');

        return Inertia::render('Payment/Index', [
            'payments' => Payment::with('paymaster', 'member')
                ->get()
                ->transform(function ($field) {
                    return [
                        'id'             => $field->id,
                        'paymaster_id'   => $field->paymaster->id,
                        'paymaster_name' => $field->paymaster->name,

                        'member_id'      => $field->member->id,
                        'member_name'    => $field->member->name,

                        'amount'         => $field->amount,
                        'date_paid'      => $field->date_paid,
                        'approved'       => $field->approved
                    ];
                })
        ]);
    }

    public function store()
    {
        $data = ValidateRequest::all();
        ValidateRequest::validate([
            'paymaster_id'          => ['required', 'exists:users,id'],
            'member_id'             => ['required', 'exists:users,id'],
            'date_paid'             => ['required', 'date'],
            'amount'                => ['required', 'numeric'],
            'payment_details.value' => ['required', 'exists:gateways,id'],
            'payment_details'       => ['required']
        ]);

        $pay                  = new Payment;
        $pay->paymaster_id    = $data['paymaster_id'];
        $pay->member_id       = $data['member_id'];
        $pay->gateway_id      = $data['payment_details']['value'];
        $pay->payment_details = $data['payment_details'];
        $pay->date_paid       = $data['date_paid'];
        $pay->amount          = $data['amount'];
        $pay->save();

        $pay->clearMediaCollection('payments');
        $pay->addAllMediaFromRequest()
            ->each(function ($fileAdder) {
                $fileAdder->toMediaCollection('payments');
            });

        return Redirect::route('payment')->with('success', 'Payment was successfully created.');
    }

    public function update()
    {
        ValidateRequest::validate([
            'paymaster_id'          => ['required', 'exists:users,id'],
            'member_id'             => ['required', 'exists:users,id'],
            'date_paid'             => ['required', 'date'],
            'amount'                => ['required', 'numeric'],
            'payment_details.value' => ['required', 'exists:gateways,id'],
            'payment_details'       => ['required']
        ]);

        $data = ValidateRequest::all();

        $pay                  = Payment::findorfail($data['id']);
        $pay->paymaster_id    = $data['paymaster_id'];
        $pay->member_id       = $data['member_id'];
        $pay->gateway_id      = $data['payment_details']['value'];
        $pay->payment_details = $data['payment_details'];
        $pay->date_paid       = $data['date_paid'];
        $pay->amount          = $data['amount'];
        $pay->save();

        if ($data['images']) {
            $pay->clearMediaCollection('payments');
            $pay->addAllMediaFromRequest()
                ->each(function ($fileAdder) {
                    $fileAdder->toMediaCollection('payments');
                });
        }

        return Redirect::route('payment.edit', $pay)->with('success', 'Payment was successfully updated.');
    }

    /**
     * @param Payment $payment
     */
    public function view(Payment $payment)
    {
        $media  = $payment->getMedia('payments');
        $images = [];

        foreach ($media as $item) {
            array_push($images, $item->getFullUrl());
        }

        $paymasters = User::role('paymaster')->get();
        return Inertia::render('Payment/View', [
            'documents'  => $images,
            'payment'    => [
                'id'              => $payment->id,
                'paymaster_id'    => $payment->paymaster_id,
                'member_id'       => $payment->member_id,
                'amount'          => $payment->amount,
                'date_paid'       => $payment->date_paid,
                'date_approved'   => $payment->date_approved,
                'gateway_id'      => $payment->gateway_id,
                'payment_details' => $payment->payment_details
            ],
            'paymasters' => $paymasters,
            'gateways'   => Gateway::orderByName()
                ->whereActive(true)->notPayout()
                ->get()
                ->transform(function ($field) {
                    return [
                        'value'   => $field->id,
                        'name'    => $field->name,
                        'details' => $field->details
                    ];
                }),
            'users'      => User::orderByName()
                ->get()
                ->transform(function ($field) {
                    return [
                        'value'     => $field->id,
                        'name'      => $field->name,
                        'paymaster' => $field->paymaster_id
                    ];
                })
        ]);
    }
}
