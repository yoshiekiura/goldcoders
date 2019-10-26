<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Payout;
use App\Models\Payment;
use App\Models\UserFileManager;
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
            'payouts' => Payout::with('paymaster', 'member')->get()
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
    private function payout_update($id, $status)
    {
        $payout = Payout::findorfail($id);
        $payout->approved = $status;
        $payout->date_approved = now();
        $payout->save();
    }
    public function payout_approved(Payout $payout)
    {
        $this->authorize('view_approval_payout_approved');
        $this->payout_update($payout->id, true);
        return redirect()->back();
    }
    public function payout_disapproved(Payout $payout)
    {
        $this->authorize('view_approval_payout_disapproved');
        $this->payout_update($payout->id, false);
        return redirect()->back();
    }

    public function payment()
    {
        return Inertia::render('Approval/Payment/Index', [
            'items' => Payment::with('paymaster', 'member')->get()
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

    private function payment_update($id , $status)
    {
        $payment = Payment::findorfail($id);
        $payment->approved = $status;
        $payment->date_approved = now();
        $payment->save();
    }
    public function payment_approved(Payment $payment)
    {
        $this->authorize('view_approval_payment_approved');
        $this->payment_update($payment->id, true);
        return redirect()->back();
    }
    public function payment_disapproved(Payment $payment)
    {
        $this->authorize('view_approval_payment_disapproved');
        $this->payment_update($payment->id, false);
        return redirect()->back();
    }

    public function user_file()
    {
        return Inertia::render('Approval/UserFile/Index', [
            'files' => UserFileManager::with('member', 'file')
                ->get()
                ->transform(function ($field) {
                    return [
                        'id'             => $field->id,
                        'member'         => $field->member->name,
                        'title'          => $field->file->title,
                        'date_submitted' => $field->date_submitted,
                        'approved'       => $field->approved,
                        'date_approved'  => $field->date_approved
                    ];
                })
        ]);
    }
    private function user_file_update($id, $status)
    {
        $data = UserFileManager::findorfail($id);
        $data->approved = $status;
        $data->date_approved = now();
        $data->save();
    }
    public function user_file_approved(UserFileManager $file)
    {
        $this->authorize('view_approval_userfile_approved');
        $this->user_file_update($file->id, true);
        return redirect()->back();
    }
    public function user_file_disapproved(UserFileManager $file)
    {
        $this->authorize('view_approval_userfile_disapproved');
        $this->user_file_update($file->id, false);
        return redirect()->back();
    }
}
