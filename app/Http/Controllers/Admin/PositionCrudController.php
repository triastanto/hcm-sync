<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PositionRequest;
use App\Models\History;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;

/**
 * Class PositionCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PositionCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Position::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/position');
        CRUD::setEntityNameStrings('position', 'positions');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('id');
        CRUD::column('title');
        CRUD::button('view_histories')->stack('line')->view('crud::buttons.quick')->meta([
            'access'  => true,
            'label'   => 'View Histories',
            'icon'    => 'la la-paw',
            'wrapper' => [
                'href' => function ($entry, $crud) {
                    return url($crud->route . '/' . $entry->getKey() . '/histories');
                },
                'title' => 'View owner histories',
            ],
        ]);
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(PositionRequest::class);
        CRUD::field('title');
        CRUD::field('start_date')->type('date');
        CRUD::field('end_date')->type('date');

        CRUD::addSaveAction([
            'name' => 'save_and_create_history',
            'redirect' => function ($crud, $request, $itemId) {
                return $crud->route;
            },
            'button_text' => 'Save and Create History',
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $unit = $this->crud->create($request->except(['start_date', 'end_date']));

        $unit->histories()
            ->save(new History(['start_date' => $request->start_date, 'end_date' => $request->end_date]));

        return $this->crud->performSaveAction($unit->id);
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
