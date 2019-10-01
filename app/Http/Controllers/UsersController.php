<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Inertia\Inertia;
use App\Mail\MassMail;
use App\Models\Permission;
use App\Models\Subscription;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use App\Exceptions\UpdatingRecordFailed;
use App\Exceptions\AccountCreationFailed;

class UsersController extends Controller
{
    /**
     * @param Request $request
     */
    public function create(Request $request)
    {
        $this->authorize('create', auth()->user());
        $roles       = Role::all()->pluck('name');
        $permissions = Permission::all()->pluck('name')->toArray();
        $sponsors    = User::get(['fname', 'mname', 'lname', 'id', 'username']);
        $paymasters  = User::role('paymaster')->get(['fname', 'mname', 'lname', 'id', 'username']);
        return Inertia::render('User/Create', [
            'roles'       => $roles,
            'permissions' => $permissions,
            'sponsors'    => $sponsors,
            'paymasters'  => $paymasters
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int                         $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->authorize('destroy', auth()->user());
        $deleted = false;

        if (!$user->isSuperAdmin()) {
            $deleted = $user->delete();

            if (!$deleted) {
                throw new UpdatingRecordFailed;
            } else {
                // remove all referrals
                User::where('sp_id', $user->id)->update(['sp_id' => null]);
                // Remove all subscriptions
                $subscriptions = Subscription::where('user_id', $user->id);
                // Remove All uploads inside subscriptions
                $image_urls = $subscriptions->pluck('image_url');

// // delete all uploads
                if (count($image_urls) > 0) {
                    Storage::delete($image_urls);
                }

                // remove all subscriptions
                $subscriptions->delete();
            }
        }

        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int                         $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('edit', auth()->user());
        $user        = User::findOrFail($id)->toArray();
        $roles       = Role::all()->pluck('name');
        $permissions = Permission::all()->pluck('name')->toArray();
        $sponsors    = User::where('id', '!=', $id)->get(['fname', 'mname', 'lname', 'id', 'username']);
        $paymasters  = User::role('paymaster')->get(['fname', 'mname', 'lname', 'id', 'username']);
        return Inertia::render('User/Edit', [
            'user'        => $user,
            'roles'       => $roles,
            'permissions' => $permissions,
            'sponsors'    => $sponsors,
            'paymasters'  => $paymasters
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('view', auth()->user());

        $per_page = 10;

        if (request()->per_page && is_int(intval(request()->per_page)) && request()->per_page > 0) {
            $per_page = intval(request()->per_page);
        }

        return Inertia::render('User/Index', [
            'filters' => Request::all('search', 'sponsor', 'role', 'status', 'page', 'per_page'),
            'users'   => User::orderByName()
                ->filter(Request::only('search', 'sponsor', 'role', 'status'))
                ->paginate($per_page)
                ->transform(function ($user) {
                    return [
                        'id'                => $user->id,
                        'email'             => $user->email,
                        'username'          => $user->username,
                        'name'              => $user->name,
                        'photo_url'         => $user->photo_url,
                        'fname'             => $user->fname,
                        'mname'             => $user->mname,
                        'lname'             => $user->lname,
                        'suffix'            => $user->suffix,
                        'sponsor'           => optional($user->sponsor)->name,
                        'avatar'            => $user->avatar,
                        'active'            => $user->active,
                        'dob'               => $user->dob,
                        'mobile_no'         => $user->mobile_no,
                        'permanent_address' => $user->permanent_address,
                        'current_address'   => $user->current_address,
                        'roles'             => $user->role_list
                    ];
                })
        ]);
    }

    /**
     * @param Request $request
     */
    public function massActivate()
    {
        $this->authorize('update', auth()->user());
        $ids     = $this->selectExceptSuperAdmin();
        $updated = User::whereIn('id', $ids)->update(['active' => true]);

        if (count($ids) !== $updated) {
            throw new UpdatingRecordFailed;
        }

        return redirect()->route('users.index');
    }

    /**
     * @param Request $request
     */
    public function massDeactivate(Request $request)
    {
        $this->authorize('update', auth()->user());
        $ids     = $this->selectExceptSuperAdmin();
        $updated = User::whereIn('id', $ids)->update(['active' => false]);

        if (count($ids) !== $updated) {
            throw new UpdatingRecordFailed;
        }

        return redirect()->route('users.index');
    }

    /**
     * @param Request $request
     */
    public function massDelete(Request $request)
    {
        $this->authorize('update', auth()->user());
        $ids = $this->selectExceptSuperAdmin();
        DB::beginTransaction();
        try {
            // get all users
            $users = User::whereIn('id', $ids);
            // remove all sponsorship
            User::whereIn('sp_id', $ids)->update(['sp_id' => null]);
            // get all subscriptions
            $subscriptions = Subscription::whereIn('user_id', $ids);
            // pluck image_url
            $image_urls = $subscriptions->pluck('image_url');
            // remove null value of image_url
            $image_urls = array_filter($image_urls->toArray());

            if (count($image_urls) > 0) {
                Storage::delete($image_urls);
            }

            // remove all subscriptions
            $subscriptions->delete();
            // remove all selected users
            $users->delete();
            // remove all uploads /files
        } catch (\Exception $e) {
            abort(404);
        }

        DB::commit();
        return redirect()->route('users.index');
    }

    /**
     * @param Request $request
     */
    public function massMail()
    {
        $this->authorize('sendmail', auth()->user());
        $data['subject']        = request()->input('subject');
        $data['message']        = request()->input('message');
        $data['with_panel']     = request()->input('with_panel');
        $data['panel_message']  = request()->input('panel_message');
        $data['with_button']    = request()->input('with_button');
        $data['button_url']     = request()->input('button_url');
        $data['button_color']   = request()->input('button_color'); // red, green, blue
        $data['button_message'] = request()->input('button_message');
        $data['signature']      = request()->input('signature');

        $user_ids = request()->input('user_ids');
        // Only Send Email To Seletec users with Email
        $users = User::whereIn('id', $user_ids)->where('email', '!=', null)->get();

        foreach ($users as $key => $user) {
            Mail::to($user)->queue(new MassMail($data, $user));
        }

        return response()->json(['message' => 'Sending Mail!'], 200);
    }

    /**
     * @param $id
     */
    public function referrals($user = null)
    {
        $user = User::with('sponsor')->find($user);
        //  Set Default User as Authenticated User
        $auth = request()->user()->load('sponsor');

        // add a logic to check if the user can view that id

        if (!$user) {
            $user = $auth;
        }

        $referrals = $user->referrals();

        $per_page = 10;

        if (request()->per_page && is_int(intval(request()->per_page)) && request()->per_page > 0) {
            $per_page = intval(request()->per_page);
        }

        return Inertia::render('User/Referrals', [
            'filters'  => Request::all('search', 'status', 'page', 'per_page', 'user'),
            'sponsor'  => $user,
            'per_page' => $per_page,
            'users'    => $referrals
                ->filter(Request::only('search', 'status'))
                ->paginate($per_page)
                ->transform(function ($user, $per_page) {
                    return [
                        'id'                => $user->id,
                        'email'             => $user->email,
                        'username'          => $user->username,
                        'name'              => $user->name,
                        'photo_url'         => $user->photo_url,
                        'fname'             => $user->fname,
                        'mname'             => $user->mname,
                        'lname'             => $user->lname,
                        'suffix'            => $user->suffix,
                        'avatar'            => $user->avatar,
                        'active'            => $user->active,
                        'dob'               => $user->dob,
                        'mobile_no'         => $user->mobile_no,
                        'permanent_address' => $user->permanent_address,
                        'current_address'   => $user->current_address,
                        'referral_count'    => $user->referrals()->count()
                    ];
                })
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', auth()->user());

        $data = request()->validate([
            'fname'                 => 'required',
            'sp_id'                 => 'nullable',
            'paymaster_id'          => 'nullable',
            'mname'                 => 'nullable',
            'lname'                 => 'required',
            'suffix'                => 'nullable',
            'mobile_no'             => 'nullable',
            'dob'                   => 'nullable',
            'username'              => 'nullable',
            'email'                 => 'nullable|email|unique:users',
            'password'              => 'required|min:6|confirmed',
            'password_confirmation' => 'required',
            'roles'                 => [
                'sometimes',
                'required',
                'exists:roles,name'
            ],
            'permissions'           => [
                'sometimes',
                'required',
                'exists:permissions,name'
            ],

            'active'                => 'boolean',
            'current_address'       => 'nullable',
            'permanent_address'     => 'nullable'
        ]);

        DB::beginTransaction();
        $user  = User::create($data);
        $roles = request('roles');
        $user->syncRoles($roles);

        if ($user->hasRole('member')) {
            $user->paymaster_id = $data['paymaster_id'];
        }

        try {
            if (!$user) {
                throw new AccountCreationFailed;
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 400); // Failed Creation
        }

        DB::commit();
        return redirect()->route('users.index');
    }

    public function toggleStatus()
    {
        $this->authorize('update', auth()->user());
        $user = User::find(Request::get('user_id'));

        if (!$user->isSuperAdmin()) {
            $user->active = !$user->active;
            $user->save();
        }

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request    $request
     * @param  int                         $id
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        //find user

        $user = User::findOrFail(request()->id);

        $this->authorize('update', $user);
        //update user
        $data = request()->validate([
            'id'                    => 'required',
            'sp_id'                 => 'nullable',
            'paymaster_id'          => 'nullable',
            'fname'                 => 'required',
            'username'              => [
                'required',
                Rule::unique('users')->ignore($user->id)
            ],
            'mname'                 => 'nullable',
            'lname'                 => 'required',
            'suffix'                => 'nullable',
            'mobile_no'             => 'nullable',
            'dob'                   => 'nullable',
            'email'                 => [
                'required',
                'nullable',
                Rule::unique('users')->ignore($user)
            ],
            'password'              => 'nullable|min:6|confirmed',
            'password_confirmation' => 'required_with:password',
            'roles'                 => [
                'sometimes',
                'required',
                'exists:roles,name'
            ],
            'permissions'           => [
                'sometimes',
                'required',
                'exists:permissions,name'
            ],
            'active'                => 'boolean',
            'current_address'       => 'nullable',
            'permanent_address'     => 'nullable'
        ]);

        $user->update($data);

        if ($data['password'] && $data['password_confirmation']) {
            $user->password = $data['password'];
        }

        $roles = $data['roles'];

        if ($user->isSuperAdmin()) {
            $user->active = true;
            $user->sp_id  = null;

            $admin_role = ['admin'];
            $mergeroles = array_unique(array_merge($roles, $admin_role));
            $user->syncRoles($mergeroles);
        } else {
            $user->active = $data['active'];
            $user->sp_id  = $data['sp_id'];
            $user->syncRoles($roles);
        }

        if ($user->hasRole('member')) {
            $user->paymaster_id = $data['paymaster_id'];
        }

        $user->save();

        return redirect()->route('users.index');
    }

    /**
     * @return mixed
     */
    private function selectExceptSuperAdmin()
    {
        $ids = request()->input('selected');

        $except = array_filter($ids, function ($id) {
            return optional(User::find($id))->isSuperAdmin();
        });

        if (count($except) > 0) {
            foreach ($except as $key => $value) {
                unset($ids[$key]);
            }
        }

        return $ids;
    }
}
