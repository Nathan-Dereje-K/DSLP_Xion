<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'content';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'category_id',
        'content_type',
        'content_data',
        'is_premium',
        'price',
        'duration',
        'level',
        'instructor_id',
    ];

    /**
     * Define a BelongsTo relationship with the ContentCategory model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(ContentCategory::class, 'category_id');
    }

    /**
     * Define a BelongsTo relationship with the User model (instructor).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    // Consider adding relationships with UserReview and UserProgress models (if applicable)
}
