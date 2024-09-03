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

Now you can insert the sideber menu name or topbar menu name into permissions table

<b>Example</b> : student , subcategories , products , accounts etc

Role name is input and permissions is checkbox array. you can handle from same form and post request


<b>#Controller</b>
```bash
// Your Controller
use Nijwel\UserRoles\Models\Permission;
use Nijwel\UserRoles\Controllers\RoleController as NijwelRoleController;
use Nijwel\UserRoles\Models\Role;
```

<b>#Controller store method</b>
```bash
//For store
public function store(Request $request)
{
    // Pass the request data
    $this->NijwelRoleController->store($request);
}
```

<b>#Controller update method</b>
```bash
//For update
public function update(Request $request, $id)
{
    $this->NijwelRoleController->update($request, $id);
}
```

<b>#Controller destroy method</b>
```bash
public function destroy($id)
{
    $this->NijwelRoleController->destroy($id);
}
```

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



