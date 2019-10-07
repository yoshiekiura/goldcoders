Using \$inertia

```js
// import { Inertia } from '@inertiajs/inertia'

this.$inertia.visit(url, {
    method: "get",
    data: {},
    replace: false,
    preserveState: false,
    preserveScroll: false,
    only: []
});

this.$inertia.replace(url, {
    method: "get",
    data: {},
    preserveState: true,
    preserveScroll: false,
    only: []
});

this.$inertia.reload({
    method: "get",
    data: {},
    preserveState: false,
    preserveScroll: false,
    only: []
});

this.$inertia.post(url, data, {
    replace: false,
    preserveState: true,
    preserveScroll: false,
    only: []
});

this.$inertia.put(url, data, {
    replace: false,
    preserveState: true,
    preserveScroll: false,
    only: []
});

this.$inertia.patch(url, data, {
    replace: false,
    preserveState: true,
    preserveScroll: false,
    only: []
});

this.$inertia.delete(url, {
    replace: false,
    preserveState: false,
    preserveScroll: false,
    only: []
});
```

Returning an Inertia Response With Validation Error

```php
// check if validation fails
if ($validator->fails()) {
            return Redirect::route('profile.show')->with('error', 'Profile Page Form Validation Failed!')->withErrors($validator);
        }
// to get the validation data
$data = $validator->valid()
```

Flashing Session Messages such as error, success, info, warning

```php
->with('success', 'Profile Updated!');
```

Using Pagination (Move this logic on Base Controller)

-   set a \$per_page default value
-   return filters (per_page , page)
-   add to filters method (per_page , page)
-   add v-pagination on component

```html
<v-pagination
    v-if="users.meta.visible"
    v-model="form.page"
    :length="users.meta.total_pages"
    :total-visible="10"
/>
<v-text-field
    v-model.number="form.per_page"
    label="Items per page"
    type="number"
    min="-1"
    max="15"
></v-text-field>
// add this props on v-data-table
<v-data-table
    :page.sync="form.page"
    :server-items-length="users.meta.total_pages"
    :items-per-page="-1"
></v-data-table>
```

-   add component on create

```js
self.form.page = parseInt(self.users.meta.page);
self.form.per_page = parseInt(self.users.meta.per_page);
```

-   add Watcher on component for per_page and page

```js
"form.per_page"() {
      this.form.page = 1;
      this.debouncedGetUsers();
    },
    "form.sponsor"() {
      this.form.page = 1;
      this.debouncedGetUsers();
    },
    "form.page"(newVal) {
      if (this.form.page !== 1) {
        this.debouncedGetUsers();
      }
```
