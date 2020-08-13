<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
//import notification
use App\Notifications\AdminResetPasswordNotification;

class Admin extends Authenticatable
{
    use Notifiable;
    //set the model to work with admin guard
    protected $guard = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role',
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
     * Administrator Roles
     */
    private static $adminRoles = ['editor', 'admin', 'superadmin'];

     /** Set notification to restore admin passwords 
     * (ovverrides the defaults function set in vedors->laravel->illuminate->auth->passwords-> CanResetPasswords.php file)
     * Note: create this new notification to use it */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AdminResetPasswordNotification($token));
    }

    /**
     * Return admin roles
     */
    public static function adminRoles(){
        return self::$adminRoles;
    }
}
