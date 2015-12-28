<?php
namespace Openify\Bundle\ConfigurationBundle\Entity\Manager;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Openify\Bundle\ConfigurationBundle\Entity\Manager\BaseManager;
use Openify\Bundle\ConfigurationBundle\Entity\Configuration;
use Openify\Bundle\ConfigurationBundle\Exception\ConfigurationException;

class ConfigurationManager extends BaseManager
{
    protected $doctrine;

    public function __construct(Registry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * Add a key
     *
     * @param string $key Unique key
     * @param mixed $value A value
     * @param string $namespace
     *
     * @return $this
     *
     * @throws ConfigurationException
     * @access public
     */
    public function add($key, $value = null, $namespace = '')
    {
        if (!$this->has($key, $namespace)) {
            $config = new Configuration();
            $config->setName($key);
            $config->setValue($value);
            $config->setNamespace($namespace);
            $this->doctrine->getManager()->persist($config);
            $this->doctrine->getManager()->flush();
            return $this;
        } else {
            throw new ConfigurationException(
                    sprintf("The key %s already exists", $key));
        }
    }

    /**
     * Update a value
     *
     * @param string $key Unique key
     * @param mixed $value A value
     * @param string $namespace
     *
     * @return ConfigurationManager
     *
     * @throws ConfigurationException
     * @access public
     */
    public function update($key, $value, $namespace = '')
    {
        if ($config = $this->find($key, $namespace)) {
            $config->setValue($value);
            $this->doctrine->getManager()->persist($config);
            $this->doctrine->getManager()->flush();

            return $this;
        } else {
            throw new ConfigurationException(
                    sprintf("The key %s doesn't exist", $key));
        }
    }

    /**
     * Set a value
     *
     * @param string $key Unique key
     * @param mixed $value A value
     * @param string $namespace The namespace
     *
     * @return ConfigurationManager
     *
     * @access public
     */
    public function set($key, $value, $namespace = '')
    {
        $config = $this->find($key, $namespace);

        if(!$config) {
            $config = new Configuration();
            $config->setName($key);
            $config->setNamespace($namespace);
        }

        $config->setValue($value);
        $this->doctrine->getManager()->persist($config);
        $this->doctrine->getManager()->flush();

        return $this;
    }

    /**
     * Retrieve a value
     *
     * @param string $key Unique identifier
     * @param null $default
     * @param string $namespace
     *
     * @return mixed Requested value
     *
     * @access public
     */
    public function get($key, $default = null, $namespace = '')
    {
        if ($config = $this->find($key, $namespace)) {
            return $config->getValue();
        }

        return $default;
    }

    /**
     * Check if a key exists
     *
     * @param string $key Unique key
     * @param string $namespace
     *
     * @return bool
     *
     * @access public
     */
    public function has($key, $namespace = '')
    {
        return $this->find($key, $namespace);
    }

    /**
     * @param $key
     * @param string $namespace
     * @return null|Configuration
     */
    public function find($key, $namespace = '')
    {
        return $this->getRepository()->findOneBy(array('name' => $key, 'namespace' => $namespace));
    }

    public function getRepository()
    {
        return $this->doctrine->getManager()
                ->getRepository('OpenifyConfigurationBundle:Configuration');
    }

}
