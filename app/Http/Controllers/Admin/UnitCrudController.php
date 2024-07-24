<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UnitRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class UnitCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UnitCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\ReviseOperation\ReviseOperation;

    private string $organization_id;

    public function setup(): void
    {
        CRUD::setModel(\App\Models\Unit::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/unit');
        CRUD::setEntityNameStrings('unit', 'units');

        if (request()->filled('organization_id')) {
            $this->organization_id = request()->query('organization_id');
            CRUD::addClause('where', 'organization_id', '=', $this->organization_id);
        }
    }

    protected function setupListOperation(): void
    {
        CRUD::addColumn([
            'name' => 'name',
            'label' => 'Name',
            'type' => 'text',
            'limit' => 80
        ]);
        CRUD::addColumn([
            'name' => 'parent',
            'label' => 'Parent',
            'linkTo' => [
                'route' => 'unit.show', 'target' => '_blank',
            ],
            'limit' => 80
        ]);
        CRUD::addColumn('organization');
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
            'label' => 'Positions',
            'type' => 'relationship_count',
            'name' => 'positions',
            'suffix' => ' positions',
            'wrapper' => [
                'href' => function ($crud, $column, $entry, $related_key) {
                    return backpack_url('position?unit_id=' . $entry->getKey());
                },
            ],
        ]);
    }

    protected function setupCreateOperation(): void
    {
        CRUD::setValidation(UnitRequest::class);
        CRUD::field('organization');
        CRUD::field('parent');
        CRUD::field('name');
    }

    protected function setupUpdateOperation(): void
    {
        $this->setupCreateOperation();
    }
}
