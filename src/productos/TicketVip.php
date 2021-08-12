<?php
namespace App\Productos;
use App\Interfaces\QualityOperations;

class TicketVip extends ProductoBase implements QualityOperations{

    public function __construct($quality, $sellIn){
        parent::__construct($quality, $sellIn);
    }

    public function updateQuality(){

        if($this->quality < self::MAX_QUALITY){
            
            if($this->sellIn >= 0){
                $this->quality = $this->quality + self::QUALITY_IMPACT_RATE;

                if($this->sellIn < 10 && $this->quality < self::MAX_QUALITY)
                    $this->quality = $this->quality + self::QUALITY_IMPACT_RATE;

                if($this->sellIn < 5 && $this->quality < self::MAX_QUALITY)
                    $this->quality = $this->quality + self::QUALITY_IMPACT_RATE;
            }
            else{
                $this->quality = 0;
            }
        }
    }


}