<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\EmployeeRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class EmployeeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class EmployeeCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\ReviseOperation\ReviseOperation;

    private string $position_id;

    public function setup()
    {
        CRUD::setModel(\App\Models\Employee::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/employee');
        CRUD::setEntityNameStrings('employee', 'employees');

        if (request()->filled('position_id')) {
            $this->position_id = request()->query('position_id');
            CRUD::addClause('where', 'position_id', '=', $this->position_id);
        }
    }

    protected function setupListOperation()
    {
        CRUD::addColumn('name');
        CRUD::addColumn('email');
        CRUD::addColumn('username');
        CRUD::addColumn('personnel_no');
        CRUD::addColumn('position');
    }

    protected function setupShowOperation()
    {
        CRUD::addColumn([
            'name' => 'id',
            'label' => 'ID',
            'type' => 'text',
            'limit' => 36
        ]);
        $this->setupListOperation();
        CRUD::addColumn([
            'name' => 'unit',
            'label' => 'Unit',
            'entity' => 'position.unit',
            'attribute' => 'name',
        ]);
        CRUD::addColumn([
            'name' => 'organization',
            'label' => 'Organization',
            'type' => 'closure',
            'function' => function($entry) {
                return $entry->position->unit->organization->name;
            },
        ]);
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(EmployeeRequest::class);
        CRUD::field('email');
        CRUD::field('username');
        CRUD::field('personnel_no');
        CRUD::field('position');
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
