<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Rules\MustMatchPassword;

class ProfileController extends Controller
{
    public function __construct()
    {
    }

    public function show()
    {
        $user = auth()->user();
        $this->authorize('edit_profile', $user);
        return Inertia::render('Profile', [
            'account' => $user
        ]);
    }

    /**
     * @param Request $request
     */
    public function update()
    {
        $user = auth()->user();

        $data = request()->validate([
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
            'password'              => ['nullable','required_with:old_password', 'confirmed', 'min:8'],
            'password_confirmation' => 'required_with:password'
        ]);
        $user->update($data);

        if (request()->has('password') && request()->has('password_confirmation')) {
            $user->password = $data['password'];
        }

        $user->save();

        return redirect()->route('profile.show');
    }
}
