<?php 

/**
 * Contao Open Source CMS, Copyright (C) 2005-2013 Leo Feyer
 *
 * Modul BotDetection - Test
 *
 * @copyright  Glen Langer 2007..2013 <http://www.contao.glen-langer.de>
 * @author     Glen Langer (BugBuster)
 * @package    BotDetectionTest 
 * @license    LGPL 
 * @filesource
 * @see        https://github.com/BugBuster1701/botdetection
 */

/**
 * Aufruf direkt!
 * http://deine-domain.de/system/modules/botdetection/test/ModuleBotDetectionTest.php
 */

/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace BugBuster\BotDetection;

/**
 * Initialize the system
 */
define('TL_MODE', 'FE');
require(dirname(dirname(dirname(dirname(__FILE__)))).'/initialize.php');

/**
 * Class ModuleBotDetectionTest 
 *
 * @copyright  Glen Langer 2007..2013 <http://www.contao.glen-langer.de>
 * @author     Glen Langer (BugBuster)
 * @package    BotDetectionTest
 */
class ModuleBotDetectionTest extends \BugBuster\BotDetection\ModuleBotDetection  
{

	public function run()
	{
	    // AGENT TEST DEFINITIONS
	    
	    $arrTest[] = array(false, false,'your browser'); // own Browser
	    //Browser
	    $arrTest[] = array(false, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; de; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3','Firefox');
	    $arrTest[] = array(false, 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.2; Trident/4.0; Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1);','IE8.0');
	    $arrTest[] = array(false, 'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10.6; de; rv:1.9.2.2) Gecko/20100316 Firefox/3.6.2','Macintosh FF');
	    $arrTest[] = array(false, 'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_3; de-de) AppleWebKit/531.22.7 (KHTML, like Gecko) Version/4.0.5 Safari/531.22.7','Macintosh Safari');
	    //Bots
	    $arrTest[] = array(true, 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)','Googlebot');
	    $arrTest[] = array(true, 'ia_archiver (+http://www.alexa.com/site/help/webmasters; crawler@alexa.com)','Internet Archive');
	    $arrTest[] = array(true, 'Yandex/1.01.001 (compatible; Win16; P)','Yandex');
	    $arrTest[] = array(true, 'Mozilla/5.0 (compatible; Yahoo! Slurp; http://help.yahoo.com/help/us/ysearch/slurp)','Yahoo! Slurp');
	    $arrTest[] = array(true, 'Mozilla/5.0 (compatible; Exabot/3.0; +http://www.exabot.com/go/robot)','Exabot');
	    $arrTest[] = array(true, 'msnbot/2.0b (+http://search.msn.com/msnbot.htm)','MSNbot');
	    $arrTest[] = array(true, 'Mozilla/5.0 (Twiceler-0.9 http://www.cuil.com/twiceler/robot.html)','Twiceler');
	    $arrTest[] = array(true, 'Googlebot-Image/1.0','Googlebot-Image');
	    $arrTest[] = array(true, 'Yeti/1.0 (NHN Corp.; http://help.naver.com/robots/)','NaverBot/Yeti');
	    $arrTest[] = array(true, 'Baiduspider+(+http://www.baidu.com/search/spider.htm)','Baiduspider');
	    $arrTest[] = array(true, 'Mozilla/5.0 (compatible; spbot/2.0.2; +http://www.seoprofiler.com/bot/ )','seoprofiler');
	    $arrTest[] = array(true, 'ia_archiver-web.archive.org','ia_archiver-web.archive.org');
	    $arrTest[] = array(true, 'Mozilla/5.0 (compatible; archive.org_bot +http://www.archive.org/details/archive.org_bot)','Internet Archiv');

	    $arrTest[] = array(true, 'msnbot-media/1.1 (+http://search.msn.com/msnbot.htm)','MSNbot-media');
	    $arrTest[] = array(true, 'Mozilla/5.0 (compatible; Ask Jeeves/Teoma; +http://about.ask.com/en/docs/about/webmasters.shtml)','Ask Jeeves/Teoma');
	    $arrTest[] = array(true, 'TrueKnowledgeBot (http://www.trueknowledge.com/tkbot/; tkbot -AT- trueknowledge _dot_ com)','TrueKnowledgeBot');
	    $arrTest[] = array(true, 'Mozilla/5.0 (compatible; ptd-crawler; +http://bixolabs.com/crawler/ptd/; crawler@bixolabs.com)','ptd-crawler bixolabs.com');
		$arrTest[] = array(true, 'Cityreview Robot (+http://www.cityreview.org/crawler/)','Cityreview Robot');
		$arrTest[] = array(true, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9) Gecko/2008052906 Firefox/3.0/1.0 (bot; http://)','No-Name-Bot');
		$arrTest[] = array(true, 'Mozilla/5.0 (en-us) AppleWebKit/525.13 (KHTML, like Gecko; Google Web Preview) Version/3.1 Safari/525.13','Google Web Preview');
		
		$arrTest[] = array(true, 'Mozilla/5.0 (compatible; Spiderlytics/1.0; +spider@spiderlytics.com)','Spiderlytics');
		$arrTest[] = array(true, 'ExB Language Crawler 2.1.5 (+http://www.exb.de/crawler)','ExB Language Crawler');
		$arrTest[] = array(true, 'coccoc/1.0 (http://help.coccoc.com/)','coccoc');
		$arrTest[] = array(true, 'Mozilla/5.0 (compatible; SiteExplorer/1.0b; +http://siteexplorer.info/)','SiteExplorer');
		$arrTest[] = array(true, 'iBusiness Shopcrawler','Shopcrawler');
		
		$arrTest[] = array(true, 'Mozilla/5.0 (compatible; BLEXBot/1.0; +http://webmeup.com/crawler.html)','BLEXBot');
		$arrTest[] = array(true, 'ExB Language Crawler 2.1.5 (+http://www.exb.de/crawler)','ExB Language Crawler');
		$arrTest[] = array(true, 'it2media-domain-crawler/1.0 on crawler-prod.it2media.de','www.adressendeutschland.de');
		$arrTest[] = array(true, 'Mozilla/5.0 (compatible; emefgebot/beta; +http://emefge.de/bot.html)','emefgebot');
		$arrTest[] = array(true, 'Mozilla/5.0 (compatible; CompSpyBot/1.0; +http://www.compspy.com/spider.html)','CompSpyBot');
		$arrTest[] = array(true, 'NCBot (http://netcomber.com : tool for finding true domain owners) Queries/complaints: bot@netcomber.com','NCBot');
		$arrTest[] = array(true, 'Mozilla/5.0 (compatible; Abonti/0.91 - http://www.abonti.com)','Abonti');
		$arrTest[] = array(true, 'HubSpot Connect 1.0 (http://dev.hubspot.com/)','HubSpot');
		$arrTest[] = array(true, 'Mozilla/5.0 (compatible; meanpathbot/1.0; +http://www.meanpath.com/meanpathbot.html)','Meanpathbot');
		$arrTest[] = array(true, 'Mozilla/5.0 (compatible; IstellaBot/1.10.2 +http://www.tiscali.it/)','IstellaBot');
		$arrTest[] = array(true, 'Mozilla/5.0 (compatible; Genieo/1.0 http://www.genieo.com/webfilter.html)','Genieo');
		$arrTest[] = array(true, 'Cliqz Bot (+http://www.cliqz.com)','Cliqz Bot');
		$arrTest[] = array(true, 'BUbiNG (+http://law.di.unimi.it/BUbiNG.html)','BUbiNG');
		$arrTest[] = array(true, 'Mozilla/5.0 (compatible; proximic; +http://www.proximic.com/info/spider.php)','Proximic');
		$arrTest[] = array(true, 'Mozilla/5.0 (compatible; NetSeer crawler/2.0; +http://www.netseer.com/crawler.html; crawler@netseer.com)','NetSeer');
		// localconfig Test
		$GLOBALS['BOTDETECTION']['BOT_AGENT'][] = array("Mozilla/5.0 (X11; U; Linux; en-US) AppleWebKit/531.2 (KHTML, like Gecko) Safari/531.2 localconfig","localconfig Bot");
		$arrTest[] = array(true, 'Mozilla/5.0 (X11; U; Linux; en-US) AppleWebKit/531.2 (KHTML, like Gecko) Safari/531.2 localconfig','localconfig Bot');
		
		//Output
	    echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="de">
<body>';
		echo '<div>';
			echo '<div style="float:left;width:50%;font-family:Verdana,sans-serif;font-size: 12px;">';
				$this->CheckBotAgentTest($arrTest);
			echo '</div>';
			echo '<div style="float:left;width:50%;font-family:Verdana,sans-serif;font-size: 12px;">';
				$this->CheckBotAgentAdvancedTest($arrTest);
			echo '</div>';
		echo '</div>';
		echo '<div style="clear:both;font-family:Verdana,sans-serif;font-size: 12px;"><br>';
			$this->CheckBotIPTest();
		echo '</div>';
		echo '<div style="clear:both;font-family:Verdana,sans-serif;font-size: 12px;"><br>';
		    $this->CheckBotAllTestsTest();
		echo '</div>';
		echo "<h2>ModuleBotDetection Version: ".$this->getVersion()."</h2>";
		echo "</body></html>";
	} 
	
	private function CheckBotAgentTest($arrTest)
	{
	    echo "<h1>CheckBotAgentTest</h1>";

	    $y=count($arrTest);
	    for ($x=0; $x<$y; $x++)
	    {
	        $result[$x] = $this->BD_CheckBotAgent($arrTest[$x][1]);
	    }
	    for ($x=0; $x<$y; $x++)
	    {
	        $nr = ($x<10) ? "&nbsp;".$x : $x;
	        if ($arrTest[$x][0] == $result[$x]) {
	        	echo '<span style="color:green;">';
	        } else 
	        {
	            echo '<span style="color:red;">';
	        }
	        echo "TestNr: ". $nr ."&nbsp;&nbsp;Expectation/Result: ".var_export($arrTest[$x][0],true)."/".var_export($result[$x],true)." (".$arrTest[$x][2].")";
	        echo "</span><br>";
	    }
		
		return true;
	}
	
	private function CheckBotIPTest()
	{
	    echo "<h1>CheckBotIPTest</h1>";
	    $arrTest[] = array(false,false,'own IP');
	    $arrTest[] = array(false,'74.125.79.100','74.125.79.100 - Google Plus');
	    $arrTest[] = array(true,'192.114.71.13','192.114.71.13 - web spider israel');
	    $arrTest[] = array(true,'65.55.231.74','65.55.231.74 in 65.52.0.0/14 - MSN Net');
	    $arrTest[] = array(true,'66.249.95.222','66.249.95.222 in 66.249.64.0/19 - Google Net');
	    $arrTest[] = array(true,'2001:4860:4801:1109:0:6006:1300:b075','2001:4860:4801:1109:0:6006:1300:b075 - Google Bot IPv6');
	    $arrTest[] = array(false,'2001:0db8:85a3:08d3:1319:8a2e:0370:7334','2001:0db8:85a3:08d3:1319:8a2e:0370:7334 - No Bot');
	    $arrTest[] = array(false,'2001:0db8:85a3:08d3:1319:8a2e:0370:7334','2001:0db8:85a3:08d3:1319:8a2e:0370:7334 - No Bot');
	    $arrTest[] = array(false,'::ffff:c000:280','::ffff:c000:280 - double quad notation for ipv4 mapped addresses');
	    $arrTest[] = array(false,'::ffff:192.0.2.128','::ffff:192.0.2.128 - double quad notation for ipv4 mapped addresses');
	    
	    $y=count($arrTest);
	    for ($x=0; $x<$y; $x++)
	    {
	        $result[$x] = $this->BD_CheckBotIP($arrTest[$x][1]);
	    }
	    for ($x=0; $x<$y; $x++)
	    {
	        $nr = ($x<10) ? "&nbsp;".$x : $x;
	        if ($arrTest[$x][0] == $result[$x]) {
	        	echo '<span style="color:green;">';
	        } else 
	        {
	            echo '<span style="color:red;">';
	        }
	        echo "TestNr: ". $nr ."&nbsp;&nbsp;Expectation/Result: ".var_export($arrTest[$x][0],true)."/".var_export($result[$x],true)." (".$arrTest[$x][2].")";
	        echo "</span><br>";
	    }

	    return true;
	}
	
	private function CheckBotAgentAdvancedTest($arrTest)
	{
	    echo "<h1>CheckBotAdvancedTest</h1>";
	    $y=count($arrTest);
	    for ($x=0; $x<$y; $x++)
	    {
	        $result[$x] = $this->BD_CheckBotAgentAdvanced($arrTest[$x][1]);
	    }
	    for ($x=0; $x<$y; $x++)
	    {
	        $nr = ($x<10) ? "&nbsp;".$x : $x;
	        if ($arrTest[$x][0] == $result[$x]) {
	        	echo '<span style="color:green;">';
	        } else 
	        {
	            echo '<span style="color:red;">';
	        }
	        echo "TestNr: ". $nr ."&nbsp;&nbsp;Expectation/Result: ".var_export($arrTest[$x][0],true)."/".var_export($result[$x],true)." (".$arrTest[$x][2].")";
	        echo "</span><br>";
	    }
	
		return true;
	}
	
	private function CheckBotAllTestsTest()
	{
	    echo "<h1>CheckBotAllTest</h1>";
	    $arrTest[0] = 'your browser, false test';
	    $arrTest[1] = 'CheckBotAgent test';
	    $arrTest[2] = 'CheckBotAgentAdvanced test';
	    $arrTest[3] = 'CheckBotIP test';
	    $result[0] = !$this->BD_CheckBotAllTests();
	    $result[1] = $this->BD_CheckBotAllTests('Spider test'); //BD_CheckBotAgent = true 
	    $result[2] = $this->BD_CheckBotAllTests('acadiauniversitywebcensusclient'); //BD_CheckBotAgentAdvanced = true
	    //set own IP as Bot IP
	    if (\Environment::get('remoteAddr'))
	    {
	        if (strpos(\Environment::get('remoteAddr'), ',') !== false) //first IP
	        {
                $GLOBALS['TL_BOTDETECTION']['BOT_IP'][] =  trim(substr(\Environment::get('remoteAddr'), 0, strpos(\Environment::get('remoteAddr'), ',')));
	        }
	        else
	        {
   				$GLOBALS['TL_BOTDETECTION']['BOT_IP'][] = trim(\Environment::get('remoteAddr'));
	        }
	        $result[3] = $this->BD_CheckBotAllTests(); //BD_CheckBotIP = true
	    }
	    //output
	    for ($x=0; $x<4; $x++)
	    {
    	    $nr = ($x<10) ? "&nbsp;".$x : $x;
            if (true == $result[$x]) 
            {
	            echo '<span style="color:green;">';
	        } 
	        else
	        {
	            echo '<span style="color:red;">';
	        }
	        echo "TestNr: ". $nr ."&nbsp;&nbsp;Expectation/Result: true/".var_export($result[$x],true)." (".$arrTest[$x].")";
            echo "</span><br>";
	    }
	    	    
	}
} // class

/**
 * Instantiate controller
 */
$objBotDetectionTest = new ModuleBotDetectionTest();
$objBotDetectionTest->run();

?>