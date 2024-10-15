<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Venturecraft\Revisionable\RevisionableTrait;

class Subgroup extends Model
{
    use CrudTrait;
    use HasFactory;
    use HasUuids;
    use RevisionableTrait;

    protected $guarded = [];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function positions(): HasMany
    {
        return $this->hasMany(Position::class);
    }

}
