<?php
/**
 * Created by PhpStorm.
 * User: nicholas.staffend
 * Date: 8/30/2018
 * Time: 10:45 AM
 */

namespace NStaff\HL7\Segments;

use Aranyasen\HL7\Segments\OBR as BaseObr;

/**
 * Class OBR
 * Creates parent/Child relationship with OBXs
 * @package App\Models\HL7Messages
 */
class OBR extends BaseObr
{
    protected $OBXs;

    /**
     * @return array
     */
    public function getOBXs(): array
    {
        return $this->OBXs;
    }

    /**
     * OBR constructor.
     * @param array|null $fields
     */
    public function __construct(array $fields = null)
    {
        parent::__construct($fields);
        $this->OBXs = [];
    }

    /**
     * Binds an OBX to this OBR
     * @param $obx
     */
    public function addOBX($obx)
    {
        $this->OBXs[] = $obx;
    }

    /**
     * Deletes an OBX from this OBR
     * @param OBX $OBX
     */
    public function removeOBX(OBX $OBX)
    {
        foreach ($this->OBXs as $key => $child) {
            if ($child == $OBX) {
                unset($this->OBXs[$key]);
                return;
            }
        }
    }

    /**
     * Retreives the ordering provider from this OBR
     * @param int $position
     * @return array|null|string
     */
    public function getOrderingProvider(int $position = 17)
    {
        return $this->getField($position);
    }

    /**
     * @return mixed
     */
    public function getOrderingProviderFirst()
    {
        if(!isset($this->getOrderingProvider()[2])){
            return $this->getOrderingProvider()[1];
        }
        return $this->getOrderingProvider()[2];
    }

    /**
     * @return mixed
     */
    public function getOrderingProviderLast()
    {
        if(!isset($this->getOrderingProvider()[2])){
            return $this->getOrderingProvider()[0];
        }
        return $this->getOrderingProvider()[1];
    }

    /**
     * Gets the Lab Test Code (ex: FLUPCR) specifying which test is ordered in this OBR
     * @return mixed
     */
    public function getTestCode()
    {
        return $this->getField(5)[0];
    }

    /**
     * Gets the full name of the lab test ordered
     * @return mixed
     */
    public function getTestName()
    {
        return $this->getField(5)[1];
    }
}