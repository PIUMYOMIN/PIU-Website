<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Notifications\ResetPasswordNotification;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'password',
        'city',
        'country',
        'bio',
        'picture',
    ];

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

    /**
     * Get the user's primary role.
     * This accessor makes $user->role work.
     */
    public function getRoleAttribute()
    {
        return $this->roles->first()?->name;
    }

    /**
     * Append role to array and JSON output.
     */
    protected $appends = ['role'];

    /**
     * Eager load roles by default.
     */
    protected $with = ['roles'];

    public function isAdmin()
    {
        return $this->hasRole('admin|registrar');
    }

    /**
     * Which staff portal area this user should land on after login or
     * on session restore. Single source of truth used by both
     * AuthController (login/register) and UserController (profile),
     * so the frontend always gets the same answer regardless of which
     * endpoint it called.
     *
     * Roles seeded but not wired into any route/controller permission
     * check — currently "manager" and "staff" — are treated as
     * legacy/unused: the account authenticates fine but has no
     * dashboard, same as a plain "user" account.
     */
    public function portalArea(): string
    {
        if ($this->hasRole('admin')) {
            return 'admin';
        }
        if ($this->hasRole('registrar')) {
            return 'registrar';
        }
        if ($this->hasRole('teacher')) {
            return 'teacher';
        }

        return 'none';
    }

    /**
     * Human-readable reason for a 'none' portal area, so the frontend
     * can show the right message instead of a silent dead end. Null
     * when the user does have a portal area.
     */
    public function noAccessReason(): ?string
    {
        if ($this->portalArea() !== 'none') {
            return null;
        }

        $unmappedRoles = $this->getRoleNames()
            ->intersect(['manager', 'staff'])
            ->values();

        if ($unmappedRoles->isNotEmpty()) {
            return 'Your account role (' . $unmappedRoles->implode(', ') . ') is not yet assigned to a dashboard. Please contact an administrator.';
        }

        return 'Your account does not have access to a staff dashboard.';
    }

    /**
     * Send the password reset notification email with a custom template.
     */
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}