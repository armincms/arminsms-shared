<?php

namespace Armincms\ArminsmsShared;

use Armincms\Qasedak\Contracts\BulkService; 
use SoapClient;

class SharedService implements BulkService
{   
    public function __construct($config)
    {
        $this->config = $this->mergeConfigs((array) $config);

        ini_set("soap.wsdl_cache_enabled", "0"); 
    }

    /**
     * Send text-message into a number.
     * 
     * @param  string $text    
     * @param  string $to  
     * @param  array  $options 
     * @return bool          
     */
    public function send(string $text, $to, $options = [])
    {
        return $this->client()->SendByBaseNumber2(
            array_merge($this->config, $options, compact('text', 'to'))
        );  
    }  

    /**
     * Send text-message into a group of numbers.
     * 
     * @param  string $text    
     * @param  array  $to  
     * @param  array  $options 
     * @return bool          
     */
    public function bulk(string $text, array $numbers, $options = [])
    { 
        return collect($numbers)->map(function($number) use ($text, $options) {
            return $this->send($test, $number, $options);
        }); 
    }

    public function url()
    {  
        return "http://api.payamak-panel.com/post/Send.asmx?wsdl"; 
    } 

    public function mergeConfigs(array $config)
    {
        return array_merge([ 
            'UserName'  => '',
            'PassWord'  => '',  
            'to'    => '', 
            'bodyId'    => '', 
        ], $config);
    }

    public function config(string $key, $default)
    {
        return data_get($this->config, $key, $default);
    }

    public function client()
    {
        return new SoapClient($this->url(), array('encoding'=>'UTF-8'));
    }
}
