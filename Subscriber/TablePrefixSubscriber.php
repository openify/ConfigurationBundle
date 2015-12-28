<?php
namespace Openify\Bundle\ConfigurationBundle\Subscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Mapping\ClassMetadataInfo;

class TablePrefixSubscriber implements EventSubscriber
{
    protected $prefix = '';

    public function __construct($prefix)
    {
        $this->prefix = (string) $prefix;
    }

    public function getSubscribedEvents()
    {
        return array('loadClassMetadata');
    }

    public function loadClassMetadata(LoadClassMetadataEventArgs $args)
    {
        /** @var ClassMetadataInfo $classMetadata */
        $classMetadata = $args->getClassMetadata();
        if($classMetadata->namespace == "Openify\\Bundle\\ConfigurationBundle\\Entity") {
            $classMetadata->setTableName($this->prefix . $classMetadata->getTableName());
        }
    }

}
