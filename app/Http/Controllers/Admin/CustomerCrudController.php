<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CustomerRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CustomerCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CustomerCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Customer::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/customer');
        CRUD::setEntityNameStrings('customer', 'customers');
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
        CRUD::column('firstName');
        CRUD::column('lastName');
        CRUD::column('email');
        CRUD::column('phone');
        CRUD::column('birthdate');
        CRUD::column('user_id');
        CRUD::column('gender');
        CRUD::column('created_at');
        CRUD::column('updated_at');

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(CustomerRequest::class);

        // CRUD::field('id');
        CRUD::field('firstName');
        CRUD::field('lastName');
        CRUD::field('email');
        CRUD::addField([
            'name' => 'phone',
            'label' => 'Phone Number',
            'type' => 'text',
            // You may need to include a JavaScript library or plugin for input masking
            // For example, you can use InputMask: https://github.com/RobinHerbots/Inputmask
            'attributes' => [
                'data-inputmask' => '"mask": "999 999 9999"',
                'placeholder' => 'Ex : 097 456 7890', // Optional placeholder text
            ],
        ]);
        CRUD::addField([
            // Date
            'name'  => 'birthdate',
            'label' => 'Birthday',
            'type'  => 'date'
        ],);
        CRUD::addField([
            // Select2
            'label'     => "User",
            'type'      => 'select2',
            'name'      => 'user_id', // the db column for the foreign key

            // optional
            'entity'    => 'user', // the method that defines the relationship in your Model
            'model'     => "App\\Models\\User", // foreign key model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'default'   => 0, // set the default value of the select2

            // also optional
            'options'   => (function ($query) {
                 return $query->orderBy('id', 'ASC')->get();
             }), // force the related options to be a custom query, instead of all(); you can use this to filter the results show in the select
        ],);
        CRUD::addField([
            // select_from_array
            'name'        => 'gender',
            'label'       => "Gender",
            'type'        => 'select_from_array',
            'options'     => ['M' => 'Male', 'F' => 'Female', 'other' => 'Other'],
            'allows_null' => false,
            'default'     => 'one',
            // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
        ]);
        // CRUD::field('created_at');
        // CRUD::field('updated_at');

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
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
