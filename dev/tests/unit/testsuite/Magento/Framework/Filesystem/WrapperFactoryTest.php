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
 * @copyright   Copyright (c) 2014 X.commerce, Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace Magento\Framework\Filesystem;

use Magento\Framework\App\Filesystem\DirectoryList;

/**
 * Class WrapperFactoryTest
 * @package Magento\Framework\Filesystem
 */
class WrapperFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DirectoryList | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $directoryList;

    /**
     * @var WrapperFactory
     */
    protected $wrapperFactory;

    protected function setUp()
    {
        $this->directoryList = $this->getMock('Magento\Framework\App\Filesystem\DirectoryList', [], [], '', false);
        $this->wrapperFactory = new WrapperFactory($this->directoryList);
    }

    public function testGetByProtocolConfig()
    {
        $protocolCode = 'protocol';
        $expectedWrapperClass = '\Magento\Framework\Filesystem\Stub\Wrapper';
        $protocolConfig = ['driver' => $expectedWrapperClass];
        $driver = $this->getMockForAbstractClass('Magento\Framework\Filesystem\DriverInterface');

        $this->directoryList->expects($this->once())
            ->method('getProtocolConfig')
            ->with($protocolCode)
            ->will($this->returnValue($protocolConfig));

        $this->assertInstanceOf($expectedWrapperClass, $this->wrapperFactory->get($protocolCode, $driver));
    }
}
