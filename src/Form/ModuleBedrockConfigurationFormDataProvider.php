<?php

declare(strict_types=1);

namespace Kaudaj\Module\ModuleBedrock\Form;

use PrestaShop\PrestaShop\Core\Configuration\DataConfigurationInterface;
use PrestaShop\PrestaShop\Core\Form\FormDataProviderInterface;

/**
 * Provider ir responsible for providing form data, in this case it's as simple as using configuration to do that
 *
 * Class ModuleBedrockConfigurationFormDataProvider
 */
class ModuleBedrockConfigurationFormDataProvider implements FormDataProviderInterface
{
    /**
     * @var DataConfigurationInterface
     */
    private $moduleBedrockConfiguration;

    /**
     * @param DataConfigurationInterface $moduleBedrockConfiguration
     */
    public function __construct(DataConfigurationInterface $moduleBedrockConfiguration)
    {
        $this->moduleBedrockConfiguration = $moduleBedrockConfiguration;
    }

    /**
     * {@inheritdoc}
     */
    public function getData(): array
    {
        return $this->moduleBedrockConfiguration->getConfiguration();
    }

    /**
     * {@inheritdoc}
     */
    public function setData(array $data): array
    {
        return $this->moduleBedrockConfiguration->updateConfiguration($data);
    }
}
