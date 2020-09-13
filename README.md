
# Format Code

Package to format the Laravel php code in the style of WordPress.

### Requirements

- PHP 7.2+
- Laravel 5.5+

### Installation

**Composer**

Run the following to include this via Composer

```shell
composer require aodamuz/format-code
```

**Artisan Commands**

Scan specific directories and format all PHP files within.

```shell
php artisan format:scan vendor/symfony
```

Or many directories separated by commas.

```shell
php artisan format:scan vendor/symfony,app,config,tests
```

Format all files within the Laravel project. Default directories:
- app
- config
- database
- routes
- tests
- vendor/laravel

```shell
php artisan format:all
```

Format all specified PHP files.

```shell
php artisan format:file config/app.php
```
Or many files separated by commas.

```shell
php artisan format:file config/app.php,config/filesystems.php,app/Models/User.php
```

### Examples

Before formatting the user model.

```PHP
<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
```

Note that the code has the standard Laravel look and the indentation is with spaces.

### After

```PHP
<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {
	use HasFactory, Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'email', 'password',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'email_verified_at' => 'datetime',
	];
}
```

After formatting the file, the result would be a code with tabs, with class imports ordered by length and with the WordPress standard.

## License

Format Code is open-sourced software licensed under the [MIT license](LICENSE.md).
