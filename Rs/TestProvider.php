<?php

namespace Zule\Rs;

class TestProvider implements ItemIdProviderInterface
{
    const RuneBar = 'Rune Bar';
    
    public function convert($id)
    {
        if ( $id == self::RuneBar )
        {
            return 451;
        }
    }
}
