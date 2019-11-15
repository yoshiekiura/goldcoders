composer require spatie/laravel-rate-limited-job-middleware
composer require envant/fireable

we will use this two new packages to fire an event that is queable
but also ratelimit the this jobs to avoid server overloading

we also need to use laravel horizon in tandem in this

composer require staudenmeir/laravel-adjacency-list:"^1.0"
We will use this for hierchical data

-   We will use this package for Building our User Tree

-ancestors(): The model's recursive parents.
-ancestorsAndSelf(): The model's recursive parents and itself.
-children(): The model's direct children.
-childrenAndSelf(): The model's direct children and itself.
-descendants(): The model's recursive children.
-descendantsAndSelf(): The model's recursive children and itself.
-parent(): The model's direct parent.
-parentAndSelf(): The model's direct parent and itself.
-siblings(): The parent's other children.
-siblingsAndSelf(): All the parent's children

composer require spatie/laravel-enum
use this package to easily query enum in our table
