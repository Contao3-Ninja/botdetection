<?php

namespace BugBuster\BotDetection;

require_once dirname(__FILE__) . '/../src/classes/BrowscapCache.php';

if (file_exists(__DIR__ . '/../vendor/autoload.php')) 
{
    require_once __DIR__ . '/../vendor/autoload.php';
}
else 
{
    require_once __DIR__ . '/../../../../vendor/autoload.php';
}

function delTree($dir) 
{
    $files = array_diff(scandir($dir), array('.','..'));
    foreach ($files as $file)
    {
        (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
    }
}

/**
 * BrowscapCache test case.
 */
class BrowscapCacheTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var BrowscapCache
     */
    private $BrowscapCache;

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
     * Tests BrowscapCache::generateBrowscapCache()
     */
    public function testGenerateBrowscapCache ()
    {
        $cachdir = __DIR__ . '/../src/cache';
        $return  = false;
        $proxy   = false;
        
        
        if (isset($_SERVER["HTTP_PROXY"])) 
        {
            $proxy = parse_url($_SERVER["HTTP_PROXY"]);
        }
        elseif (isset($_SERVER["http_proxy"])) 
        {
            $proxy = parse_url($_SERVER["http_proxy"]);
        }
        
        if ($proxy) 
        {
            $arrProxy = array('ProxyHost' => $proxy['host']
                             ,'ProxyPort' => $proxy['port']);
            fwrite(STDOUT, 'Using ProxyHost: '.$proxy['host']    . "\n");
            fwrite(STDOUT, 'Using ProxyPort: '.$proxy['port']  . "\n\n");
        }
        else
        {
            $arrProxy = false;
            fwrite(STDOUT, 'If a proxy server is required to access the internet,'. "\n");
            fwrite(STDOUT, 'define the environment variable HTTP_PROXY'           . "\n");
            fwrite(STDOUT, '(export HTTP_PROXY=http://192.168.17.01:3128)'      . "\n\n");
        }
        //delete the cache
        //delTree($cachdir);
        //fwrite(STDOUT, 'Cache deleted, now generate the cache ...'. "\n");
        
        $return = BrowscapCache::generateBrowscapCache(false, $arrProxy);
        
        if (!file_exists($cachdir . '/largebrowscap.version'))
        { 
            fwrite(STDOUT, $cachdir . '/largebrowscap.version not found'. "\n");
        }
        else
        {
            fwrite(STDOUT, 'Cache generated'. "\n");
        }
        $this->assertEquals('true', $return); 
        
    
    }

}

