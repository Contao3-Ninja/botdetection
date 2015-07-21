<?php

namespace BugBuster\BotDetection;

require_once dirname(__FILE__) . '/../src/classes/CheckBotAgentSimple.php';

/**
 * CheckBotAgentSimple test case.
 */
class CheckBotAgentSimpleTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * Tests CheckBotAgentSimple::checkAgent()
     */
    public function testCheckAgentEnvironment()
    {
        $return = CheckBotAgentSimple::checkAgent(/* parameters */);
        $this->assertFalse($return);
        
        $return = CheckBotAgentSimple::checkAgent('    ');
        $this->assertFalse($return);
        
    }
    
    /**
     * Tests CheckBotAgentSimple::checkAgent()
     */
    public function testCheckAgentRough()
    {
        /* no Bot */
        $return = CheckBotAgentSimple::checkAgent('Mozilla/5.0 (Windows; U; Windows NT 5.1; de; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3');
        $this->assertFalse($return);
        
        /* Bot */
        $return = CheckBotAgentSimple::checkAgent('Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)');
        $this->assertTrue($return);
        
        /* Bot */
        $return = CheckBotAgentSimple::checkAgent('iBusiness Shopcrawler');
        $this->assertTrue($return);        
    }
    
    /**
     * Tests CheckBotAgentSimple::checkAgent()
     */
    public function testCheckAgentFine()
    {
        /* Bot */
        $return = CheckBotAgentSimple::checkAgent('coccoc/1.0 (http://help.coccoc.com/)');
        $this->assertTrue($return);
    
        /* Bot */
        $return = CheckBotAgentSimple::checkAgent('Mechanize/2.0.1 Ruby/1.9.2p290 (http://github.com/tenderlove/mechanize/)');
        $this->assertTrue($return);
        
        /* Bot */
        $return = CheckBotAgentSimple::checkAgent('MetaURI API/2.0 +metauri.com');
        $this->assertTrue($return);
    }
    
    /**
     * Tests CheckBotAgentSimple::checkAgent()
     */
    public function testCheckAgentGlobals()
    {
        $GLOBALS['BOTDETECTION']['BOT_AGENT'][] = array("myprivate","My private bot");
        $return = CheckBotAgentSimple::checkAgent('myprivate');
        $this->assertTrue($return);
        
        unset($GLOBALS['BOTDETECTION']['BOT_AGENT']);
        $GLOBALS['BOTDETECTION']['BOT_AGENT'][] = array("my browser","My Browser");
        $return = CheckBotAgentSimple::checkAgent('myprivate');
        $this->assertFalse($return);
    }
    
}

