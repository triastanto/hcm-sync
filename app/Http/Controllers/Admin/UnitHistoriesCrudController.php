<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\HistoryCrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Route;

class UnitHistoriesCrudController extends HistoryCrudController
{
    private int $unit;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        parent::setup();

        // get the unit parameter
        $this->unit = Route::current()->parameter('unit');

        // set a different route for the admin panel
        CRUD::setRoute(config('backpack.base.route_prefix') . '/unit/' . $this->unit . '/histories');

        // show only that unit's histories
        CRUD::addBaseClause(function (Builder $query) {
            $query->whereHas('unit', function (Builder $query) {
                $query->where('unit_id', $this->unit);
            });
        });
    }
}
