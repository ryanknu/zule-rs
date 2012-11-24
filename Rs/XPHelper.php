<?php

namespace Zule\Rs;

class XpHelper
{
    static $table = null;
    const TableLocation = __DIR__ . '/resources/XPTable.php';
    
    public function __construct()
    {
        if ( is_null(self::$table) )
        {
            self::$table = include self::TableLocation;
        }
    }
    
    public function getXpLeft(Skill $s)
    {
        if ( $s->hasXp() )
        {
            $targetXp = self::$table[$s->level + 1];
            return $targetXp - $s->xp;
        }
        
        trigger_error('User is not ranked in this skill.');
        return 0;
    }
    
    public function getLevelProgression(Skill $s)
    {
        if ( $s->hasXp() )
        {
            $targetXp = self::$table[$s->level + 1];
            $startXp = self::$table[$s->level];
            $distance = $targetXp - $startXp;
            $xpLeft = $targetXp - $s->xp;
            return ($distance / $xpLeft);
        }
        
        trigger_error('User is not ranked in this skill.');
        return 0;
    }
    
}
