<?php
namespace App\Productos;
use App\Interfaces\QualityOperations;

class Cafe extends ProductoBase implements QualityOperations{

    protected const QUALITY_IMPACT_RATE = 2;

    public function __construct($quality, $sellIn){
        parent::__construct($quality, $sellIn);
    }

    public function updateQuality(){
        if($this->quality > self::MIN_QUALITY){
            $this->quality = $this->quality - self::QUALITY_IMPACT_RATE;

            if($this->sellIn < 0 && $this->quality > self::MIN_QUALITY)
                $this->quality = $this->quality - self::QUALITY_IMPACT_RATE;
        }
    }

}