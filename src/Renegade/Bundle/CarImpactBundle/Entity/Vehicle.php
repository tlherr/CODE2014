<?php

namespace Renegade\Bundle\CarImpactBundle\Entity;

/**
 * Class Vehicle
 * @package Renegade\Bundle\CarImpactBundle\Entity
 */
class Vehicle {
    const FUEL_TYPE_GASOLINE = 'X';
    const FUEL_TYPE_DIESEL = 'D';
    const FUEL_TYPE_PREMIUM_GASOLINE = 'Z';
    const FUEL_TYPE_ETHANOL = 'E';
    const FUEL_TYPE_NATURAL_GAS = 'N';

    const TRANSMISSION_AUTOMATED_MANUAL = 'AM';
    const TRANSMISSION_AUTOMATIC_SELECT = 'AS';
    const TRANSMISSION_VARIABLE = 'AV';
    const TRANSMISSION_MANUAL = 'M';
    const TRANSMISSION_AUTOMATIC = 'A';

    /**
     * @var int
     */
    protected $id;

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
     * @var bool
     */
    protected $highOutputEngine;

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

    function __construct()
    {
        $this->highOutputEngine = false;
    }


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
     * @param boolean $highOutputEngine
     */
    public function setHighOutputEngine($highOutputEngine)
    {
        $this->highOutputEngine = $highOutputEngine;
    }

    /**
     * @return boolean
     */
    public function getHighOutputEngine()
    {
        return $this->highOutputEngine;
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
            self::FUEL_TYPE_GASOLINE => 'Gasoline',
            self::FUEL_TYPE_PREMIUM_GASOLINE => 'Premium Gasoline',
            self::FUEL_TYPE_DIESEL => 'Diesel',
            self::FUEL_TYPE_ETHANOL => 'Ethanol',
            self::FUEL_TYPE_NATURAL_GAS => 'Natural Gas',
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
            self::TRANSMISSION_AUTOMATIC => 'Automatic',
            self::TRANSMISSION_MANUAL => 'Manual',
            self::TRANSMISSION_VARIABLE => 'Continuously Variable',
            self::TRANSMISSION_AUTOMATIC_SELECT => 'Automatic with Select Shift',
            self::TRANSMISSION_AUTOMATED_MANUAL => 'Automated Manual',
        );
    }

    /**
     * Check if specified fuel type is valid
     * @param $type
     * @return bool
     */
    static public function isValidFuelType($type)
    {
        $types = Vehicle::getFuelTypesArray();
        return array_key_exists($type, $types);
    }

    /**
     * Check if the specified transmission type is valid
     *
     * @param $type
     * @return bool
     */
    static public function isValidTransmissionType($type)
    {
        $types = Vehicle::getTransmissionTypesArray();
        return array_key_exists($type, $types);
    }

    public function serialize()
    {
        return array(
            'id' => $this->id,
            'year' => $this->year,
            'engine_size' => $this->engineSize,
            'transmission' => $this->transmissionType,
            'transmission_string' => $this->getTransmissionString(),
            'cylinders' => $this->cylinders,
            'fuel_type' => $this->fuelType,
            'fuel_type_string' => $this->getFuelTypeString(),
            'mileage' => array(
                'highway' => array(
                    'mpg' => $this->highwayMpg,
                    'lph' => $this->highwayLph,
                ),
                'city' => array(
                    'mpg' => $this->cityMpg,
                    'lph' => $this->cityLph,
                ),
            ),
        );
    }
} 