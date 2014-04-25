<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Magento
 * @package     Magento
 * @subpackage  integration_tests
 * @copyright   Copyright (c) 2014 X.commerce, Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace Magento\Test\Profiler;


/**
 * Test class for \Magento\TestFramework\Profiler\OutputBamboo.
 */
require_once __DIR__ . '/OutputBambooTestFilter.php';
class OutputBambooTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Magento\TestFramework\Profiler\OutputBamboo
     */
    protected $_output;

    public static function setUpBeforeClass()
    {
        stream_filter_register('dataCollectorFilter', 'Magento\Test\Profiler\OutputBambooTestFilter');
    }

    /**
     * Reset collected data and prescribe to pass stream data through the collector filter
     */
    protected function setUp()
    {
        \Magento\Test\Profiler\OutputBambooTestFilter::resetCollectedData();

        /**
         * @link http://php.net/manual/en/wrappers.php.php
         */
        $this->_output = new \Magento\TestFramework\Profiler\OutputBamboo(
            array(
                'filePath' => 'php://filter/write=dataCollectorFilter/resource=php://memory',
                'metrics' => array('sample metric (ms)' => array('profiler_key_for_sample_metric'))
            )
        );
    }

    public function testDisplay()
    {
        $this->_output->display(new \Magento\Framework\Profiler\Driver\Standard\Stat());
        \Magento\Test\Profiler\OutputBambooTestFilter::assertCollectedData("Timestamp,\"sample metric (ms)\"\n%d,%d");
    }
}
