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

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Employee::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/employee');
        CRUD::setEntityNameStrings('employee', 'employees');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        // CRUD::column('id');
        CRUD::addColumn(['name' => 'employee_image', 'type' => 'image', 'label' => 'employee image','height' => '50px', 'width' => '50px',]);
        CRUD::column('user_id');
        CRUD::column('firstName');
        CRUD::column('lastName');
        CRUD::column('position_id');
        CRUD::column('email');
        CRUD::column('phone');
        CRUD::column('birthdate');
        CRUD::column('gender');
        CRUD::column('lat');
        CRUD::column('long');
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
        CRUD::setValidation(EmployeeRequest::class);

        CRUD::field('firstName');
        CRUD::field('lastName');
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
        ]);

        CRUD::addField([
            // Select2
            'label'     => "Position",
            'type'      => 'select2',
            'name'      => 'position_id', // the db column for the foreign key

            // optional
            'entity'    => 'position', // the method that defines the relationship in your Model
            'model'     => "App\\Models\\Position", // foreign key model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'default'   => 0, // set the default value of the select2

            // also optional
            'options'   => (function ($query) {
                 return $query->orderBy('id', 'ASC')->get();
             }), // force the related options to be a custom query, instead of all(); you can use this to filter the results show in the select
        ]);
        CRUD::field('email');
        CRUD::field('phone');
        CRUD::addField([
            // Date
            'name'  => 'birthdate',
            'label' => 'Birthday',
            'type'  => 'date'
        ]);
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
        CRUD::field('lat');
        CRUD::field('long');
        CRUD::addField([
            'label' => "Image",
            'name' => "employee_image",
            'type' => 'image',
            'crop' => true, // set to true to allow cropping, false to disable
            'aspect_ratio' => 1,
        ]);

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
