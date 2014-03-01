<?php

namespace Renegade\Bundle\CarImpactBundle\Entity;

/**
 * Class VehicleModel
 * @package Renegade\Bundle\CarImpactBundle\Entity
 */
class Model {
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $label;

    /**
     * @var Make
     */
    protected $make;

    /**
     * @var string
     */
    protected $canonicalLabel;

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
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $canonicalLabel
     */
    public function setCanonicalLabel($canonicalLabel)
    {
        $this->canonicalLabel = $canonicalLabel;
    }

    /**
     * @return string
     */
    public function getCanonicalLabel()
    {
        return $this->canonicalLabel;
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
     * @return array
     */
    public function serialize()
    {
        return array(
            'id' => $this->id,
            'make_id' => $this->getMake()->getId(),
            'canonical_label' => $this->canonicalLabel,
            'label' => $this->label,
        );
    }
}