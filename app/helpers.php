<?php
    if(!function_exists('percentageDiscount')){
        function percentageDiscount($price,$sellPrice){
            if($sellPrice != 0){
                $newPrice = ($price - $sellPrice) / $price * 100 ;
            }
            else {
                $newPrice = 0;
            }
            return round($newPrice);
        }
    }
?>