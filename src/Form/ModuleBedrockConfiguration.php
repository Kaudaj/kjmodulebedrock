<?php

declare(strict_types=1);

namespace Kaudaj\Module\ModuleBedrock\Form;

use PrestaShop\PrestaShop\Core\Configuration\DataConfigurationInterface;
use PrestaShop\PrestaShop\Core\ConfigurationInterface;

/**
 * Configuration is used to save data to configuration table and retrieve from it
 */
final class ModuleBedrockConfiguration implements DataConfigurationInterface
{
    public const EXAMPLE_SETTING = 'KJ_MODULE_BEDROCK_EXAMPLE_SETTING';

    /**
     * @var ConfigurationInterface
     */
    private $configuration;

    /**
     * @param ConfigurationInterface $configuration
     */
    public function __construct(ConfigurationInterface $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfiguration(): array
    {
        $return = [];

        if ($exampleSetting = $this->configuration->get(static::EXAMPLE_SETTING)) {
            $return['example_setting'] = $exampleSetting;
        }

        return $return;
    }

    /**
     * {@inheritdoc}
     */
    public function updateConfiguration(array $configuration): array
    {
        $errors = [];
        if (!$this->validateConfiguration($configuration)) {
            $errors[] = [
                'key' => 'Invalid configuration',
                'parameters' => [],
                'domain' => 'Admin.Notifications.Warning',
            ];
        } else {
            try {
                $this->configuration->set(static::EXAMPLE_SETTING, $configuration['example_setting']);
            } catch (\Exception $exception) {
                $errors[] = $exception->getMessage();
            }
        }

        return $errors;
    }

    /**
     * Ensure the parameters passed are valid.
     *
     * @param array $configuration
     *
     * @return bool Returns true if no exception are thrown
     */
    public function validateConfiguration(array $configuration): bool
    {
        return true;
    }
}
