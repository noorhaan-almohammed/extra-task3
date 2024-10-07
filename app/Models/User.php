<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];
    protected Const Is_Adimn = 1;
    protected Const Is_Editor = 2;
    protected Const Is_User = 3;
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
// 'role' => $this->roles->pluck('name'),

    protected $appends = ["role"];
    public function getRoleAttribute(){
        return  $this->roles->pluck('name');
    }
    public function roles(){
        return $this->belongsToMany(Role::class,'role_user')->withTimestamps();
    }

    public function books()
    {
        return $this->hasMany(Book::class, 'created_by');
    }
    public function userBooks()
    {
        return $this->hasMany(Book::class, 'borrwo_to');
    }
    public function hasRole($role)
    {
        return $this->roles->contains('name', $role);
    }
    public function hasAnyRole(array $roles)
    {
        return $this->roles->pluck('name')->intersect($roles)->isNotEmpty();
    }
    public function hasPermission($permission)
    {
        foreach ($this->roles as $role) {
            if ($role->permissions->contains('name', $permission)) {
                return true;
            }
        }
        return false;
    }
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
