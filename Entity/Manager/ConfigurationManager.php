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
    public function add($key, $value = null, $namespace = null)
    {
        if (!$this->has($key, $namespace)) {
            $config = new Configuration();
            $config->setName($key);
            $config->setValue($value);
            $config->setNamespace($namespace);
            $this->em->persist($config);
            $this->em->flush();
            return $this;
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
    public function update($key, $value, $namespace = null)
    {
        if ($config = $this->find($key, $namespace)) {
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
     * Set a value
     *
     * @param string $key   Unique key
     * @param mixed  $value A value
     * @param string $namespane The namespace
     * @access public
     * @return ConfigurationManager
     */
    public function set($key, $value, $namespace = null)
    {
        $config = $this->find($key, $namespace));

        if(!$config) {
            $config = new Configuration();
            $config->setName($key);
            $config->setNamespace($namespace);
        }

        $config->setValue($value);
        $this->em->persist($config);
        $this->em->flush();
        return $this;
    }

    /**
     * Retrieve a value
     *
     * @param string $key Unique identifier
     * @access public
     * @return mixed Requested value
     */
    public function get($key, $default = null, $namespace = null)
    {
        if ($config = $this->getRepository()->findOneBy(array('name' => $key, 'namespace' => $namespace))) {
            return $config->getValue();
        }

        return $default;
    }

    /**
     * Check if a key exists
     *
     * @param string $key Unique key
     * @access public
     * @return boolean
     */
    public function has($key, $namespace = null)
    {
        return $this->find($key, $namespace);
    }

    public function find($key, $namespace = null)
    {
        return $this->getRepository()->findOneBy(array('name' => $key, 'namespace' => $namespace));
    }

    public function getRepository()
    {
        return $this->em
                ->getRepository('OpenifyConfigurationBundle:Configuration');
    }

}
