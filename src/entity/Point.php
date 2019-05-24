<?php


namespace talismanfr\geocode\entity;


final class Point
{
    private $pos;

    private $lat;

    private $lon;

    /**
     * Point constructor.
     * @param $pos
     */
    public function __construct($pos)
    {
        $this->pos = $pos;
        if (!empty($pos)) {
            $this->buildLatLon($pos);
        }
    }

    private function buildLatLon($pos)
    {
        [$this->lon, $this->lat] = explode(' ', $pos);
    }

    /**
     * @return mixed
     */
    public function getPos()
    {
        return $this->pos;
    }

    /**
     * @return mixed
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * @return mixed
     */
    public function getLon()
    {
        return $this->lon;
    }



}