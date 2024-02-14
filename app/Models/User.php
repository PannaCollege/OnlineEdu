<?php

namespace App\Models;

use App\Enums\UserType;
use Illuminate\Http\Request;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasUlids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'phone',
        'email',
        'username',
        'type',
        'password',
        'is_active',
        'google_id',
        'is_suspended',
        'suspended_by',
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
        'password' => 'hashed',
    ];

    /**
     * scopes
     */
    public function scopeActive($query, $isActive = true): Builder
    {
        return $query
            ->where('is_active', $isActive);
    }

    public function scopeSuspended($query, $isSuspended = true): Builder
    {
        return $query
            ->where('is_suspended', $isSuspended);
    }

    public function scopeFilter($query, Request $request): Builder
    {
        return $query
            ->when($request->query('search'), function ($query) use ($request) {
                $query
                    ->where('name', 'ilike', "%{$request->query('search')}%")
                    ->where('username', 'ilike', "%{$request->query('search')}%")
                    ->orWhere('email', 'ilike', "%{$request->query('search')}%")
                    ->orWhere('phone', 'ilike', "%{$request->query('search')}%");
            })
            ->when($request->filled('is_active'), fn ($query) => $query->active($request->boolean('is_active')))
            ->when($request->filled('is_suspended'), fn ($query) => $query->suspended($request->boolean('is_suspended')));
    }

    /**
     * relations
     */
    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    public function lessons(): HasManyThrough
    {
        return $this->hasManyThrough(
            Lesson::class,
            Course::class,
        );
    }

    public function suspendedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'suspended_by');
    }

    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    /**
     * get user name
     * 
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * get username
     * 
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * get user email
     * 
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * get user phone
     * 
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * get user type
     * 
     * @return string
     */
    public function getUserType(): string
    {
        return $this->type;
    }

    /**
     * get user is active or not
     * 
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->is_active;
    }

    /**
     * get user is suspended or not
     * 
     * @return bool
     */
    public function isSuspended(): bool
    {
        return $this->is_suspended;
    }

    /**
     * suspend / unsuspend to user
     * 
     * @param bool $isSuspended
     * @return void
     */
    public function makeSuspend($isSuspended = true): void
    {
        $this->is_suspended = $isSuspended;
        $this->suspended_by = $isSuspended ? auth()->id() : null;
        $this->save();
    }

    /**
     * create user register by google
     * 
     * @param $googleUser
     * @return User $user
     */
    public static function registerByGoogle($googleUser): User
    {
        $user = new User();
        $user->name = $googleUser->name;
        $user->email = $googleUser->email;
        $user->type = UserType::USER();
        $user->password = $googleUser->name;
        $user->google_id = $googleUser->id;
        $user->save();

        return $user;
    }
}
