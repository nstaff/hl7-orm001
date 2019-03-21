<?php
/**
 * Created by PhpStorm.
 * User: nicholas.staffend
 * Date: 8/30/2018
 * Time: 10:44 AM
 */

namespace NStaff\HL7\Segments;

use Aranyasen\HL7\Segments\OBX as BaseObx;

    /**
 * Class OBX
 * @package App\Models\HL7Messages
 */
class OBX extends BaseObx
{
    protected $parentObr;
    public const OBSERVATION_TYPE_FIELD = 4;
    public const OBSERVATION_RESULT_FIELD = 6;

    /**
     * Returns the OBR that this OBX is bound to
     * @return mixed
     */
    public function getParentObr()
    {
        return $this->parentObr;
    }

    /**
     * Binds to an OBR
     * @param mixed $parentObr
     */
    public function setParentObr(OBR $parentObr)
    {
        if($this->parentObr != null){
            $this->parentObr->removeObx($this);
        }
        $this->parentObr = $parentObr;
        $parentObr->addOBX($this);
    }

    /**
     * Gets the type of this OBX
     * @return mixed
     */
    public function getType()
    {
        return $this->getField(OBX::OBSERVATION_TYPE_FIELD)[0];
    }

    /**
     * Returns the observation result for this OBX
     * @return array|null|string
     */
    public function getValue()
    {
        return $this->getField(OBX::OBSERVATION_RESULT_FIELD);
    }
}