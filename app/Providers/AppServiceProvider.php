<?php

namespace App\Providers;

use App\Models\Role;
use Inertia\Inertia;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Config;
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
        Inertia::share([
            // Synchronously
            'app'    => [
                'name' => Config::get('app.name')
            ],
            // Lazily
            'auth'   => function () {
                $user = Auth::user();
                return [
                    'isLoggedIn' => $user ? true : false,
                    'user'       => $user ? [
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
                        'email_verified_at' => $user->email_verified_at,
                        'roles'             => $user->role_list,
                        'can'               => $user->can
                    ] : null
                ];
            },
            'roles'  => function () {
                return Role::all()->pluck('name')->toArray();
            },
            'flash'  => [
                'success' => function () {
                    return Session::get('success');
                },
                'warning' => function () {
                    return Session::get('warning');
                },
                'error'   => function () {
                    return Session::get('error');
                },
                'info'    => function () {
                    return Session::get('info');
                }

            ],
            'errors' => function () {
                return Session::get('errors') ? Session::get('errors')->getBag('default')->getMessages() : (object) [];
            }

        ]);

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
                    $total_pages     = ceil($this->total() / $this->perPage());
                    $show_pagination = false;

                    if ($total_pages > 1) {
                        $show_pagination = true;
                    }

                    return [
                        'data' => $this->items->toArray(),
                        'meta' => [
                            'page'        => $this->currentPage(),
                            'total_pages' => $total_pages,
                            'per_page'    => $this->perPage(),
                            'visible'     => $show_pagination
                        ]
                    ];
                }
            };
        });
    }
}
