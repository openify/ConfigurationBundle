<?php
namespace Openify\Bundle\ConfigurationBundle\Subscriber;

use Doctrine\ORM\Event\LoadClassMetadataEventArgs;

class TablePrefixSubscriber implements \Doctrine\Common\EventSubscriber
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
        $classMetadata = $args->getClassMetadata();
        if($classMetadata->namespace == "Openify\Bundle\ConfigurationBundle\Entity") {
            $classMetadata->setTableName($this->prefix . $classMetadata->getTableName());
        }
    }

}
