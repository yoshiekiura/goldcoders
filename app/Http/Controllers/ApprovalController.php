<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Payout;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ApprovalController extends Controller
{
    public function index()
    {
        return Inertia::render('Approval/Index');
    }
    public function payout()
    {
        return Inertia::render('Approval/Payout/Index', [
            'payouts' => Payout::with('paymaster', 'member')->UnverifiedPayouts()->get()
                ->transform(function ($field) {
                    return [
                        'id' => $field->id,
                        'paymaster_id' => $field->paymaster->id,
                        'paymaster_name' => $field->paymaster->name,

                        'member_id' => $field->member->id,
                        'member_name' => $field->member->name,

                        'amount' => $field->amount,
                        'date_payout' => $field->date_payout,
                        'approved' => $field->approved,
                    ];
                }),
        ]);
    }
    public function payout_approved(Payout $payout)
    {
        $payout = Payout::findorfail($payout->id);
        $payout->approved = true;
        $payout->date_approved = now();
        $payout->save();
        return Redirect::route('approval.payout')->with('success', 'Payout was successfully approved.');
    }

    public function payment()
    {

        return Inertia::render('Approval/Payment/Index', [
            'items' => Payment::with('paymaster', 'member')->UnverifiedPayment()->get()
                ->transform(function ($field) {
                    return [
                        'id' => $field->id,
                        'paymaster_id' => $field->paymaster->id,
                        'paymaster_name' => $field->paymaster->name,

                        'member_id' => $field->member->id,
                        'member_name' => $field->member->name,

                        'amount' => $field->amount,
                        'date_paid' => $field->date_paid,
                        'approved' => $field->approved,
                    ];
                }),
        ]);
    }

    public function payment_approved(Payment $payment)
    {
        $payment = Payment::findorfail($payment->id);
        $payment->approved = true;
        $payment->date_approved = now();
        $payment->save();
        return Redirect::route('approval.payment')->with('success', 'Payment was successfully approved.');
    }





}
