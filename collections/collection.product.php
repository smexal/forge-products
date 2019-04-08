<?php

namespace Forge\Modules\ForgeProducts;

use Forge\Core\Classes\Builder;
use \Forge\Core\Abstracts\DataCollection;
use \Forge\Core\Classes\Localization;
use \Forge\Core\App\App;



class ProductCollection extends DataCollection {
    public $permission = "manage.collection.sites";

    protected function setup() {
        $this->preferences['name'] = 'forge-products';
        $this->preferences['title'] = i('Products', 'forge-news');
        $this->preferences['all-title'] = i('Manage products', 'forge-products');
        $this->preferences['add-label'] = i('Add products', 'forge-products');
        $this->preferences['single-item'] = i('Product', 'forge-products');
        $this->preferences['has_categories'] = true;
        $this->preferences['has_status'] = true;
        $this->preferences['has_image'] = true;
        $this->preferences['has_order'] = true;

        $this->custom_fields();
    }

    public function render($item) {
        return $item->getMeta('title');
    }

    public function customEditContent($id) {
        $builder = new Builder('collection', $id, 'productContentBuilder');
        return $builder->render();
    }

    public function custom_fields() {
        $this->addFields([
            [
                'key' => 'price',
                'label' => i('Price', 'forge-products'),
                'multilang' => false,
                'type' => 'text',
                'order' => 20,
                'position' => 'right',
                'hint' => ''
            ]
        ]);
    } 
}

?>
