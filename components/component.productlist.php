<?php

namespace Forge\Modules\ForgeProducts;

use \Forge\Core\Abstracts\Component;
use \Forge\Core\App\App;
use \Forge\Core\Classes\Utils;
use \Forge\Core\Classes\Media;
use \Forge\Core\Classes\Settings;


class ProductlistComponent extends Component {
    public $settings = array();

    public function prefs() {
        $this->settings = array(
            array(
                "label" => i('Title', 'forge-products'),
                "hint" => '',
                "key" => "title",
                "type" => "text"
            ),
            array(
                "label" => i('Limit the amount of products', 'forge-products'),
                "hint" => '',
                "key" => "limit",
                "type" => "number"
            ),
        );
        return array(
            'name' => i('Product Listing'),
            'description' => i('List of products.'),
            'id' => 'forge-products',
            'image' => '',
            'level' => 'inner',
            'container' => false
        );
    }

    public function content() {
        $limit = 0;
        if($this->getField('limit')) {
            $limit = $this->getField('limit');
        }
        $collection = App::instance()->cm->getCollection('forge-products');
        $items = $collection->items([
            'order' => 'created',
            'order_direction' => 'desc',
            'limit' => $limit,
            'status' => 'published'
        ]);
        $products = [];
        foreach($items as $product) {
            $link = '';
            if(Settings::get('forge-products-has-detail')) {
                $link = $product->url();
            }

            $image = new Media($product->getMeta('collection_image'));
            $products[] = [
                'link' => $link,
                'image' => $image->getSizedImage(260, 200),
                'title' => $product->getMeta('title'),
                'description' => $product->getMeta('description'),
                'price' => Utils::formatAmount($product->getMeta('price')),
            ];
        }

        return App::instance()->render(DOC_ROOT.'modules/forge-products/templates/', "productlist", [
            'title' => $this->getField('title'),
            'products' => $products
        ]);
    }
}

?>