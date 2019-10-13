<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Gateway;
use App\Models\Payout;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request as ValidateRequest;

class PayoutController extends Controller
{
    public function index()
    {

        return Inertia::render('Payout/Index', [
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

    public function create()
    {
        $paymasters  = User::role('paymaster')->get();
        return Inertia::render('Payout/Create', [
            'paymasters'  => $paymasters,
            'gateways'  => Gateway::orderByName()->whereActive(true)->ForPayout()
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

    public function store()
    {

        $data = ValidateRequest::all();
        ValidateRequest::validate([
            'paymaster_id' => ['required', 'exists:users,id'],
            'member_id' => ['required', 'exists:users,id'],
            'date_payout' => ['required', 'date'],
            'amount' => ['required', 'numeric'],
            'payout_details.value' => ['required', 'exists:gateways,id'],
            'payout_details' => ['required']
        ]);

        $pay = new Payout;
        $pay->paymaster_id = $data['paymaster_id'];
        $pay->member_id = $data['member_id'];
        $pay->gateway_id = $data['payout_details']['value'];
        $pay->payout_details = $data['payout_details'];
        $pay->date_payout = $data['date_payout'];
        $pay->amount = $data['amount'];
        $pay->save();

        $pay->clearMediaCollection('payouts');
        $pay->addAllMediaFromRequest()
            ->each(function ($fileAdder) {
                $fileAdder->toMediaCollection('payouts');
            });

        return Redirect::route('payout')->with('success', 'Payout was successfully created.');
    }

    public function delete(Request $request)
    {
        $payout = Payout::findorfail($request->id);
        $payout->delete();
        return Redirect::route('payout')->with('success', 'Payout  was successfully delete.');
    }

    public function edit(Payout $payout)
    {

        $media  = $payout->getMedia('payouts');
        $images = [];
        foreach ($media as $item) {
            array_push($images, $item->getFullUrl());
        }

        $paymasters  = User::role('paymaster')->get();
        return Inertia::render('Payout/Edit', [
            'documents' => $images,
            'payout' => [
                'id' => $payout->id,
                'paymaster_id' => $payout->paymaster_id,
                'member_id' => $payout->member_id,
                'amount' => $payout->amount,
                'date_payout' => $payout->date_payout,
                'gateway_id' => $payout->gateway_id,
                'payout_details' => $payout->payout_details,
            ],
            'paymasters'  => $paymasters,
            'gateways'  => Gateway::orderByName()->whereActive(true)
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



        $data = ValidateRequest::all();

        ValidateRequest::validate([
            'paymaster_id' => ['required', 'exists:users,id'],
            'member_id' => ['required', 'exists:users,id'],
            'date_payout' => ['required', 'date'],
            'amount' => ['required', 'numeric'],
            'payout_details.value' => ['required', 'exists:gateways,id'],
            'payout_details' => ['required']
        ]);

        $data = ValidateRequest::all();

        $pay = Payout::findorfail($data['id']);
        $pay->paymaster_id = $data['paymaster_id'];
        $pay->member_id = $data['member_id'];
        $pay->gateway_id = $data['payout_details']['value'];
        $pay->payout_details = $data['payout_details'];
        $pay->date_payout = $data['date_payout'];
        $pay->amount = $data['amount'];
        $pay->save();

        if ($data['images']) {
            $pay->clearMediaCollection('payouts');
            $pay->addAllMediaFromRequest()
                ->each(function ($fileAdder) {
                    $fileAdder->toMediaCollection('payouts');
                });
        }

        return Redirect::route('payout.edit', $pay)->with('success', 'Payout was successfully updated.');
    }
}
