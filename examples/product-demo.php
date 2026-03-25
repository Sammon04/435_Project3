<?php

require_once("Product.php");

$product = new Product("USB-C Cable", 9.99);

echo "Product: " . $product->getName();
echo "<br>Price: $" . $product->getPrice();