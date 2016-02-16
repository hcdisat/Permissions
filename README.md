# iTeam

# ​Installation:

#First Add:

```
"repositories": [
{
"type": "vcs",
"url": "https://github.com/ContemporaryVA/iTeam"
}
]
```
### to composer.json. then add

"contemporaryva/iteam": "1.0.1" under your required packages. Then update composer.

Dump the autoloader
composer dumpautoload -a


### Using the code:
Register the service provider: in config/app.php in the providers array:
```
\ITeam\Permissions\PermissionServiceProvider::class,
```

## publish the package's configuration and assets files.
```
php artisan vendor:publish
```
After that, in the config folder, you will find a file called permissions.php
set the entity that will represent a user in the application. also set the group.
You can also set the middlewares. To do that add something like this to the
$routeMiddleware  array  in the kernel.php .

```
'person.role' => PersonHasRole::class,
'person.permission' => PersonHasPermission::class,
```

and we finish basic configuration.


