<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SubgroupRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class SubgroupCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class SubgroupCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\ReviseOperation\ReviseOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\Subgroup::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/subgroup');
        CRUD::setEntityNameStrings('subgroup', 'subgroups');
    }

    protected function setupListOperation()
    {
        CRUD::addColumn('name');
        CRUD::addColumn([
            'name' => 'organization',
            'label' => 'Organization',
            'attribute' => 'name',
            'limit' => 80,
        ]);
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
            'label' => 'Positions',
            'type' => 'relationship_count',
            'name' => 'positions',
            'suffix' => ' positions',
            'wrapper' => [
                'href' => function ($crud, $column, $entry, $related_key) {
                    return backpack_url('position?subgroup_id=' . $entry->getKey());
                },
            ],
        ]);
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(SubgroupRequest::class);
        CRUD::field('name');
        CRUD::field([
            'label' => 'Organization',
            'type' => 'select',
            'name' => 'organization_id',
            'entity' => 'organization',
            'attribute' => 'name',
            'model' => 'app\Models\Organization',
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
