<?php
declare(strict_types=1);

namespace App\Service;


class Analyze
{

    public $relevantItems = [];
    public $IncorrectItems = [];
    public $countAllItems;
    public $countIncorrectItems;
    public $header = [];

    public function checkCostAndStock($arrayData)
    {
        foreach ($arrayData['All products'] as $key => $value){
            // удалил все позиции без цифровых значений, чтобы дальше было удобнее фильтровать по условиям
            if( is_numeric($value['Stock']) and is_numeric($value['Cost in GBP']) )
            {
                $resultToImport[$value['Product Code']] = $value;
            }
            else {
                $this->IncorrectItems[$value['Product Code']] = $value;
            }
        }

// надо переделать, выдает неверный результат, много ифов
        foreach ($resultToImport as $key => $value) {
            if ($value['Cost in GBP'] >= 5){
                if ($value['Stock'] >= 10){
                    if($value['Cost in GBP'] < 1000) {
                        $relevantItems[$value['Product Code']] = $value;
                    }
                }
            }
        }

        $this->countAllItems = $arrayData['count'];
        $this->relevantItems = $relevantItems;
        $this->IncorrectItems = array_diff_key($resultToImport, $relevantItems);
        $this->countIncorrectItems = count($this->IncorrectItems);
        $this->header = $arrayData['header'];

        return $this;
    }
}
