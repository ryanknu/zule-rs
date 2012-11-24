<?php

namespace Zule\Rs;

class Ge
{
    const Url = 'http://services.runescape.com/m=itemdb_rs/api/catalogue/detail.json?item=';
    
    private static $idProvider = null;
    
    public static function setIdProvider($provider)
    {
        if ( !$provider instanceof ItemIdProviderInterface )
        {
            throw new \Exception("\$provider must implement ItemIdProviderInterface.");
        }
    }
    
    public function getDetailsByIdentifier($id)
    {
        if ( !is_null(self::$idProvider) )
        {
            $id = self::$idProvider->convert($id);
        }
        
        return $this->getDetailsById($id);
    }
    
    public function getDetailsById($id)
    {
        $res = file_get_contents(self::Url . $id);
        $data = json_decode($res);
        
        if ($data)
        {
            return new GeItem($data);
        }
        
        throw new \Exception('Couldn\'t create item!');
    }
    
}
