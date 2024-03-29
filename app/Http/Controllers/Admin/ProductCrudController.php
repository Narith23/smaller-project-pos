<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ProductCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ProductCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Product::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/product');
        CRUD::setEntityNameStrings('product', 'products');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::addColumn(['name' => 'thumbnail_img', 'type' => 'image', 'label' => 'thumbnail image','height' => '50px', 'width' => '50px',]);
        CRUD::column('name');
        CRUD::column('description');
        CRUD::column('price');
        CRUD::column('stock_quantity');
        CRUD::column('category_id');
        CRUD::column('brand_id');
        CRUD::addColumn([
            'name'    => 'product_image',
            'label'   => 'Photos',
            'type'    => 'upload_multiple',
            // 'disk' => 'public'
        ]);
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
        CRUD::setValidation(ProductRequest::class);

        CRUD::field('name');
        CRUD::field('description');
        CRUD::field('price');
        CRUD::field('stock_quantity');
        CRUD::addField([
            // Select2
            'label'     => "Category",
            'type'      => 'select2',
            'name'      => 'category_id', // the db column for the foreign key

            // optional
            'entity'    => 'category', // the method that defines the relationship in your Model
            'model'     => "App\\Models\\Category", // foreign key model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'default'   => 0, // set the default value of the select2

            // also optional
            'options'   => (function ($query) {
                 return $query->orderBy('id', 'ASC')->get();
             }), // force the related options to be a custom query, instead of all(); you can use this to filter the results show in the select
        ]);
        CRUD::addField([
            // Select2
            'label'     => "Brand",
            'type'      => 'select2',
            'name'      => 'brand_id', // the db column for the foreign key

            // optional
            'entity'    => 'brand', // the method that defines the relationship in your Model
            'model'     => "App\\Models\\Brand", // foreign key model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'default'   => 0, // set the default value of the select2

            // also optional
            'options'   => (function ($query) {
                 return $query->orderBy('id', 'ASC')->get();
             }), // force the related options to be a custom query, instead of all(); you can use this to filter the results show in the select
        ]);

        CRUD::addField([
            // Select2
            'label'     => "Type",
            'type'      => 'select2',
            'name'      => 'type_id', // the db column for the foreign key

            // optional
            'entity'    => 'type', // the method that defines the relationship in your Model
            'model'     => "App\\Models\\Type", // foreign key model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'default'   => 0, // set the default value of the select2

            // also optional
            'options'   => (function ($query) {
                 return $query->orderBy('id', 'ASC')->where("is_active", true)->get();
             }), // force the related options to be a custom query, instead of all(); you can use this to filter the results show in the select
        ]);

        CRUD::addField([
            'label' => "Thumbnail Image",
            'name' => "thumbnail_img",
            'type' => 'image',
            'crop' => true, // set to true to allow cropping, false to disable
            'aspect_ratio' => 1,
        ]);

        CRUD::addField([
            'name'      => 'product_image',
            'label'     => 'Photos',
            'type'      => 'upload_multiple',
            'upload'    => true,
            // 'disk'      => 'uploads\\images\\products', // if you store files in the /public folder, please omit this; if you store them in /storage or S3, please specify it;
            // optional:
            'temporary' => 5
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
