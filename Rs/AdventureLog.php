<?php

namespace Zule\Rs;

use DOMDocument;

class EventType
{
    const LevelUp = 'Levelled up';
    const FoundItem = 'I found';
    const Boss = 'boss monster';
    const Quest = 'Quest complete:';
    const Qp = 'Quest Points obtained';
    const AllSkills = 'Levelled all skills over';
    const DgFloor = 'Dungeon floor';
    
}

class LogEntry
{
    private $date;
    private $title;
    private $description;
    
    public function __get($name)
    {
        return $this->$name;
    }
    
    public function __set($name, $value)
    {
        $this->$name = $value;
    }
}

class AdventureLog
{
    const FeedUrl = 'http://services.runescape.com/m=adventurers-log/rssfeed?searchName=%s';
    private $history = array();
    
    public function __construct(Player $p)
    {
        $cache = new Cache;
        $feed = sprintf(self::FeedUrl, $p->name);
        
        $xml = $cache->get(CacheType::AdventureLogCache, $feed);        
        $domdoc = new DOMDocument;
        $domdoc->loadXML($xml);
        
        foreach($domdoc->getElementsByTagName('item') as $item)
        {
            $be = new LogEntry;
            
    		foreach($item->childNodes as $childNode)
    		{
        		if ( $childNode->nodeName == 'title' )
        		{
            		$be->title = $childNode->textContent;
        		}
        		else if ( $childNode->nodeName == 'description' )
        		{
            		$be->description = $childNode->textContent;
        		}
        		else if ( $childNode->nodeName == 'pubDate' )
        		{
            		$be->date = $childNode->textContent;
        		}
    		}
    		
            $this->history[] = $be;
        }
    }
    
    public function __get($name)
    {
        return $this->$name;
    }
    
    // Returns most recent level up, trim out other crap.
    public function getLastLevelUp()
    {
        foreach($this->history as $history)
        {
            if ( strpos($history->title, 'Levelled up') !== false )
            {
                return $history;
            }
        }
    }
    
    public function getEventsOfType($type)
    {
        if ( !is_array($type) )
        {
            $type = array($type);
        }
        
        $r = array();
        
        foreach($this->history as $history)
        {
            foreach($type as $search_string)
            {
                if ( strpos($history->title, $search_string) !== false )
                {
                    $r[] = $history;
                }
            }
        }
        
        return $r;
    }
}
