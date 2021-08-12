<?php

namespace App;
use App\Interfaces\QualityOperations;

class VillaPeruana
{
    public $product;

    public function __construct(QualityOperations $product)
    {
        $this->product = $product;
    }

    public static function of(QualityOperations $product) {
        return new static($product);
    }

    public function tick()
    {
        $this->product->restSellIn();
    }

}
