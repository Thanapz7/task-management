<?php
use app\widgets\ProductWidget;

$products = [
    [
        'name' => 'สินค้า 1',
        'image' => 'path/to/image1.jpg',
        'description' => 'รายละเอียดสินค้า 1',
        'price' => 100
    ],
    [
        'name' => 'สินค้า 2',
        'image' => 'path/to/image2.jpg',
        'description' => 'รายละเอียดสินค้า 2',
        'price' => 200
    ]
];


echo ProductWidget::widget(['products' => $products]);
?>
