<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContentCategory extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'content_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'parent_category_id',
    ];

    /**
     * Define a BelongsTo relationship with the parent ContentCategory model (if applicable).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(ContentCategory::class, 'parent_category_id');
    }

    /**
     * Define a HasMany relationship with the Content model (if applicable).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function content()
    {
        return $this->hasMany(Content::class, 'category_id');
    }
}
