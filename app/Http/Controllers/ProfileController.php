<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Rules\MustMatchPassword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function __construct()
    {
    }

    public function show()
    {
        return Inertia::render('Profile', [
            'account' => Auth::user()
        ]);
    }

    /**
     * @param Request $request
     */
    public function update(Request $request)
    {
        $user = $request->user();
        $this->authorize('edit_profile', $user);
        $validator = Validator::make($request->all(), [
            'fname'                 => [
                'nullable'
            ],
            'lname'                 => [
                'nullable'
            ],
            'mname'                 => [
                'nullable'
            ],
            'suffix'                => [
                'nullable'
            ],
            'mobile_no'             => [
                'nullable'
            ],
            'dob'                   => [
                'nullable'
            ],
            'current_address'       => [
                'nullable'
            ],
            'permanent_address'     => [
                'nullable'
            ],
            'email'                 => [
                'nullable',
                'email',
                Rule::unique('users')->ignore($user->id)
            ],
            'username'              => [
                'sometimes',
                'required',
                Rule::unique('users')->ignore($user->id)
            ],
            'old_password'          => [
                'nullable',
                new MustMatchPassword($user->password)
            ],
            'password'              => ['nullable', 'required_with:old_password', 'confirmed', 'min:8'],
            'password_confirmation' => 'required_with:password'
        ]);

        if ($validator->fails()) {
            return Redirect::route('profile.show')->with('error', 'Profile Page Form Validation Failed!')->withErrors($validator);
        }

        $user->update($validator->valid());

        if ($request->has('password') && $request->has('password_confirmation')) {
            $user->password = $validator['password'];
        }

        $user->save();
        return Redirect::route('profile.show')->with('success', 'Profile Updated!');
    }
}
