<?php foreach ($products as $product): ?>
    <div class="product-item">
        <h3><?= $product['name'] ?></h3>
        <img src="<?= $product['image'] ?>" alt="<?= $product['name'] ?>" style="width:100px;height:auto;">
        <p><?= $product['description'] ?></p>
        <p>ราคา: <?= $product['price'] ?> บาท</p>
    </div>
<?php endforeach; ?>
