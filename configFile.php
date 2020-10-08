<?php

class ConfigGrab {
    
    private $items;

    public function __construct ()
    {
        $this->items = require('./settings.php');
    }
       
    public function config($key = null, $default = null)
    {
        if (is_null($key)) 
        {
            return $default;
        }
        
        return $this->get($key, $default);
    }

    private function get($key, $default = null)
    {
        if(!is_string($key)){
            return $default;
        }

        return $this->getValue($this->items, $key, $default);
    }

    private function getValue($array, $key, $default = null) 
    {
        if (!is_array($array)) {
            return $default;
        }

        if (is_null($key))
            return $array;

        if (strpos($key, '.') === false)
            return $array[$key] ?? $default;

        foreach (explode('.', $key) as $segment) 
        {
            if (is_array($array) && array_key_exists($segment, $array)) 
                $array = $array[$segment];
            else 
                return $default;
        }

        return $array;
    }
}

$c = new ConfigGrab();
echo $c->config("app.services.resizer.prefer_format", "localhost") . "\n";
