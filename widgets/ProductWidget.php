<?php

namespace app\widgets;

use yii\base\Widget;

class ProductWidget extends Widget
{
    public $products = [];

    public function run()
    {
        return $this->render('product-widget', [
            'products' => $this->products,
        ]);
    }
}
