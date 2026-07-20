<?php

/**
 * Copyright since 2019 Kaudaj
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to info@kaudaj.com so we can send you a copy immediately.
 *
 * @author    Kaudaj <info@kaudaj.com>
 * @copyright Since 2019 Kaudaj
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 */

declare(strict_types=1);

namespace Kaudaj\Module\ModuleBedrock\Form\Configuration;

use Kaudaj\Module\ModuleBedrock\Form\Type\GeneralType;
use PrestaShop\PrestaShop\Core\Configuration\AbstractMultistoreConfiguration;
use PrestaShopBundle\Service\Form\MultistoreCheckboxEnabler;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Manages the configuration data about general options.
 */
class GeneralConfiguration extends AbstractMultistoreConfiguration
{
    private const CONFIGURATION_FIELDS = [
        GeneralType::FIELD_EXAMPLE_SETTING,
    ];

    /**
     * {@inheritdoc}
     *
     * @return array<string, mixed>
     */
    public function getConfiguration()
    {
        $rawValue = $this->configuration->get(
            self::getConfigurationKey(GeneralType::FIELD_EXAMPLE_SETTING),
            null,
            $this->getShopConstraint()
        );

        return [
            GeneralType::FIELD_EXAMPLE_SETTING => is_string($rawValue) ? $rawValue : '',
        ];
    }

    /**
     * {@inheritdoc}
     *
     * @param array<string, mixed> $configuration
     *
     * @return array<int, array<string, mixed>>
     */
    public function updateConfiguration(array $configuration)
    {
        if ($this->validateConfiguration($configuration)) {
            $exampleSetting = $configuration[GeneralType::FIELD_EXAMPLE_SETTING] ?? '';

            $this->configuration->set(
                self::getConfigurationKey(GeneralType::FIELD_EXAMPLE_SETTING),
                is_string($exampleSetting) ? $exampleSetting : '',
                $this->getShopConstraint()
            );
        }

        return [];
    }

    /**
     * Ensure the parameters passed are valid.
     *
     * @param array<string, mixed> $configuration
     *
     * @return bool Returns true if no exception are thrown
     */
    public function validateConfiguration(array $configuration): bool
    {
        $fields = [];

        foreach (self::CONFIGURATION_FIELDS as $field) {
            $fields[] = $field;
            $fields[] = MultistoreCheckboxEnabler::MULTISTORE_FIELD_PREFIX . $field;
        }

        foreach (array_keys($configuration) as $key) {
            if (!in_array($key, $fields, true)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return OptionsResolver
     */
    protected function buildResolver(): OptionsResolver
    {
        return (new OptionsResolver())
            ->setDefined(self::CONFIGURATION_FIELDS)
            ->setAllowedTypes(GeneralType::FIELD_EXAMPLE_SETTING, ['string', 'null'])
        ;
    }

    public static function getConfigurationKey(string $fieldName): string
    {
        return 'KJ_MODULE_BEDROCK_' . strtoupper($fieldName);
    }
}
