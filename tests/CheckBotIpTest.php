<?php
namespace BugBuster\BotDetection;

require_once dirname(__FILE__) . '/../src/classes/CheckBotIp.php';


/**
 * CheckBotIp test case.
 */
class CheckBotIpTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        CheckBotIp::setBotIpv4List(dirname(__FILE__) . "/bot-ip-list-ipv4.txt");
        CheckBotIp::setBotIpv6List(dirname(__FILE__) . "/bot-ip-list-ipv6.txt");
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {        
        parent::tearDown();
    }

    /**
     * Tests CheckBotIp::getBotIpv4List()
     */
    public function testGetBotIpv4List()
    {
        $return = CheckBotIp::getBotIpv4List();
        $this->assertEquals(dirname(__FILE__) . "/bot-ip-list-ipv4.txt", $return);
    }

    /**
     * Tests CheckBotIp::getBotIpv6List()
     */
    public function testGetBotIpv6List()
    {
        $return = CheckBotIp::getBotIpv6List();
        $this->assertEquals(dirname(__FILE__) . "/bot-ip-list-ipv6.txt", $return);
    }

    /**
     * Tests CheckBotIp::checkPrivateIP()
     */
    public function testCheckPrivateIP()
    {
        $method = new \ReflectionMethod(
                    //Class , Method
                'BugBuster\BotDetection\CheckBotIp', 'checkPrivateIP'
        );
        $method->setAccessible(TRUE);
        
        $return = $method->invoke(new CheckBotIp,false);
        $this->assertTrue($return);
        
        $return = $method->invoke(new CheckBotIp,'66.249.64.10');
        $this->assertFalse($return);
        
        $return = $method->invoke(new CheckBotIp,'2001:4860:4801:1109:0:6006:1300:b075');
        $this->assertFalse($return);
        
        $return = $method->invoke(new CheckBotIp,'192.168.17.01');
        $this->assertTrue($return);
        
        $return = $method->invoke(new CheckBotIp,'fe80::a00:27ff:fe1a:672a');
        $this->assertTrue($return);
    }
    
    /**
     * Tests CheckBotIp::checkIP()
     */
    public function testCheckIP4()
    {
        $return = CheckBotIp::checkIP('192.168.1701.0' /* wrong IP */);
        $this->assertFalse($return);
        
        $return = CheckBotIp::checkIP('192.168.17.01' /* IPv4 no Bot */);
        $this->assertFalse($return);
        
        $return = CheckBotIp::checkIP('192.114.71.13' /* IPv4 Bot */);
        $this->assertTrue($return);
        
        $return = CheckBotIp::checkIP('66.249.95.222' /* IPv4 Bot in Net*/);
        $this->assertTrue($return);
        
        $GLOBALS['TL_BOTDETECTION']['BOT_IP'][] = '192.168.1.2';
        $GLOBALS['BOTDETECTION']['BOT_IP'][]    = '192.168.2.0/24';

        $return = CheckBotIp::checkIP('192.168.1.2' /* IPv4 Bot */);
        $this->assertTrue($return);
        
        $return = CheckBotIp::checkIP('192.168.2.2' /* IPv4 Bot */);
        $this->assertTrue($return);
        
        $return = CheckBotIp::checkIP('192.168.3.2' /* No IPv4 Bot */);
        $this->assertFalse($return);
        
    }
    
    /**
     * Tests CheckBotIp::checkIP()
     */
    public function testCheckIP6()
    {
        $return = CheckBotIp::checkIP('2001:4860:4801:1109:0:6006:1300:b075' /* IPv6 Bot */);
        $this->assertTrue($return);
    
        $return = CheckBotIp::checkIP('2001:0db8:85a3:08d3:1319:8a2e:0370:7334' /* IPv6 no Bot */);
        $this->assertFalse($return);
    
        $return = CheckBotIp::checkIP('::ffff:c000:280' /* double quad notation for ipv4 mapped addresses */);
        $this->assertFalse($return);
    
        $return = CheckBotIp::checkIP('::ffff:192.0.2.128' /* double quad notation for ipv4 mapped addresses */);
        $this->assertFalse($return);
        
        $GLOBALS['BOTDETECTION']['BOT_IPV6'][] = '2001:0db8::1'; 
        $GLOBALS['BOTDETECTION']['BOT_IPV6'][] = '2001:0db8:85a3:0800::/56';
        
        $return = CheckBotIp::checkIP('2001:0db8::1' /* IPv6 Bot */);
        $this->assertTrue($return);
        
        $return = CheckBotIp::checkIP('2001:db8:85a3:800::37' /* IPv6 Bot */);
        $this->assertTrue($return);
        
        $return = CheckBotIp::checkIP('2001:db8:85a3:900::37' /* IPv6 no Bot */);
        $this->assertFalse($return);
        
    }
}

