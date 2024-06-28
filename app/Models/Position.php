<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Position extends Model
{
    use CrudTrait, HasFactory, HasUuids;

    protected $guarded = [];

    public function histories(): MorphMany
    {
        return $this->morphMany(History::class, 'historiable');
    }

    public function employee(): HasMany
    {
        return $this->hasMany(Employee::class);
    }

    public function organization() : BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
}
