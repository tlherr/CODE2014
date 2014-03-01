<?php

namespace Renegade\Bundle\CarImpactBundle\Entity;

/**
 * Class Vehicle
 * @package Renegade\Bundle\CarImpactBundle\Entity
 */
class Vehicle {
    const FUEL_TYPE_GASOLINE = 1;
    const FUEL_TYPE_DIESEL = 2;
    const FUEL_TYPE_PREMIUM_GASOLINE = 3;
    const FUEL_TYPE_ETHANOL = 4;

    const TRANSMISSION_MANUAL = 'm';
    const TRANSMISSION_AUTO = 'a';

    /**
     * @var int
     */
    protected $id;

    /**
     * @var Make
     */
    protected $make;

    /**
     * @var Model
     */
    protected $model;

    /**
     * @var integer
     */
    protected $year;

    /**
     * @var double
     */
    protected $engineSize;

    /**
     * @var integer
     */
    protected $cylinders;

    /**
     * @var string
     */
    protected $transmissionType;

    /**
     * @var integer
     */
    protected $fuelType;

    /**
     * @var double
     */
    protected $cityMpg;

    /**
     * @var double
     */
    protected $highwayMpg;

    /**
     * @var double
     */
    protected $cityLph;

    /**
     * @var double
     */
    protected $highwayLph;

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param \Renegade\Bundle\CarImpactBundle\Entity\Make $make
     */
    public function setMake($make)
    {
        $this->make = $make;
    }

    /**
     * @return \Renegade\Bundle\CarImpactBundle\Entity\Make
     */
    public function getMake()
    {
        return $this->make;
    }

    /**
     * @param \Renegade\Bundle\CarImpactBundle\Entity\Model $model
     */
    public function setModel($model)
    {
        $this->model = $model;
    }

    /**
     * @return \Renegade\Bundle\CarImpactBundle\Entity\Model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param int $cylinders
     */
    public function setCylinders($cylinders)
    {
        $this->cylinders = $cylinders;
    }

    /**
     * @return int
     */
    public function getCylinders()
    {
        return $this->cylinders;
    }

    /**
     * @param float $engineSize
     */
    public function setEngineSize($engineSize)
    {
        $this->engineSize = $engineSize;
    }

    /**
     * @return float
     */
    public function getEngineSize()
    {
        return $this->engineSize;
    }

    /**
     * @param int $fuelType
     */
    public function setFuelType($fuelType)
    {
        $this->fuelType = $fuelType;
    }

    /**
     * @return int
     */
    public function getFuelType()
    {
        return $this->fuelType;
    }

    /**
     * @param string $transmissionType
     */
    public function setTransmissionType($transmissionType)
    {
        $this->transmissionType = $transmissionType;
    }

    /**
     * @return string
     */
    public function getTransmissionType()
    {
        return $this->transmissionType;
    }

    /**
     * @param int $year
     */
    public function setYear($year)
    {
        $this->year = $year;
    }

    /**
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param float $cityLph
     */
    public function setCityLph($cityLph)
    {
        $this->cityLph = $cityLph;
    }

    /**
     * @return float
     */
    public function getCityLph()
    {
        return $this->cityLph;
    }

    /**
     * @param float $cityMpg
     */
    public function setCityMpg($cityMpg)
    {
        $this->cityMpg = $cityMpg;
    }

    /**
     * @return float
     */
    public function getCityMpg()
    {
        return $this->cityMpg;
    }

    /**
     * @param float $highwayLph
     */
    public function setHighwayLph($highwayLph)
    {
        $this->highwayLph = $highwayLph;
    }

    /**
     * @return float
     */
    public function getHighwayLph()
    {
        return $this->highwayLph;
    }

    /**
     * @param float $highwayMpg
     */
    public function setHighwayMpg($highwayMpg)
    {
        $this->highwayMpg = $highwayMpg;
    }

    /**
     * @return float
     */
    public function getHighwayMpg()
    {
        return $this->highwayMpg;
    }


    /**
     * Return the string value of the current fuel type
     *
     * @return string
     */
    public function getFuelTypeString()
    {
        $types = self::getFuelTypesArray();
        if (array_key_exists($this->getFuelType(), $types)) {
            return $types[$this->getFuelType()];
        }
        return 'Unknown';
    }

    /**
     * Return the string value of the current transmission type
     */
    public function getTransmissionString()
    {
        $types = self::getTransmissionTypesArray();
        if (array_key_exists($this->getTransmissionType(), $types)) {
            return $types[$this->getTransmissionType()];
        }
        return 'Unknown';
    }

    /**
     * Return an array of fuel types keyed by their constant
     *
     * @return array
     */
    static public function getFuelTypesArray()
    {
        return array(
            self::GASOLINE => 'Gasoline',
            self::DIESEL => 'Diesel',
            self::PREMIUM_GASOLINE => 'Premium Gasoline',
            self::ETHANOL => 'Ethanol',
        );
    }

    /**
     * Return an array of transmission types
     *
     * @return array
     */
    static public function getTransmissionTypesArray()
    {
        return array(
            self::TRANSMISSION_AUTO => 'Automatic',
            self::TRANSMISSION_MANUAL => 'Manual',
        );
    }
} 