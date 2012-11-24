<?php

namespace Zule\Rs;

class Skill
{
    private $skillName;
    private $xp;
    private $xpNext;
    
    public function __get($name)
    {
        return $this->$name;
    }
    
    public function __construct($skillName, $xp)
    {
        $this->skillName = $skillName;
        $this->xp = $xp;
    }
}
