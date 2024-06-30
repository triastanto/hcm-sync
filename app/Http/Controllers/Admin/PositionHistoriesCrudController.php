<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\HistoryCrudController;
use App\Models\Position;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Route;

class PositionHistoriesCrudController extends HistoryCrudController
{
    private int $position;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        parent::setup();

        // get the position parameter
        $this->position = Route::current()->parameter('position');

        // set a different route for the admin panel
        CRUD::setRoute(config('backpack.base.route_prefix') . '/position/' . $this->position . '/histories');

        // show only that position's histories
        CRUD::addBaseClause(function (Builder $query) {
            $query->whereHasMorph(
                'historiable',
                [Position::class],
                function ($query) {
                    $query->where('historiable_id', $this->position);
                }
            );
        });
    }
}
