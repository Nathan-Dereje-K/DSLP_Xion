<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentPrerequisite extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'content_prerequisites';

    /**
     * Define a BelongsTo relationship with the Content model (content item).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function content()
    {
        return $this->belongsTo(Content::class, 'content_id');
    }

    /**
     * Define a BelongsTo relationship with the Content model (prerequisite content).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function prerequisiteContent()
    {
        return $this->belongsTo(Content::class, 'prerequisite_content_id');
    }
}
