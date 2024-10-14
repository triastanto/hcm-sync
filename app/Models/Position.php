<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Venturecraft\Revisionable\RevisionableTrait;

class Position extends Model
{
    use CrudTrait;
    use HasFactory;
    use HasUuids;
    use RevisionableTrait;

    protected $guarded = [];

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function subgroup(): BelongsTo
    {
        return $this->belongsTo(Subgroup::class);
    }

    public static function findHeadOf($unit_id): Position
    {
        return self::where('unit_id', $unit_id)
            ->where('is_structural', true)
            ->first();
    }

    public function getHead(): Position
    {
        $head = static::findHeadOf($this->unit_id);

        // If the current position is the head the unit has no parent,
        // return the current position
        if ($head->id == $this->id && is_null($this->unit->parent)) {
            return $this;
        }

        // If the current position is the head but the unit has a parent,
        // return the head of the parent unit
        if ($head->id === $this->id) {
            return static::findHeadOf($this->unit->parent->id);
        }

        return $head;
    }

    public function getSubordinates(): Collection
    {
        return static::where('unit_id', $this->unit_id)
            ->where('is_structural', false)
            ->get();
    }
}
