<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Facades\Request;

class UsersController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int                         $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int                         $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('User/Index', [
            'filters'  => Request::all('sortBy', 'orderBy'),
            'contacts' => User::orderByName()
                ->filter(Request::only('sortBy', 'orderBy'))
                ->paginate()
                ->transform(function ($user) {
                    return [
                        'id'                => $user->id,
                        'email'             => $user->email,
                        'username'          => $user->username,
                        'photo_url'         => $user->photo_url,
                        'fname'             => $user->fname,
                        'mname'             => $user->mname,
                        'lname'             => $user->lname,
                        'suffix'            => $user->suffix,
                        'sponsor'           => $user->sponsor,
                        'avatar'            => $user->avatar,
                        'active'            => $user->active,
                        'dob'               => $user->dob,
                        'mobile_no'         => $user->mobile_no,
                        'permanent_address' => $user->permanent_address,
                        'current_address'   => $user->current_address,
                        'email_verified_at' => $user->email_verified_at,
                        'roles'             => $user->getroles(),
                        'abilities'         => $user->getabilities()
                    ];
                })
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int                         $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request    $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request    $request
     * @param  int                         $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }
}
