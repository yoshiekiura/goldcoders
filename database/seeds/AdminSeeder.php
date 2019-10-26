<?php
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Subscription;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $user = User::create([
            'id'                => 1,
            'email'             => config('admin.email'),
            'password'          => config('admin.password'),
            'username'          => config('admin.username'),
            'active'            => true,
            'remember_token'    => Str::random(10),
            'mobile_no'         => $faker->isbn10,
            'current_address'   => $faker->streetAddress,
            'permanent_address' => $faker->secondaryAddress,
            'fname'             => config('admin.fname'),
            'mname'             => null,
            'lname'             => config('admin.lname'),
            'dob'               => Carbon::now()->subYears(random_int(18, 25))->subMonths(random_int(1, 12))->subDays(1, 31),
            'suffix'            => null
        ]);
        $user->assignRole('admin', 'paymaster');
        $subscriptions = factory(Subscription::class, 10)->create();
        $user->subscriptions()->saveMany($subscriptions);
        $user->save();

        $user = User::create([
            'id'                => 2,
            'paymaster_id'      => 1,
            'email'             => 'a@yahoo.com',
            'password'          => config('admin.password'),
            'username'          => 'ayahoocom',
            'active'            => true,
            'remember_token'    => Str::random(10),
            'mobile_no'         => $faker->isbn10,
            'current_address'   => $faker->streetAddress,
            'permanent_address' => $faker->secondaryAddress,
            'fname'             => 'first',
            'mname'             => null,
            'lname'             => 'last',
            'dob'               => Carbon::now()->subYears(random_int(18, 25))->subMonths(random_int(1, 12))->subDays(1, 31),
            'suffix'            => null
        ]);
        $user->assignRole('member');
        $subscriptions = factory(Subscription::class, 10)->create();
        $user->subscriptions()->saveMany($subscriptions);
        $user->save();




    }
}
