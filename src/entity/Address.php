<?php


namespace talismanfr\geocode\entity;


use yii\helpers\ArrayHelper;

class Address
{
    /** @var string */
    private $country_code;

    /** @var string */
    private $formated;

    /** @var AddressComponent[][] */
    private $components;

    /**
     * Address constructor.
     * @param string $country_code
     * @param string $formated
     * @param AddressComponent[][] $components
     */
    public function __construct(string $country_code, string $formated, array $components)
    {
        $this->country_code = $country_code;
        $this->formated = $formated;
        $this->components = $components;
    }

    public static function fromState(array $state){
        $components=[];

        foreach (ArrayHelper::getValue($state,'Components') as $componentState){
            $kind=ArrayHelper::getValue($componentState,'kind');
            $name=ArrayHelper::getValue($componentState,'name');

            $component=new AddressComponent($kind,$name);

            $components[$kind][]=$component;
        }

        $country_code=ArrayHelper::getValue($state,'country_code');
        $formatted=ArrayHelper::getValue($state,'formatted');

        return new self($country_code,$formatted,$components);
    }

    /**
     * @return string
     */
    public function getCountryCode(): string
    {
        return $this->country_code;
    }

    /**
     * @return string
     */
    public function getFormated(): string
    {
        return $this->formated;
    }

    /**
     * @return AddressComponent[][]
     */
    public function getComponents(): array
    {
        return $this->components;
    }

    public function getKindName($kind){
        if(isset($this->components[$kind])){
            $component=$this->components[$kind][count($this->components[$kind])-1];
            return $component->getName();
        }

        return null;
    }


}