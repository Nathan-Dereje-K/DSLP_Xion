<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
        'first_name',
        'last_name',
        'profile_picture',
        'bio',
        'location',
        'interests',
        'account_type', // Assuming different account types (e.g., student, instructor)
        'email_verified_at',
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Define relationships based on your application's needs

    /**
     * Define a HasMany relationship with the Purchase model (user's purchases).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function purchases()
    {
        return $this->hasMany(Purchase::class, 'user_id');
    }

    /**
     * Define a HasMany relationship with the UserEnrollment model (courses the user is enrolled in).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function enrollments()
    {
        return $this->hasMany(UserEnrollment::class, 'user_id');
    }

    /**
     * Define a HasMany relationship with the UserProgress model (user's progress on content).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function progress()
    {
        return $this->hasMany(UserProgress::class, 'user_id');
    }

    /**
     * Define a HasMany relationship with the UserReview model (reviews written by the user).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reviews()
    {
        return $this->hasMany(UserReview::class, 'user_id');
    }

    /**
     * Define a HasMany relationship with the Wishlist model (user's wishlist).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function wishlist()
    {
        return $this->hasMany(Wishlist::class, 'user_id');
    }

    // Define a HasMany relationship with the Content model (if users can create content).
    // public function content() {
    //     return $this->hasMany(Content::class, 'instructor_id');
    // }
}
