<?php
namespace BugBuster\BotDetection;

require_once dirname(__FILE__) . '/../src/classes/CheckBotReferrer.php';

if (file_exists(__DIR__ . '/../vendor/autoload.php'))
{
    require_once __DIR__ . '/../vendor/autoload.php';
}
if (file_exists(__DIR__ . '/../../vendor/autoload.php'))
{
    require_once __DIR__ . '/../../vendor/autoload.php';
}
else
{
    require_once __DIR__ . '/../../../../vendor/autoload.php';
}

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
        $_SERVER['HTTP_REFERER'] = 'abcd4.de'; // kennt semalt-blocker nicht, aber eigene Liste
        $return = CheckBotReferrer::checkReferrer(false, dirname(__FILE__) . "/../src/config/bot-referrer-list.php");
        $this->assertTrue($return);
        
        $_SERVER['HTTP_REFERER'] = 'event-tracking.com';
        $return = CheckBotReferrer::checkReferrer(false, dirname(__FILE__) . "/../src/config/bot-referrer-list.php");
        $this->assertTrue($return);
        
        $return = CheckBotReferrer::checkReferrer('abcd4.de', dirname(__FILE__) . "/../src/config/bot-referrer-list.php");
        $this->assertTrue($return);
        
        $return = CheckBotReferrer::checkReferrer('semalt.com/bots.asp', dirname(__FILE__) . "/../src/config/bot-referrer-list.php");
        $this->assertTrue($return);

        $_SERVER['HTTP_REFERER'] = 'joinandplay.me'; // kennt semalt-blocker nicht
        $return = CheckBotReferrer::checkReferrer(false, dirname(__FILE__) . "/../src/config/bot-referrer-list.php");
        $this->assertTrue($return);
        
        $_SERVER['HTTP_REFERER'] = 'mylocal-bugbuster-bot.ninja/bot.php';
        $GLOBALS['BOTDETECTION']['BOT_REFERRER'][] = 'mylocal-bugbuster-bot.ninja';
        $return = CheckBotReferrer::checkReferrer(false, dirname(__FILE__) . "/../src/config/bot-referrer-list.php");
        $this->assertTrue($return);
    }

    /**
     * Tests CheckBotReferrer::checkReferrer() 
     * only for semalt-blocker
     * 
     * @dataProvider providerReferrer
     */
    public function testCheckReferrerBotNew($result, $referrer)
    {
        $return = CheckBotReferrer::checkReferrer($referrer, false);
        //$this->assertTrue($return);
        $this->assertEquals($result,$return);
        //fwrite(STDOUT, "\n TestReferrer: " . $referrer . " ");
        
    }
    public function providerReferrer()
    {
        return array(//result,Referrer
            array(true, '29263731.videos-for-your-business.com'),
            array(true, '4webmasters.org'),
            array(true, 'addons.mozilla.org'),
            array(true, 'amanda-porn.ga'),
            array(true, 'bestwebsitesawards.com'),
            array(true, 'blackhatworth.com'),
            array(true, 'buy-cheap-online.info'),
            array(false, 'buyeasy.com'),    //false = in eigener Liste notwendig
            array(true, 'cenoval.ru'),
            array(true, 'chinese-amezon.com'),
            array(false, 'creativebiz.de'),    //false = in eigener Liste notwendig
            array(true, 'depositfiles-porn.ga'),
            array(false, 'DirectI.com'),    //false = in eigener Liste notwendig
            array(true, 'e-buyeasy.com'),
            array(true, 'erot.co'),
            array(true, 'event-tracking.com'),
            array(false, 'fanyi.baidu.com'),    //false = in eigener Liste notwendig
            array(true, 'floating-share-buttons.com'),
            array(true, 'forum20.smailik.org'),
            array(true, 'free-floating-buttons.com'),
            array(false, 'fx-ray.com'),    //false = in eigener Liste notwendig
            array(true, 'generalporn.org'),
            array(true, 'get-free-social-traffic.com'),
            array(true, 'Get-Free-Traffic-Now.com'),
            array(true, 'googlsucks.com'),
            array(true, 'howtostopreferralspam.eu'),
            array(true, 'hulfingtonpost.com'),
            array(true, 'humanorightswatch.org'),
            array(true, 'ilovevitaly.com'),
            array(true, 'justprofit.xyz'),
            array(true, 'meendo-free-traffic.ga'),
            array(true, 'o-o-6-o-o.com'),
            array(true, 'o-o-8-o-o.com'),
            array(false, 'plaghunter.com'),    //false = in eigener Liste notwendig
            array(true, 'priceg.com'),
            array(true, 'qualitymarketzone.com'),
            array(true, 'rapidgator-porn.ga'),
            array(false, 'resellerclub scam'),    //false = in eigener Liste notwendig
            array(true, 'Resellerclub.com'),
            array(true, 's.click.aliexpress.com'),
            array(true, 'sanjosestartups.com'),
            array(true, 'satellite.maps.ilovevitaly.com'),
            array(true, 'semaltmedia.com'),
            array(true, 'simple-share-buttons.com'),
            array(true, 'site3.free-share-buttons.com'),
            array(true, 'social-buttons.com'),
            array(true, 'theguardlan.com'),
            array(true, 'traffic2money.com'),
            array(true, 'trafficmonetize.org'),
            array(true, 'trafficmonetizer.org'),
            array(true, 'video--production.com'),
            array(false, 'VitalityrulesGoogle'),    //false = in eigener Liste notwendig
            array(false, 'vitaly rules google'),    //false = in eigener Liste notwendig
            array(true, 'webmaster-traffic.com'),
            array(true, 'webmonetizer.net'),
            array(true, 'websites-reviews.com'),
            array(false, 'wpsecuritycheck.co.uk'),    //false = in eigener Liste notwendig
            array(false, 'wpthemedetector.co.uk'),    //false = in eigener Liste notwendig
            array(true, 'youporn-forum.ga'),
            array(true, 'yourserverisdown.com'),
        );
    }
}

