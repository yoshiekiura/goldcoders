<?php

namespace App\Providers;

use App\Models\Role;
use Inertia\Inertia;
use App\Models\Permission;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Illuminate\Pagination\UrlWindow;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\LengthAwarePaginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Date::use (CarbonImmutable::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Inertia::version(function () {
            return md5_file(public_path('mix-manifest.json'));
        });

        Inertia::share(function () {
            $user        = Auth::user();
            $roles       = Role::all()->pluck('name')->toArray();
            $permissions = Permission::all()->pluck('name')->toArray();
            return [
                'app'         => [
                    'name' => Config::get('app.name')
                ],
                'roles'       => $roles,
                'permissions' => $permissions,
                'isLoggedIn'  => $user ? true : false,
                'auth'        => [
                    'user' => $user ? [
                        'id'                => $user->id,
                        'sponsor'           => $user->sponsor,
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
                        // 'email_verified_at' => $user->email_verified_at,
                        'roles'             => $user->role_list,
                        // 'permissions'       => $user->permission_list,
                        'can'               => $user->can
                    ] : null
                ],
                'flash'       => [
                    'success' => Session::get('success'),
                ],
                'errors'      => Session::get('errors') ? Session::get('errors')->getBag('default')->getMessages() : (object) []
            ];
        });
        $this->registerLengthAwarePaginator();
    }

    /**
     * @return mixed
     */
    protected function registerLengthAwarePaginator()
    {
        $this->app->bind(LengthAwarePaginator::class, function ($app, $values) {
            return new class(...array_values($values)) extends LengthAwarePaginator
            {
                /**
                 * @param  $attributes
                 * @return mixed
                 */
                public function only(...$attributes)
                {
                    return $this->transform(function ($item) use ($attributes) {
                        return $item->only($attributes);
                    });
                }

                /**
                 * @param  $callback
                 * @return mixed
                 */
                public function transform($callback)
                {
                    $this->items->transform($callback);

                    return $this;
                }

                public function toArray()
                {
                    return [
                        'data'  => $this->items->toArray(),
                        'links' => $this->links()
                    ];
                }

                /**
                 * @param $view
                 * @param array   $data
                 */
                public function links($view = null, $data = [])
                {
                    $this->appends(Request::all());

                    $window = UrlWindow::make($this);

                    $elements = array_filter([
                        $window['first'],
                        is_array($window['slider']) ? '...' : null,
                        $window['slider'],
                        is_array($window['last']) ? '...' : null,
                        $window['last']
                    ]);

                    return Collection::make($elements)->flatMap(function ($item) {
                        if (is_array($item)) {
                            return Collection::make($item)->map(function ($url, $page) {
                                return [
                                    'url'    => $url,
                                    'label'  => $page,
                                    'active' => $this->currentPage() === $page
                                ];
                            });
                        } else {
                            return [
                                [
                                    'url'    => null,
                                    'label'  => '...',
                                    'active' => false
                                ]
                            ];
                        }
                    })->prepend([
                        'url'    => $this->previousPageUrl(),
                        'label'  => 'Previous',
                        'active' => false
                    ])->push([
                        'url'    => $this->nextPageUrl(),
                        'label'  => 'Next',
                        'active' => false
                    ]);
                }
            };
        });
    }
}
