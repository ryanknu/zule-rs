<?php

namespace Zule\Rs;

define('HISCORES_URL_BASE', 'http://hiscore.runescape.com/index_lite.ws?player=');

class Runescape
{
	
	public static function getScoresUrl($username)
	{
		return HISCORES_URL_BASE . urlencode($username);
	}
	
	public static function getSkills()
	{
		return [
			'Overall',
			'Attack', 
			'Defence', 
			'Strength',
			'Hitpoints', 
			'Ranged', 
			'Prayer',
			'Magic', 
			'Cooking', 
			'Woodcutting',
			'Fletching', 
			'Fishing', 
			'Firemaking',
			'Crafting', 
			'Smithing', 
			'Mining',
			'Herblore', 
			'Agility', 
			'Thieving',
			'Slayer', 
			'Farming', 
			'Runecrafting',
			'Hunter', 
			'Construction', 
			'Summoning',
			'Dungeoneering',
		];
	}
	
}
