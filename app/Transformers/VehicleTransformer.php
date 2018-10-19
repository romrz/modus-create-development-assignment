<?php

namespace App\Transformers;

class VehicleTransformer
{
    /**
     * Transform a collection vehicles.
     * 
     * @param array $items 
     * @return array
     */
    public function transformCollection($items)
    {
        $result = [];
        
        foreach($items as $item)
        {
            $result[] = $this->transformItem($item);
        } 


        return $result;
    }

    /**
     * Transform a single vehicle.
     * 
     * @param Object $item
     * @return array
     */
    public function transformItem($item)
    {
        $result = [
            'Description' => $item->VehicleDescription,
            'VehicleId' => (int) $item->VehicleId,
        ];

        if(isset($item->OverallRating))
        {
            $result['CrashRating'] = $item->OverallRating;
        }

        return $result;
    }
}