<?php
namespace App\Productos;
use App\Interfaces\QualityOperations;

class Tumi extends ProductoBase implements QualityOperations{

    protected const MAX_QUALITY = 80;

    public function __construct($quality, $sellIn){
        parent::__construct($quality, $sellIn);
    }

    public function updateQuality(){
        $this->quality = self::MAX_QUALITY;
    }

    public function restSellIn(){
        $this->sellIn = 0;

        $this->updateQuality();
    }

}