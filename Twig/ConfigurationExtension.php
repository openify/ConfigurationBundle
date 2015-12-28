<?php
namespace Openify\Bundle\ConfigurationBundle\Twig;

use Openify\Bundle\ConfigurationBundle\Entity\Manager\ConfigurationManager;

class ConfigurationExtension extends \Twig_Extension {

    /**
     * @var ConfigurationManager
     */
    protected $configuration;

    public function __construct(ConfigurationManager $configuration)
    {
        $this->configuration = $configuration;
    }

    public function getGlobals() {
        return array(
            'openify_configuration' => $this->configuration
        );
    }

    public function getName()
    {
        return 'openify_configuration_twig_extension';
    }

}
