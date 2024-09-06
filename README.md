# Nijwel User Roles

`nijwel/user-roles` is a Laravel package for managing user roles and permissions with ease. It provides a simple interface to manage user roles and permissions, integrating seamlessly with Laravel's authentication system.

You can visit github repository - https://github.com/nijwel/user_roles.git
## Features

- **Role Management**: Create, update, and delete user roles.
- **Permission Management**: Assign and manage permissions for roles.
- **Integration with Laravel Auth**: Works with Laravel's built-in authentication system.
- **Flexible Configuration**: Customize role and permission settings.

## Installation

### Via Composer

Install the package via Composer:

```bash
composer require nijwel/user-roles
```

### Migration
```bash
php artisan migrate
```

### Publish Configuration (If Applicable)
If the package includes configuration files, publish them using:

```bash
php artisan vendor:publish --provider="Nijwel\UserRoles\UserRoleServiceProvider"
```

<b>Note:</b> If you receive the message "No publishable resources for tag []", it indicates there are no additional configuration files to publish. Please refer to the package documentation for further instructions.

### Configuration
Add the service provider to the providers array in your `config/app.php` file:

```bash
'providers' => [
    // Other service providers...
    Nijwel\UserRoles\UserRolesServiceProvider::class,
],
```
# Usage
<b>Creating Roles</b>
You can create roles using the Role model provided by the package:

Now you can insert the side-ber menu name or top-bar menu name into permissions table

<b>Example</b> : student , subcategories , products , accounts etc

Role name is input and permissions is checkbox array. you can handle from same form and post request


<b>#Your Controller</b>

    use Nijwel\UserRoles\Services\UserRoleService;

    protected $UserRoleService;

    public function __construct(UserRoleService $UserRoleService)
    {
        $this->UserRoleService = $UserRoleService;
    }

<b>#Get all role</b> 

    UserRoleService::getAllRole();

<b>#Get singe role</b>

    UserRoleService::getRole($id);

<b>#Store role</b>

    UserRoleService::createRole($request->all());


<b>#Update role</b>

    UserRoleService::updateRole($request->all(), $id);

<b>#delete role</b>

    UserRoleService::destroyRole($id);






<b>Get all permission list.</b>

<b>NB: </b>permission means your side bar name

    UserRoleService::getAllPermission();

<b>#Get single permission</b>

    UserRoleService::getPermission($id);

<b>#Store permissions</b>

    UserRoleService::createPermission($request->all());


<b>#Update permissions</b>

    UserRoleService::updatePermission($request->all(), $id);

<b>#delete permissions</b>

    UserRoleService::destroyPermission($id);




<b>#Get All role with permission</b>

<b>NB: </b> You can handle with one form

    UserRoleService::getAllRoleWithPermission();

<b>#Get single role with permission</b>

    UserRoleService::getRoleWithPermission($id);

<b>#Store role with permission [ This is the array data for role and permission ]</b>
    
    //Permissions is array value ;
    UserRoleService::createRoleWithPermission($request->all());

<b>#Update role with permission [Array]</b>

    //Permissions is array value ;
    UserRoleService::updateRoleWithPermission($request->all(), $id);

<b>#delete role with permission</b>

    UserRoleService::destroyRoleWithPermission($id);



### For blade file
```bash
@if (isPermission('Employee'))
    <li class="nav-item text-danger">
        <a class="nav-link"
            href="{{ route('index.employee') }}">Employee</a>
    </li>
@endif
@if (isPermission('Manager'))
    <li class="nav-item text-danger">
        <a class="nav-link" href="{{ route('index.manager') }}">Manager</a>
    </li>
@endif
```

## Use the Middleware in a Laravel Application
Once the package is installed in a Laravel application, you can use the middleware in routes or controllers.

### Using Middleware in Routes:
You can apply the middleware to routes like this:

```bash
// routes/web.php

Route::get('/admin', function () {
    // Only users with the 'admin' role can access this route
})->middleware('permission:your-permission');
```

### Using Middleware in Controllers:
You can also apply the middleware in a controller:
```bash

// app/Http/Controllers/AdminController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:your-permission');
    }

    public function index()
    {
        // Your logic here
    }
}
```



