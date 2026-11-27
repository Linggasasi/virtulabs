<?php

namespace App\Models;

use Database\Factories\LaboratoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Laboratory extends Model
{
    /** @use HasFactory<LaboratoryFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
    ];

    public function materials(): HasMany
    {
        return $this->hasMany(Material::class);
    }

    public function experiments(): HasMany
    {
        return $this->hasMany(Experiment::class);
    }

    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }
}
