<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    /**
     * @var array
     */
    protected $appends = ['payouts', 'total_payout', 'total_referral_commission'];

    // we need to add field for locked in meaning cannot be activated or deactivated!
     protected $casts = [
        'locked_in'            => 'boolean'
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'subscriptions';

    /**
     * @return mixed
     */
    public function getCycle()
    {
        return $this->getCycleArray()[0];
    }

    public function getCycleArray()
    {
        $c = config("plan.{$this->plan}.cycle");
        return explode(' ', $c);
    }

    /**
     * @return mixed
     */
    public function getCycleUnit()
    {
        $cycle_unit = $this->getCycleArray()[1];

        switch ($cycle_unit) {
            case 'd':
                $cycle_unit = 'day';
                break;
            case 'y':
                $cycle_unit = 'year';
                break;
            default:
                $cycle_unit = 'day';
                break;
        }

        return $cycle_unit;
    }

    /**
     * @param  $interval
     * @return mixed
     */
    public function getDateActivatedValue($interval)
    {
        if ('year' === $this->getCycleUnit()) {
            $date = Carbon::parse($this->date_activated)->addYears($interval)->format('Y-m-d');
            return $date;
        } elseif ('day' === $this->getCycleUnit()) {
            $daysToAdd = $interval * $this->getCycle();
            $date      = Carbon::parse($this->date_activated)->addDays($daysToAdd)->format('Y-m-d');
            return $date;
        }
    }

    /**
     * @return mixed
     */
    public function getIntervals()
    {
        $combine = array_combine($this->getIntervalsArray(), $this->getPayoutsArray());
        return $combine;
    }

    public function getIntervalsArray()
    {
        $collection = collect(config("plan.{$this->plan}.intervals"));
        $array      = array_keys($collection->toArray());

        return $array;
    }

    public function getPayoutsArray()
    {
        $collection = collect(config("plan.{$this->plan}.intervals"));
        $array      = $collection->pluck($this->rank)->toArray();
        return $array;
    }

    /**
     * @param $plan
     * @param $rank
     */
    public function getPayoutsAttribute()
    {
        $array_intervals   = [];
        $count             = 0;
        $ten_percent_array = [0, 1];

        foreach ($this->getIntervals() as $interval => $payout) {
            $current_date = Carbon::now()->format('Y-m-d');

            if (is_int($interval)) {
                $payout_date = $this->getDateActivatedValue($interval);

// check first 2 interval before we insert it to the array

// for the rest of interval we give 5%
                if (in_array($count, $ten_percent_array)) {
                    $array_intervals[$interval] = [
                        'referral_commission' => $payout * .1,
                        'payout_date'         => $payout_date,
                        'payout_amount'       => $payout,
                        'paid'                => Carbon::parse($payout_date)->lte($current_date)

//? Use for Checking Debugging
                        // 'paid'                => true
                    ];
                } else {
                    $array_intervals[$interval] = [
                        'referral_commission' => $payout * .05,
                        'payout_date'         => $payout_date,
                        'payout_amount'       => $payout,
                        'paid'                => Carbon::parse($payout_date)->lte($current_date)

//? Use for Checking Debugging
                        // 'paid'                => true
                    ];
                }
            } else {
                $i     = explode('-', $interval);
                $range = range($i[0], $i[1]);

                foreach ($range as $interval) {
                    $payout_date = $this->getDateActivatedValue($interval);

// check first 2 interval before we insert it to the array we give 10% of payout

// for the rest of interval we give 5%
                    if (in_array($count, $ten_percent_array)) {
                        $array_intervals[$interval] = [
                            'referral_commission' => $payout * .1,
                            'payout_date'         => $payout_date,
                            'payout_amount'       => $payout,
                            'paid'                => Carbon::parse($payout_date)->lte($current_date)

//? Use for Checking Debugging
                            // 'paid'                => true
                        ];
                    } else {
                        $array_intervals[$interval] = [
                            'referral_commission' => $payout * .05,
                            'payout_date'         => $payout_date,
                            'payout_amount'       => $payout,
                            'paid'                => Carbon::parse($payout_date)->lte($current_date)

//? Use for Checking Debugging
                            // 'paid'                => true
                        ];
                    }
                }
            }

            $count++;
        }

        return $array_intervals;
    }

    /**
     * @return mixed
     */
    public function getTotalPayoutAttribute()
    {
        $collection = collect($this->getPayoutsAttribute());
        return $collection->sum(function ($item) {
            if ($item['paid']) {
                return $item['payout_amount'];
            }

            return 0;
        });
    }

    /**
     * @return int
     */
    public function getTotalReferralCommissionAttribute()
    {
        $collection = collect($this->getPayoutsAttribute());
        return $collection->sum(function ($item) {
            if ($item['paid']) {
                return $item['referral_commission'];
            }

            return 0;
        });
    }

    public static function last()
    {
        return self::latest()->first();
    }

    /**
     * [user Eloquent Relationship].
     *
     * @return [Collection] [Link Belongs To Relationship]
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
