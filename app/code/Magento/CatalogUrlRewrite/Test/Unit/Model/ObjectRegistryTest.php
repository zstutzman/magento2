<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\CatalogUrlRewrite\Test\Unit\Model;

use Magento\Framework\Object;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;

class ObjectRegistryTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Magento\CatalogUrlRewrite\Model\ObjectRegistry */
    protected $objectRegistry;

    /** @var \Magento\Framework\Object|\PHPUnit_Framework_MockObject_MockObject */
    protected $object;

    protected function setUp()
    {
        $this->object = new \Magento\Framework\Object(['id' => 1]);
        $this->objectRegistry = (new ObjectManager($this))->getObject(
            'Magento\CatalogUrlRewrite\Model\ObjectRegistry',
            ['entities' => [$this->object]]
        );
    }

    public function testGet()
    {
        $this->assertEquals($this->object, $this->objectRegistry->get(1));
    }

    public function testGetNotExistObject()
    {
        $this->assertEquals(null, $this->objectRegistry->get('no-id'));
    }

    public function testGetList()
    {
        $this->assertEquals([1 => $this->object], $this->objectRegistry->getList());
    }

    public function testGetEmptyList()
    {
        $objectRegistry = (new ObjectManager($this))->getObject(
            'Magento\CatalogUrlRewrite\Model\ObjectRegistry',
            ['entities' => []]
        );
        $this->assertEquals([], $objectRegistry->getList());
    }
}
