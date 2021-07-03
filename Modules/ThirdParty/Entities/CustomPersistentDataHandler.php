<?php

namespace Modules\ThirdParty\Entities;


use Facebook\PersistentData\PersistentDataInterface;

class CustomPersistentDataHandler implements PersistentDataInterface
{


    /**
     * @var string Prefix to use for session variables.
     */
    protected $sessionPrefix = 'FBRLH_';

    /**
     * Get a value from a persistent data store.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function get($key)
    {
        return \Session::get($this->sessionPrefix . $key);
    }

    /**
     * Set a value in the persistent data store.
     *
     * @param string $key
     * @param mixed $value
     */
    public function set($key, $value)
    {
        \Session::put($this->sessionPrefix . $key, $value);
    }
}