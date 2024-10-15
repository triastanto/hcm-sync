<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PositionRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

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
    use \Backpack\ReviseOperation\ReviseOperation;

    private string $unit_id;
    private string $subgroup_id;

    public function setup()
    {
        CRUD::setModel(\App\Models\Position::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/position');
        CRUD::setEntityNameStrings('position', 'positions');

        if (request()->filled('unit_id')) {
            $this->unit_id = request()->query('unit_id');
            CRUD::addClause('where', 'unit_id', '=', $this->unit_id);
        }

        if (request()->filled('subgroup_id')) {
            $this->subgroup_id = request()->query('subgroup_id');
            CRUD::addClause('where', 'subgroup_id', '=', $this->subgroup_id);
        }
    }

    protected function setupListOperation(): void
    {
        CRUD::addColumn([
            'name' => 'title',
            'label' => 'Title',
            'type' => 'text',
            'limit' => 80,
        ]);
        CRUD::addColumn('subgroup');
        CRUD::addColumn([
            'name' => 'unit',
            'label' => 'Unit',
            'attribute' => 'name',
            'limit' => 80,
        ]);
    }

    protected function setupShowOperation(): void
    {
        CRUD::addColumn([
            'name' => 'id',
            'label' => 'ID',
            'type' => 'text',
            'limit' => 36
        ]);
        $this->setupListOperation();
        CRUD::addColumn([
            'name' => 'organization',
            'label' => 'Organization',
            'type' => 'select',
            'entity' => 'unit.organization',
            'attribute' => 'name',
        ]);
        CRUD::addColumn([
            'label' => 'Employees',
            'type' => 'relationship_count',
            'name' => 'employees',
            'suffix' => ' employees',
            'wrapper' => [
                'href' => function ($crud, $column, $entry, $related_key) {
                    return backpack_url('employee?position_id=' . $entry->getKey());
                },
            ],
        ]);
    }

    protected function setupCreateOperation(): void
    {
        CRUD::setValidation(PositionRequest::class);
        CRUD::field('title');
        CRUD::field([
                'label' => 'Unit',
                'type' => 'select',
                'name' => 'unit_id',
                'entity' => 'unit',
                'attribute' => 'name',
                'model' => 'app\Models\Unit',
            ],
        );
    }

    protected function setupUpdateOperation(): void
    {
        $this->setupCreateOperation();
    }
}
