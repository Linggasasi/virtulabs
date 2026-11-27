<?php

namespace App\Models;

use Database\Factories\ExperimentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Experiment extends Model
{
    /** @use HasFactory<ExperimentFactory> */
    use HasFactory;

    protected $fillable = [
        'laboratory_id',
        'material_id',
        'title',
        'description',
        'objectives',
        'instructions',
        'simulation_type',
    ];

    public function laboratory(): BelongsTo
    {
        return $this->belongsTo(Laboratory::class);
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }

    public function results(): HasMany
    {
        return $this->hasMany(ExperimentResult::class);
    }
}
