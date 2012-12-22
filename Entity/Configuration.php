<?php

namespace Openify\Bundle\ConfigurationBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Openify\Bundle\ConfigurationBundle\Entity\Configuration
 *
 * @ORM\Table(name="config", uniqueConstraints={@ORM\UniqueConstraint(name="namespace_name_idx", columns={"namespace", "name"})})
 * @ORM\Entity(repositoryClass="Openify\Bundle\ConfigurationBundle\Entity\ConfigurationRepository")
 */
class Configuration
{
    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=128)
     * @ORM\Id
     */
    private $name;

    /**
     * @var text $value
     *
     * @ORM\Column(name="value", type="text", nullable=true)
     */
    private $value;


    /**
     * @var string $namespace
     *
     * @ORM\Column(name="namespace", type="string", length=50)
     */
    private $namespace;

    /**
     * Set name
     *
     * @param  string        $name
     * @return Configuration
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set value
     *
     * @param  text          $value
     * @return Configuration
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return text
     */
    public function getValue()
    {
        return $this->value;
    }


    /**
     * Set namespace
     *
     * @param string $namespace
     *
     * @return Configuration
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;

        return $this;
    }

    /**
     * Get namespace
     *
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }
}
