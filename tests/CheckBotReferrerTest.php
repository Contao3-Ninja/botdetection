<?php
namespace BugBuster\BotDetection;

require_once dirname(__FILE__) . '/../src/classes/CheckBotReferrer.php';

/**
 * CheckBotReferrer test case.
 */
class CheckBotReferrerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var CheckBotReferrer
     */
    private $CheckBotReferrer;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp ()
    {
        parent::setUp();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown ()
    {
        parent::tearDown();
    }

    /**
     * Constructs the test case.
     */
    public function __construct ()
    {
        // Auto-generated constructor
    }

    /**
     * Tests CheckBotReferrer::checkReferrer()
     */
    public function testCheckReferrerOff ()
    {
        $return = CheckBotReferrer::checkReferrer('acme.com'/*, without Referrer-List */); 
        $this->assertFalse($return);
        
        $return = CheckBotReferrer::checkReferrer(false, dirname(__FILE__) . "/../src/config/bot-referrer-list.php");
        $this->assertFalse($return);    
        
        $return = CheckBotReferrer::checkReferrer(false, 'notfound.php');
        $this->assertFalse($return);
    }
    
    /**
     * Tests CheckBotReferrer::checkReferrer()
     */
    public function testCheckReferrerNoBot ()
    {
        $return = CheckBotReferrer::checkReferrer('acme.com', dirname(__FILE__) . "/../src/config/bot-referrer-list.php");
        $this->assertFalse($return);
    
        $_SERVER['HTTP_REFERER'] = 'acme.com';
        $return = CheckBotReferrer::checkReferrer(false, dirname(__FILE__) . "/../src/config/bot-referrer-list.php");
        $this->assertFalse($return);
        
        $return = CheckBotReferrer::checkReferrer('wrongdomain', dirname(__FILE__) . "/../src/config/bot-referrer-list.php");
        $this->assertFalse($return);
    }
    
    /**
     * Tests CheckBotReferrer::checkReferrer()
     */
    public function testCheckReferrerBot ()
    {
        $return = CheckBotReferrer::checkReferrer('abcd4.de', dirname(__FILE__) . "/../src/config/bot-referrer-list.php");
        $this->assertEquals('abcd4.de', $return);
    
        $_SERVER['HTTP_REFERER'] = 'abcd4.de';
        $return = CheckBotReferrer::checkReferrer(false, dirname(__FILE__) . "/../src/config/bot-referrer-list.php");
        $this->assertEquals('abcd4.de', $return);
        
        $return = CheckBotReferrer::checkReferrer('semalt.com', dirname(__FILE__) . "/../src/config/bot-referrer-list.php");
        $this->assertEquals('semalt.com', $return);
        
    }

}

