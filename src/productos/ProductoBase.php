<?php
namespace App\Productos;
use App\Interfaces\QualityOperations;

class ProductoBase implements QualityOperations{

    protected const MIN_QUALITY = 0;
    protected const MAX_QUALITY = 50;
    protected const QUALITY_IMPACT_RATE = 1;

    public $sellIn;
    public $quality;

    public function __construct($quality, $sellIn){
        $this->quality = $quality;
        $this->sellIn = $sellIn;
    }

    public function updateQuality() {
        if($this->quality > self::MIN_QUALITY){
            $this->quality = $this->quality - self::QUALITY_IMPACT_RATE;

            if($this->sellIn < 0 && $this->quality > self::MIN_QUALITY)
                $this->quality = $this->quality - self::QUALITY_IMPACT_RATE;
        }
    }

    public function restSellIn() {
        $this->sellIn = $this->sellIn - 1;

        $this->updateQuality();
    }

} 