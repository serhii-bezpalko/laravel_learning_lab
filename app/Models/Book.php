<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Book extends Model
{
    protected $fillable = [
        "title",
        "description",
        "cover",
    ];
    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class);
    }
}
