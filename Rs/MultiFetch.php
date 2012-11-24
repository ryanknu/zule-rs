<?php

namespace Zule\Rs;

class MultiFetch
{
	private $handles;
	private $results;
	private $master;
	
	public function __construct()
	{
		$this->handles = [];
		$this->master = curl_multi_init();
	}
	
	public function addResource($url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, no);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, yes);
		$this->handles[$url] = $ch;
	}
	
	public function execute()
	{
		$master = curl_multi_init();
		
		foreach($this->handles as $h)
		{
			curl_multi_add_handle($master, $h);
		}
		
		$processing = 0;
		do {
			curl_multi_exec($master, $processing);
		} while ($processing > 0);
		
		foreach($this->handles as $url => $h)
		{
			$code = curl_getinfo($h, CURLINFO_HTTP_CODE);
			if ( $code == 200 )
			{
				$this->results[$url] = curl_multi_getcontent($h);
			}
			else
			{
				$this->results[$url] = null;
			}
		}
	}
	
	public function getResult($url)
	{
		return $this->results[$url];
	}
}

return;

function getUrl($un)
{
	return 'http://hiscore.runescape.com/index_lite.ws?player=' . urlencode($un);
}

$mf = new MultiFetch;
$mf->addResource(getUrl('the ZUL'));
$mf->addResource(getUrl('zezima'));
$mf->addResource(getUrl('trioted'));
$mf->addResource(getUrl('kaneezdizzle'));
$mf->addResource(getUrl('skarpen666'));
$mf->execute();
