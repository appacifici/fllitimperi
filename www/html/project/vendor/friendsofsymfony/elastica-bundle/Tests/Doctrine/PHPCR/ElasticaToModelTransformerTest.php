<?php

namespace FOS\ElasticaBundle\Tests\Doctrine\PHPCR;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\ElasticaBundle\Doctrine\PHPCR\ElasticaToModelTransformer;
use Doctrine\ODM\PHPCR\DocumentManager;
use Doctrine\ODM\PHPCR\DocumentRepository;

class ElasticaToModelTransformerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Doctrine\Common\Persistence\ManagerRegistry|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $registry;

    /**
     * @var \Doctrine\ODM\PHPCR\DocumentManager|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $manager;

    /**
     * @var DocumentRepository|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $repository;

    /**
     * @var string
     */
    protected $objectClass = 'stdClass';

    protected function setUp()
    {
        if (!interface_exists('Doctrine\Common\Persistence\ManagerRegistry')) {
            $this->markTestSkipped('Doctrine Common is not present');
        }
        if (!class_exists(DocumentManager::class)) {
            $this->markTestSkipped('Doctrine PHPCR is not present');
        }

        $this->registry = $this->getMockBuilder('Doctrine\Common\Persistence\ManagerRegistry')
            ->disableOriginalConstructor()
            ->getMock();

        $this->manager = $this->getMockBuilder('Doctrine\ODM\PHPCR\DocumentManager')
            ->disableOriginalConstructor()
            ->getMock();

        $this->registry->expects($this->any())
            ->method('getManager')
            ->will($this->returnValue($this->manager));

        $this->repository = $this
            ->getMockBuilder(DocumentRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(array(
                'customQueryBuilderCreator',
                'createQueryBuilder',
                'find',
                'findAll',
                'findBy',
                'findOneBy',
                'getClassName',
                'findMany'
            ))->getMock();

        $this->repository->expects($this->any())
            ->method('findMany')
            ->will($this->returnValue(new ArrayCollection([new \stdClass(), new \stdClass()])));

        $this->manager->expects($this->any())
            ->method('getRepository')
            ->with($this->objectClass)
            ->will($this->returnValue($this->repository));
    }

    /**
     *
     */
    public function testTransformUsesFindByIdentifier()
    {
        $this->registry->expects($this->any())
            ->method('getManager')
            ->will($this->returnValue($this->manager));

        $transformer = new ElasticaToModelTransformer($this->registry, $this->objectClass);

        $class = new \ReflectionClass('FOS\ElasticaBundle\Doctrine\PHPCR\ElasticaToModelTransformer');
        $method = $class->getMethod('findByIdentifiers');
        $method->setAccessible(true);

        $method->invokeArgs($transformer, array(
            array('c8f23994-d897-4c77-bcc3-bc6910e52a34', 'f1083287-a67e-480e-a426-e8427d00eae4'),
            $this->objectClass
        ));
    }
}
