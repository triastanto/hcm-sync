<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Position extends Model
{
    use CrudTrait;
    use HasFactory;

    public function histories() : MorphMany
    {
        return $this->morphMany(History::class, 'historiable');
    }
}
