<?php

namespace Api\Domain\User;

class User 
{
    private string $name;
    private string $address;
    private int $city;
    private int $state;

    public function __construct($name='', $address='', $city=0, $state=0)
    {
        $this->name = $name;
        $this->address = $address;
        $this->city = $city;
        $this->state = $state;
    }

    public function whoIs():array
    {
        return array(
            'name'=>$this->name,
            'address'=>$this->address,
            'city'=>$this->city,
            'state'=>$this->state
        );
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setAddress($address)
    {
        $this->address = $address;
    }

    public function setCity($city)
    {
        $this->city = $city;
    }

    public function setState($state)
    {
        $this->state = $state;
    }
}
