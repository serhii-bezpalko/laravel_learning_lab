<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Author extends Model
{
    protected $fillable = [
        "surname",
        "name",
        "patronymic",
    ];
    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class);
    }
}
