<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Gateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request as ValidateRequest;

class GatewayController extends Controller
{
    public function index()
    {
        return Inertia::render('Gateway/Index', [
            'gateways' => Gateway::all()
                ->transform(function ($field) {
                    return [
                        'id' => $field->id,
                        'name' => $field->name,
                        'type' => $field->type,
                        'active' => $field->active,
                        'for_payout' => $field->for_payout
                    ];
                }),
        ]);
    }

    public function create()
    {
        return Inertia::render('Gateway/Create');
    }

    public function store()
    {
        $gateway = Gateway::create(
            ValidateRequest::validate([
                'name' => ['required', 'max:50'],
                'type' => ['required', 'max:50'],
                'active' => [],
                'for_payout' => [],
                'details' => ['required'],
            ])
        );
        return Redirect::route('gateway')->with('success', 'Gateway ' .  $gateway->name . ' was successfully created.');
    }

    public function delete(Request $request)
    {
        $gateway = Gateway::findorfail($request->id);
        $gateway->delete();
        return Redirect::route('gateway')->with('success', 'Gateway '  .  $gateway->name . ' was successfully delete.');
    }

    public function edit(Gateway $gateway)
    {

        return Inertia::render('Gateway/Edit', [
            'gateway' => [
                'id' => $gateway->id,
                'name' => $gateway->name,
                'type' => $gateway->type,
                'active' => $gateway->active,
                'for_payout' => $gateway->for_payout,
                'details' => $gateway->details,
            ]
        ]);
    }

    public function update()
    {
        $request = ValidateRequest::all();
        $gateway = gateway::findorfail($request['id']);
        $gateway->update(
            ValidateRequest::validate([
                'name' => ['required', 'max:50'],
                'type' => ['required', 'max:50'],
                'active' => [],
                'for_payout' => [],
                'details' => ['required'],
            ])
        );
        return Redirect::route('gateway.edit', $gateway)->with('success', 'Gateway ' .  $gateway->name . ' was successfully updated.');
    }
}
