<?php

namespace Zule\Rs;

class GeItem
{
    private $item;
    
    public function __construct($data)
    {
        if ( $data instanceof stdclass )
        {
            if ( property_exists($data, 'item') )
            $this->item = $data->item;
        }
    }
    
    public function __get($name)
    {
        return $this->item->$name;
    }
}
