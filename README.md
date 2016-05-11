# Permissions

Permissions and roles management for large PHP projects

## Getting Started

These instructions will get you a copy of the project up and running on your
local machine for development and testing purposes.

### Installing

The first steep is add this line to your composer.json

```
"repositories": [
 {
    "type": "vcs",
    "url": "https://github.com/ContemporaryVA/iTeam"
 }
]
```
and require the package:

```
"contemporaryva/iteam": "dev-master"
```

After that update composer.

Next step is register the service provider:
in *config/app.php* in the providers array:

```
\ITeam\Permissions\PermissionServiceProvider::class,
```
We need to specify he user and group entities in a configuration file. this file does not exists just yet
we need to publish the package configuration. To do so:

```
php artisan vendor:publish
```

After that, in the config folder, you will find a file called permissions.php
set the entity that will represent a user in the application. also set the group.
You must provide the fully qualified name of the classes, example:

**Namespace\ClassName::class**

You can also set the middlewares. To do that add something like this to the
$routeMiddleware  array in kernel.php file.

```
'person.role' => PersonHasRole::class,
'person.permission' => PersonHasPermission::class,
```
### Notes:
We are using convention over configuration so, we are  assuming that the entities that you plan to use
for your users and groups must have a primary key called ***id***.

## Using the code
### Models configuration
Both user and group models must implement these interfaces:

* CVA\Permissions\Contracts\IRoleable
* CVA\Permissions\Contracts\IPermissable

To satisfy the required method implementations use the next traits:

* CVA\Permissions\Contracts\IPermissable
* CVA\Permissions\Contracts\IRoleable
* CVA\Permissions\Traits\MorphedRelationableTrait

## Running the tests

To run the unit tests you must seed your User and Group models first.

then require phpunit, and you are done.