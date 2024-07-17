<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Venturecraft\Revisionable\RevisionableTrait;

class Employee extends Model
{
    use CrudTrait;
    use HasFactory;
    use HasUuids;
    use RevisionableTrait;

    protected $guarded = [];

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }
}
