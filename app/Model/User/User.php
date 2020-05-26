<?php namespace App\Model\User;

use App\Model\ModelHasRole;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
class User extends Authenticatable
{
    // use SoftDeletes;
    use Notifiable;

    use HasRoles;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'status', 'thumbnail', 'thumbnail', 'is_admin', 'phone', 'user_type'
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

    public function isAdmin() {
        return $this->is_admin ? true : false;
    }

    public function staff() {
        return $this->hasOne('App\Model\Staff\Staff', 'user_id', 'id');
    }

    public function customer() {
        return $this->hasOne('App\Model\Customer\Customer');
    }

    public function user_has_role()
    {
        return $this->hasMany(ModelHasRole::class, "model_id", "id");
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = \Hash::make($value);
    }

    public function isAdministrator() {
        if($this->hasRole('administrator')) {
            return true;
        }
        return false;
    }

    public function isCollector() {
        $role = $this->roles()->where('role_type', 'collector')->first();
        if($role) {
            return true;
        }
        return false;
    }

    public function isOffice() {
        $role = $this->roles()->where('role_type', 'office')->first();
        if($role) {
            return true;
        }
        return false;
    }

    public function isSale() {
        $role = $this->roles()->where('role_type', 'sale')->first();
        if($role) {
            return true;
        }
        return false;
    }

    public function isAgent() {
        $role = $this->roles()->where('role_type', 'agent')->first();
        if($role) {
            return true;
        }
        return false;
    }
}