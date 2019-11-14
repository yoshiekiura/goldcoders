<?php

namespace App\Http\Controllers;

use App\Models\Rank;
use Inertia\Inertia;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;
use App\Models\SubscriptionType\FixValue;
use Illuminate\Database\Eloquent\Builder;
use App\Models\SubscriptionType\Percentage;
use App\Models\SubscriptionType\Compounding;

class SubscriptionController extends Controller
{
    public function create()
    {
        $user      = Auth::user();
        $intervals = config('intervals');
        $ranks     = Rank::where('paymaster_id', $user->id)->orWhereNull('paymaster_id')->pluck('name');
        $plans     = array_keys(config('subtype'));
        return Inertia::render('Subscription/Create', [
            'intervals' => $intervals,
            'plans'     => $plans,
            'ranks'     => $ranks
        ]);
    }

    public function destroy()
    {
        //
    }

    public function edit()
    {
        //
    }

    /**
     * @return mixed
     */
    public function index()
    {
        // Use this query to get all subscriptions by type if it has Any
        $subscriptions = Subscription::whereHasMorph(
            'plan',
            [
                FixValue::class,
                Percentage::class,
                Compounding::class

// Ranking::class,
                // ProfitSharing::class
            ],
            function (Builder $query, $type) {
                if ('fix_value' === $type) {
                    $query->orWhere('content', 'like', 'foo%');
                }

                $query->where('active', true);
            }
        )->get();

        return $subscriptions;
    }

    // for testing
    public function threeIndex()
    {
        return Subscription::with('plan')
            ->get()
            ->loadMorph('plan', [
                Event::class => ['calendar'],
                Photo::class => ['tags'],
                Post::class  => ['author']
            ]);
    }

    // for testing
    public function toindex()
    {
        return Subscription::query()
            ->with(['plan' => function (MorphTo $morphTo) {
                $morphTo->morphWith([
                    // we can load here all the nested relationship that we will use
                    FixValue::class    => ['calendar'],
                    Percentage::class  => ['tags'],
                    Compounding::class => ['author']
                ]);
            }

            ])->get();
    }

    public function update()
    {
        //
    }
}
