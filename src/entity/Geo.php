<?php


namespace talismanfr\geocode\entity;


final class Geo
{
    /** @var Address */
    private $address;

    /** @var AddressDetails */
    private $address_details;

    /** @var Point */
    private $point;

    private $name;

    private $description;

    private $kind;

    private $text;

    public function __construct(Address $address, AddressDetails $address_details, Point $point,
        $name, $description, $kind, $text)
    {
        $this->address=$address;
        $this->address_details=$address_details;
        $this->point=$point;
        $this->name=$name;
        $this->description=$description;
        $this->kind=$kind;
        $this->text=$text;
    }

    /**
     * @return Address
     */
    public function getAddress(): Address
    {
        return $this->address;
    }

    /**
     * @return AddressDetails
     */
    public function getAddressDetails(): AddressDetails
    {
        return $this->address_details;
    }

    /**
     * @return Point
     */
    public function getPoint(): Point
    {
        return $this->point;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
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
    public function getText()
    {
        return $this->text;
    }




}