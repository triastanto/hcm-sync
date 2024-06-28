<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Unit extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $guarded = [];

    public function histories() : MorphMany
    {
        return $this->morphMany(History::class, 'historiable');
    }

    public function organization() : BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function parent() : BelongsTo
    {
        return $this->belongsTo(Unit::class, 'parent_id');
    }

    public function children() : HasMany
    {
        return $this->hasMany(Unit::class, 'parent_id');
    }
}
