<?php

namespace Zule\Rs;

class Player
{
    const BodyImageHttpLocation = 'http://services.runescape.com/m=avatar-rs/%s/full.gif';
    const HeadImageHttpLocation = 'http://services.runescape.com/m=avatar-rs/%s/chat.gif';
    
    private $name;
	private $stats;
	private $history;
	private $characterImageUrl;
	private $headImageUrl;
	private $historyLoaded = false;
	private $statsLoaded = false;
	
	public function __get($name)
	{
	   if ( $name == 'events' )
	   {
	       if ( !$this->historyLoaded )
	       {
    	       $this->getHistory();
	       }
    	   return $this->history;
	   }
	   
	   if ( $name != 'name' )
	   {
    	   if ( !$this->statsLoaded )
    	   {
    	       $this->getStats();
    	   }
    	   return $this->stats->$name;
	   }
	   
	   return $this->name;
	}
	
	public function __construct($name)
	{
		$this->name = $name;
		$this->characterImageUrl = sprintf(self::BodyImageHttpLocation, urlencode($name));
		$this->headImageUrl = sprintf(self::HeadImageHttpLocation, urlencode($name));
	}

	public function getHeadImageHttpLocation()
	{
    	return $this->headImageUrl;
	}
	
	public function getHeadImageBytes()
	{
    	return file_get_contents($this->headImageUrl);
	}
	
	public function getCharacterImageHttpLocation()
	{
    	return $this->characterImageUrl;
	}
	
	public function getCharacterImageBytes()
	{
    	return file_get_contents($this->characterImageUrl);
	}
	
	private function getHistory()
	{
    	$this->history = new AdventureLog($this);
	}
	
	private function getStats()
	{
		$mb = new MultiFetch;
		$url = Runescape::getScoresUrl($this->name);
		$skills = Runescape::getSkills();
		$mb->addResource($url);
		$mb->execute();
		$res = explode("\n", $mb->getResult($url));
		for( $i = 0, $c = count($skills); $i < $c; $i++ )
		{
			$temp = [];
			list(
				$temp['Rank'],
				$temp['Level'],
				$temp['Experience']
			) = explode(',', $res[$i], 3);
			
			$this->stats[$skills[$i]] = $temp;
		}
		
		$this->statsLoaded = true;
	}
	
	public function getExperience()
	{
		$exp = [];
		foreach( $this->stats as $skill => $valArray )
		{
			$exp[$skill] = $valArray['Experience'];
		}
		return $exp;
	}
	
}
