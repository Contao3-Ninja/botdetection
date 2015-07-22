<?php

namespace BugBuster\BotDetection;

require_once dirname(__FILE__) . '/../src/classes/BrowscapCache.php';

if (file_exists(__DIR__ . '/../vendor/autoload.php')) 
{
    require_once __DIR__ . '/../vendor/autoload.php';
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
        
        //delete the cache
        delTree($cachdir);
        fwrite(STDOUT, 'Cache deleted, now generate the cache ...'. "\n");
  
        BrowscapCache::generateBrowscapCache(true); //TODO Proxy Daten als Parameter
        fwrite(STDOUT, 'Cache generated'. "\n");
        if (file_exists($cachdir . '/largebrowscap.version')) 
        {
            $return = true;
        }
        else
        {
            fwrite(STDOUT, $cachdir . '/largebrowscap.version not found'. "\n");
        }
        $this->assertTrue($return); 
        
    
    }

}

