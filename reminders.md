Fix Login Done
We need to fix error coming from server to be viewed inside out field
Modify our mixins for validation errors

return with success
Redirect::route('contacts')->with('success', 'Contact created.');
to use the flash
$page.flash.success
$page.flash

use this.$inertia.method for making api calls in the backend
use this.form for making forms
self.$inertia.post(this.route("login.attempt"), self.form);
csrf-token is not attach to axios or \$inertia when using this.route()
also this would cause an expiry 419 error with regards to ziggy composer package
to fix this you need to add this.route("login.attemp").url()
add the .url() method by chaining it

set the title in the layout using title props

use mostly on table index
added query string to be remember
use the middleware remember
if you'd like to visit a page without remembering the query strings, pass ?remember=no to disable this behviour for that visit.
to forget previously remembered query strings, simply pass ?remember=forget.

use name routes in laravel so we can use this.route(routename)

on appnavbar or appfooter
this.extension is useless check it later on

we can change the title using title props on the layouts

on left sidebar we can either use full qualified link or a route name in ziggy define in laravel web/api routes

we use the whole ziggy route with function instead of just paths so we can check route current

create a stats controller that return total_users subscription_total account_subscriptios etc.
for admin dashboar panel

Dont Use anymore bouncer instead use spatie permission again
https://laravel.com/docs/5.1/authorization#checking-abilities
https://github.com/drbyte/spatie-permissions-demo/blob/master/app/Policies/PostPolicy.php
https://laravel.com/docs/5.8/authorization#writing-policies
https://laravel.com/docs/5.1/authorization#controller-authorization
https://scotch.io/tutorials/user-authorization-in-laravel-54-with-spatie-laravel-permission
https://github.com/drbyte/spatie-permissions-demo/blob/master/app/Http/Controllers/PostsController.php
https://docs.spatie.be/laravel-permission/v2/basic-usage/role-permissions/

check if resource can still be used
publish ziggy config

create 3 types of dashboard for admin, paymaster and member
Instead of using \$inertia post/get etc for example api calls only
just used the vform is has the form helpers for making api calls
