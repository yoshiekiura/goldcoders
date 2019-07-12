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

set the title in the layout using title props

use mostly on table index
added query string to be remember
use the middleware remember
If you'd like to visit a page without remembering the query strings, pass ?remember=no to disable this behviour for that visit.
To forget previously remembered query strings, simply pass ?remember=forget.

use name routes in laravel so we can use this.route(routename)

on appnavbar or appfooter
this.extension is useless check it later on

we can change the title using title props on the layouts

on left sidebar we can either use full qualified link or a route name in ziggy define in laravel web/api routes

we use the whole ziggy route with function instead of just paths so we can check route current
