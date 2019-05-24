<?php


namespace talismanfr\geocode\entity;


final class AddressComponent
{
    private $kind;
    private $name;

    /**
     * AddressComponent constructor.
     * @param $kind
     * @param $name
     */
    public function __construct($kind, $name)
    {
        $this->kind = $kind;
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getKind()
    {
        return $this->kind;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }


}