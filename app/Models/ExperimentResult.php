<?php

namespace App\Models;

use Database\Factories\ExperimentResultFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExperimentResult extends Model
{
    /** @use HasFactory<ExperimentResultFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'experiment_id',
        'observation',
        'conclusion',
        'score',
        'status',
        'completed_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function experiment(): BelongsTo
    {
        return $this->belongsTo(Experiment::class);
    }

    protected function casts(): array
    {
        return [
            'score' => 'decimal:2',
            'completed_at' => 'datetime',
        ];
    }
}
