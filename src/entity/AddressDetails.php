<?php


namespace talismanfr\geocode\entity;


use yii\helpers\ArrayHelper;

final class AddressDetails
{
    private $addressLine;

    private $countryNameCode;

    private $countryName;

    private $administrativeAreaName;

    private $subAdministrativeAreaName;

    private $localiteName;

    private $thoroughfareName;

    private $premiseNumber;

    private $postalCodeNumber;

    /**
     * AddressDetails constructor.
     * @param $addressLine
     * @param $countryNameCode
     * @param $countryName
     * @param $administrativeAreaName
     * @param $subAdministrativeAreaName
     * @param $localiteName
     * @param $thoroughfareName
     * @param $premiseNumber
     * @param $postalCodeNumber
     */
    public function __construct($addressLine, $countryNameCode, $countryName, $administrativeAreaName, $subAdministrativeAreaName, $localiteName, $thoroughfareName, $premiseNumber, $postalCodeNumber)
    {
        $this->addressLine = $addressLine;
        $this->countryNameCode = $countryNameCode;
        $this->countryName = $countryName;
        $this->administrativeAreaName = $administrativeAreaName;
        $this->subAdministrativeAreaName = $subAdministrativeAreaName;
        $this->localiteName = $localiteName;
        $this->thoroughfareName = $thoroughfareName;
        $this->premiseNumber = $premiseNumber;
        $this->postalCodeNumber = $postalCodeNumber;
    }

    /**
     * @param array $state
     * @return AddressDetails
     */
    public static function fromState(array $state): self
    {
        $addressLine=ArrayHelper::getValue($state,'Country.AddressLine');
        $countryNameCode=ArrayHelper::getValue($state,'Country.CountryNameCode');
        $countryName=ArrayHelper::getValue($state,'Country.CountryName');
        $administrativeAreaName=ArrayHelper::getValue($state,'Country.AdministrativeArea.AdministrativeAreaName');
        $subAdministrariveAreaName=ArrayHelper::getValue($state,'Country.AdministrativeArea.SubAdministrativeArea.SubAdministrativeAreaName');
        $subAdm=ArrayHelper::getValue($state,'Country.AdministrativeArea.SubAdministrativeArea');
        $locality=ArrayHelper::getValue($subAdm,'Locality.LocalityName');
        $throughfareName=ArrayHelper::getValue($subAdm,'Locality.Thoroughfare.ThoroughfareName');
        $premiseNumber=ArrayHelper::getValue($subAdm,'Locality.Thoroughfare.Premise.PremiseNumber');
        $postalCodeNumber=ArrayHelper::getValue($subAdm,'Locality.Thoroughfare.Premise.PostalCode.PostalCodeNumber');

        return new self($addressLine,$countryNameCode,$countryName,$administrativeAreaName,
            $subAdministrariveAreaName,$locality,$throughfareName,$premiseNumber,$postalCodeNumber);
    }

    /**
     * @return mixed
     */
    public function getAddressLine()
    {
        return $this->addressLine;
    }

    /**
     * @return mixed
     */
    public function getCountryNameCode()
    {
        return $this->countryNameCode;
    }

    /**
     * @return mixed
     */
    public function getCountryName()
    {
        return $this->countryName;
    }

    /**
     * @return mixed
     */
    public function getAdministrativeAreaName()
    {
        return $this->administrativeAreaName;
    }

    /**
     * @return mixed
     */
    public function getSubAdministrativeAreaName()
    {
        return $this->subAdministrativeAreaName;
    }

    /**
     * @return mixed
     */
    public function getLocaliteName()
    {
        return $this->localiteName;
    }

    /**
     * @return mixed
     */
    public function getThoroughfareName()
    {
        return $this->thoroughfareName;
    }

    /**
     * @return mixed
     */
    public function getPremiseNumber()
    {
        return $this->premiseNumber;
    }

    /**
     * @return mixed
     */
    public function getPostalCodeNumber()
    {
        return $this->postalCodeNumber;
    }




}