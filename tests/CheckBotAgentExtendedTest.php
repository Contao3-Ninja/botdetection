<?php

namespace BugBuster\BotDetection;

require_once dirname(__FILE__) . '/../src/classes/CheckBotAgentExtended.php';

if (file_exists(__DIR__ . '/../vendor/autoload.php'))
{
    require_once __DIR__ . '/../vendor/autoload.php';
}
else
{
    require_once __DIR__ . '/../../../../vendor/autoload.php';
}


/**
 * CheckBotAgentExtended test case.
 */
class CheckBotAgentExtendedTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var CheckBotAgentExtended
     */
    private $CheckBotAgentExtended;

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
     * Tests CheckBotAgentExtended::checkAgent()
     */
    public function testCheckAgent ()
    {
        $return = CheckBotAgentExtended::checkAgent(/* parameters */);
        $this->assertFalse($return);
        
        $return = CheckBotAgentExtended::checkAgent('    ');
        $this->assertFalse($return);
        
        /* no Bot */
        $return = CheckBotAgentExtended::checkAgent('Mozilla/5.0 (Windows; U; Windows NT 5.1; de; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3');
        $this->assertFalse($return);
        
        /* Bot */
        $return = CheckBotAgentExtended::checkAgent('Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)');
        $this->assertTrue($return);
        
        /* Bot */
        // Kennt Browscap nicht, aber die eigene Liste
        $return = CheckBotAgentExtended::checkAgent('iBusiness Shopcrawler'); 
        $this->assertTrue($return);
    }

    /**
     * Tests CheckBotAgentExtended::checkAgentName()
     */
    public function testCheckAgentName ()
    {
        /* Google Bot over Browscap */
        $return = CheckBotAgentExtended::checkAgentName('Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)');
        $this->assertEquals('Google Bot', $return);
        
        /* Shopcrawler over bot-agent-list */
        $return = CheckBotAgentExtended::checkAgentName('iBusiness Shopcrawler');
        $this->assertEquals('Shopcrawler', $return);
    }

}
