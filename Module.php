<?php

namespace ZuleRs;

class Module
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    'Zule\Rs' => __DIR__ . '/Rs/',
                ),
            ),
        );
    }
}