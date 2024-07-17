<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Venturecraft\Revisionable\RevisionableTrait;

class Position extends Model
{
    use CrudTrait;
    use HasFactory;
    use HasUuids;
    use RevisionableTrait;

    protected $guarded = [];

    public function histories(): MorphMany
    {
        return $this->morphMany(History::class, 'historiable');
    }

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }
}
