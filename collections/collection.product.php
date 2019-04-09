<?php

namespace Forge\Modules\ForgeProducts;

use \Forge\Core\Classes\Builder;
use \Forge\Core\Classes\Media;
use \Forge\Core\Classes\Utils;
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
        $builder = new Builder('collection', $item->id, 'productContentBuilder');
        $elements = $builder->getBuilderElements(Localization::getCurrentLanguage());

        $builderContent = '';
        foreach($elements as $element) {
            $builderContent.=$element->content();
        }

        $addToCart = false;
        if(App::instance()->mm->isActive('forge-shoppingcart')) {
            $addToCart = true;
        }

        $image = new Media($item->getMeta('collection_image'));
        return App::instance()->render(MOD_ROOT.'forge-products/templates/', 'product', [
            'title' => $item->getMeta('title'),
            'desc' => $item->getMeta('description'),
            'image' => $image->getUrl(),
            'builder' => $builderContent,
            'price_label' => i('Price/unit', 'forge-products'),
            'price' => Utils::formatAmount($item->getMeta('price')),
            'add_to_cart' => $addToCart ? \Forge\Modules\ForgeShoppingcart\Cart::addToButton($item->getId(), ['amount_selection' => true]): $addToCart
        ]);
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
