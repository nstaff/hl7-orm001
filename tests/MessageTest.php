<?php

namespace NStaff\HL7\Tests;

use Aranyasen\Exceptions\HL7Exception;
use NStaff\HL7\Messages\Message;

/**
 * Created by PhpStorm.
 * User: nicholas.staffend
 * Date: 3/21/2019
 * Time: 12:56 PM
 */

class MessageTest extends TestCase
{
    /**
     * @test
     */
    public function testMessage()
    {
        $message = $this->buildMessage();
        // If no exception was thrown then this is complete, assert true is true to denote no failure
        $this->assertTrue(true, 'Message Creation Success');

        $obrs = $message->getSegmentsByName('OBR');
        $this->assertSame(count($obrs), 2, 'Number of OBRs in message');
        foreach ($obrs as $obr) {
            $obxs = $obr->getOBXs();

            self::assertSame($obxs[1]->getValue(), $obr->getTestCode());
        }
    }

    protected function buildMessage(): Message
    {
        $message = "MSH|^~\\&|Application|Sender^Sender|Receiver|Receiver|20180913195139||ORM^O01|1|P|2.3|1|||AL|U.S.A\rPID|1||||||\rPV1|1|||||||||\rORC|NW|12|||||20180913195139||20180913195139|^||1234^LAST^FIRST^R^APRN^^^NPI\rOBR|1|12||TEST1^NAME ON TEST1^L|||201809131951|||||||201809131951||1234^LAST^FIRST^R^APRN^^^NPI\rOBX|1||SOURCE^Specimen Source||BLUD\rOBX|2||TEST||TEST1\rOBX|3||ACCT^ACCT Account Number||123number\rORC|NW|12|||||20180913195139||20180913195139|||1234^LAST^FIRST^R^APRN^^^NPI\rOBR|2|12||TEST2^NAME ON TEST2^L|||201809131951|||||||201809131951||1234^LAST^FIRST^R^APRN^^^NPI\rOBX|1||SOURCE^Specimen Source||URNE\rOBX|2||TEST||TEST2\rOBX|17||ACCT^ACCT Account Number||123number";
        try {
            $msg = new Message($message, null, true);
            return $msg;
        } catch (HL7Exception $e) {
            $this->fail('HL7Message Exception');
        }
    }


}