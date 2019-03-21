<?php
/**
 * Created by PhpStorm.
 * User: nicholas.staffend
 * Date: 2/23/2018
 * Time: 10:34 AM
 */

namespace App\Models\HL7Messages;


use App\Interfaces\HL7Processor;

/**
 * Interface HL7Builder
 * @package App\Models\HL7Messages
 * @deprecated
 */
interface HL7Builder
{
    /**
     * @param HL7Processor $processor
     * @return mixed
     */
    public function submit(HL7Processor $processor);

    public function buildHL7Mesage();
}