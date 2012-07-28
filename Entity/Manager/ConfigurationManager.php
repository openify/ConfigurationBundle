<?php
namespace Openify\Bundle\ConfigurationBundle\Entity\Manager;
use Doctrine\ORM\EntityManager;
use Openify\Bundle\ConfigurationBundle\Entity\Manager\BaseManager;
use Openify\Bundle\ConfigurationBundle\Entity\Configuration;
use Openify\Bundle\ConfigurationBundle\Exception\ConfigurationException;

class ConfigurationManager extends BaseManager
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * Add a key
     *
     * @param string $key   Unique key
     * @param mixed  $value A value
     * @access public
     * @return void
     */
    public function add($key, $value = null)
    {
        if (!$this->has($key)) {
            $config = new Configuration();
            $config->setName($key);
            $config->setValue($value);
            $this->em->persist($config);
            $this->em->flush();
        } else {
            throw new ConfigurationException(
                    sprintf("The key %s already exists", $key));
        }

    }

    /**
     * Update a value
     *
     * @param string $key   Unique key
     * @param mixed  $value A value
     * @access public
     * @return ConfigurationManager
     */
    public function set($key, $value)
    {
        if ($config = $this->getRepository()->find($key)) {
            $config->setValue($value);
            $this->em->persist($config);
            $this->em->flush();
			return $this;
        } else {
            throw new ConfigurationException(
                    sprintf("The key %s doesn't exist", $key));
        }
    }

    /**
     * Retrieve a value
     *
     * @param string $key Unique identifier
     * @access public
     * @return mixed Requested value, or ConfigurationException
     */
    public function get($key)
    {
        if ($config = $this->getRepository()->find($key)) {
            return $config->getValue();
        } else {
            throw new ConfigurationException(
                    sprintf("The key %s doesn't exist", $key));
        }
    }

    /**
     * Check if a key exists
     *
     * @param string $key Unique key
     * @access public
     * @return boolean
     */
    public function has($key)
    {
        return $this->getRepository()->find($key);
    }

    public function getRepository()
    {
        return $this->em
                ->getRepository('OpenifyConfigurationBundle:Configuration');
    }

}
