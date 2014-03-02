<?php

namespace Renegade\Bundle\CarImpactBundle\Entity;

/**
 * Class VehicleMake
 * @package Renegade\Bundle\CarImpactBundle\Entity
 */
class Make {
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $label;

    /**
     * @var string
     */
    protected $canonicalLabel;

    /**
     * @var Model
     */
    protected $model;

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
     * @return array
     */
    public function serialize()
    {
        return array(
            'id' => $this->id,
            'canonical_label' => $this->canonicalLabel,
            'label' => $this->label,
        );
    }
}