<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\OrganizationRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class OrganizationCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class OrganizationCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\ReviseOperation\ReviseOperation;

    public function setup(): void
    {
        CRUD::setModel(\App\Models\Organization::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/organization');
        CRUD::setEntityNameStrings('organization', 'organizations');
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
            'label' => 'Units',
            'type' => 'relationship_count',
            'name' => 'units',
            'suffix' => ' units',
            'wrapper' => [
                'href' => function ($crud, $column, $entry, $related_key) {
                    return backpack_url('unit?organization_id=' . $entry->getKey());
                },
            ],
        ]);
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
                'route' => 'organization.show',
                'target' => '_blank',
            ],
            'limit' => 80
        ]);
    }

    protected function setupCreateOperation(): void
    {
        CRUD::setValidation(OrganizationRequest::class);

        CRUD::field(['label' => 'Organization Name', 'name' => 'name']);
        CRUD::field(
            [
                'label' => 'Parent Organization',
                'type' => 'select',
                'name' => 'parent_id',
                'entity' => 'parent',
                'attribute' => 'name',
                'model' => 'app\Models\Organization',
            ],
        );
    }

    protected function setupUpdateOperation(): void
    {
        $this->setupCreateOperation();
    }
}
