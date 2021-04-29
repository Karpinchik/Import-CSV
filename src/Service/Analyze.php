<?php
declare(strict_types=1);

namespace App\Service;

class Analyze
{
    /**
     * @var array all relevant items in the array
     */
    public array $relevantItems;

    /**
     * @var array all incorrect items in the array
     */
    public array $incorrectItems;

    /**
     * @var int quantity all got items
     */
    public int $countAllItems;

    /**
     * @var array headers
     */
    public array $headers;

    /**
     * @var int quantity relevant items
     */
    public int $countRelevantItems;

    /**
     * @var int
    */
    public int $countIncorrectItems;

    /**
     * @var string
    */
    public string $error;

    /**
     * @param array $arrayData
     * @return array
     */
    public function checkCostAndStock(array $arrayData) :array
    {
        try{
            foreach ($arrayData['All products'] as $key => $value){
                // удалил все позиции без цифровых значений, чтобы дальше было удобнее фильтровать по условиям
                if( is_numeric($value['Stock']) and is_numeric($value['Cost in GBP']) )
                {
                    $resultToImport[$value['Product Code']] = $value;
                }
                else {
                    $this->incorrectItems[$value['Product Code']] = $value;
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
            $this->incorrectItems = array_diff_key($resultToImport, $relevantItems);
            $this->countIncorrectItems = count($this->incorrectItems);
            $this->countRelevantItems = $this->countAllItems - count($this->incorrectItems);
            $this->headers = $arrayData['header'];

            return (array)$this;
        } catch (\Exception $exception){
            $this->error = 'error';

            return (array)$this;
        }
    }
}

