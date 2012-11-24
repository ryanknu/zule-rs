<?php

namespace Zule\Rs;

class CacheType
{
    const AdventureLogCache = 'AdventureLog';
}

class Cache
{
    const CacheDir = '/cache/';
    const SettingsFile = 'manifest.json';
    const CacheExpireTimeout = 1600;
    
    public static $alwaysUseCache = false;
    private $settings;
    
    public function __construct()
    {
        $this->settings = json_decode(file_get_contents(__DIR__ . self::CacheDir . self::SettingsFile));
    }
    
    public function saveSettings()
    {
        $fp = new \SplFileObject(__DIR__ . self::CacheDir . self::SettingsFile, 'w');
        $fp->fwrite(json_encode($this->settings));
    }
    
    public function isExpired($type)
    {
        if ( isset($this->settings->$type) )
        {
            return ( $this->settings->$type->ExpiresOn == 'nil' || 
                time() > $this->settings->$type->ExpiresOn );
        }
        
        return no;
    }
    
    public function get($type, $originalLocation)
    {
        if ( isset($this->settings->$type) )
        {
            $location = __DIR__ . self::CacheDir . $this->settings->$type->CacheLocation;
            
            if ( ($this->settings->$type->ExpiresOn == 'nil' || 
                time() > $this->settings->$type->ExpiresOn) &&
                !self::$alwaysUseCache )
            {
                $data = file_get_contents($originalLocation);
                unlink($location);
                $f = new \SplFileObject($location, 'x');
                $f->fwrite($data);
                $this->settings->$type->ExpiresOn = ( time() + 900 );
                $this->saveSettings();
            }
            
            return file_get_contents($location);
        }
        
        return null;
    }
    
}
