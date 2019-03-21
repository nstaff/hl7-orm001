<?php
/**
 * Created by PhpStorm.
 * User: nicholas.staffend
 * Date: 8/30/2018
 * Time: 10:18 AM
 */

namespace NStaff\HL7\Messages;

use Aranyasen\HL7\Message as BaseMessage;
use NStaff\HL7\Segments\OBR;
use NStaff\HL7\Segments\OBX;

/**
 * Class HL7Message
 * Extension of Aranyasen\HL7\Message
 * This extension allows for attachment of OBXs to OBRs in order to work with them intuitively.
 * @package App\Models\HL7Messages
 */
class Message extends BaseMessage
{
    /**
     * Message constructor.
     * @param null $msgStr - The message as a string
     * @param array|null $hl7Globals - Globals. See parent documentation
     * @param bool $keepEmptySubFields - Fields to keep empty
     * @throws \Aranyasen\Exceptions\HL7Exception
     */
    public function __construct($msgStr = null, array $hl7Globals = null, $keepEmptySubFields = false)
    {
        parent::__construct($msgStr, $hl7Globals, $keepEmptySubFields);
        $this->attachORCParents();
    }

    /**
     * Attaches OBXs to their parent OBRs
     */
    public function attachORCParents()
    {
        $OBRIndexes = [];
        $segments = $this->getSegments();
        for ($i = 0; $i < sizeof($segments); $i++) {
            if($segments[$i] instanceof \Aranyasen\HL7\Segments\OBR){
                $OBRIndexes[] = $i;
            }
        }
        for($i = 0; $i < sizeof($OBRIndexes); $i++) {
            $j = $OBRIndexes[$i];
            if (isset($OBRIndexes[$i + 1])) {
                $cap = $OBRIndexes[$i + 1];
            } else {
                $cap = sizeof($segments);
            }
            $obr = new OBR($segments[$OBRIndexes[$i]]->getFields());
            $this->setSegment($obr, $j);
            while ($j < $cap) {
                if($segments[$j]->getName() == 'OBX'){
                    $obx = new OBX($segments[$j]->getFields());
                    $this->setSegment($obx, $j);
                    $obx->setParentObr($obr);
                }
                $j++;
            }
        }
    }
}