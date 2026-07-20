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

namespace Kaudaj\Module\ModuleBedrock\Tests\Unit\Form\Configuration;

use Kaudaj\Module\ModuleBedrock\Form\Configuration\GeneralConfiguration;
use Kaudaj\Module\ModuleBedrock\Form\Type\GeneralType;
use PHPUnit\Framework\TestCase;

/**
 * Example unit test shipped with the bedrock: it pins the two pure-logic pieces
 * of the settings slice, without any database.
 *
 *  - getConfigurationKey(): the exact storage key read back at runtime; a drift
 *    here would silently detach the form from the stored value.
 *  - validateConfiguration(): only the declared fields (and their multistore
 *    twins) may be submitted; anything else is rejected.
 *
 * GeneralConfiguration extends the core AbstractMultistoreConfiguration whose
 * constructor needs services these methods never use, so the SUT is built
 * without invoking the constructor. Skips when the PrestaShop core classes are
 * not autoloadable.
 */
class GeneralConfigurationTest extends TestCase
{
    /** @var GeneralConfiguration */
    private $configuration;

    protected function setUp(): void
    {
        if (!class_exists(\PrestaShop\PrestaShop\Core\Configuration\AbstractMultistoreConfiguration::class)) {
            self::markTestSkipped('PrestaShop core unavailable (AbstractMultistoreConfiguration).');
        }

        $this->configuration = (new \ReflectionClass(GeneralConfiguration::class))
            ->newInstanceWithoutConstructor();
    }

    public function testConfigurationKeyForExampleSettingIsStable(): void
    {
        self::assertSame(
            'KJ_MODULE_BEDROCK_EXAMPLE_SETTING',
            GeneralConfiguration::getConfigurationKey(GeneralType::FIELD_EXAMPLE_SETTING)
        );
    }

    public function testValidateConfigurationAcceptsTheExampleSettingField(): void
    {
        self::assertTrue($this->configuration->validateConfiguration([
            GeneralType::FIELD_EXAMPLE_SETTING => 'some value',
        ]));
    }

    public function testValidateConfigurationAcceptsTheMultistoreTwinField(): void
    {
        $multistoreField = 'multistore_' . GeneralType::FIELD_EXAMPLE_SETTING;

        self::assertTrue($this->configuration->validateConfiguration([
            GeneralType::FIELD_EXAMPLE_SETTING => 'some value',
            $multistoreField => true,
        ]));
    }

    public function testValidateConfigurationAcceptsEmptySubmission(): void
    {
        self::assertTrue($this->configuration->validateConfiguration([]));
    }

    public function testValidateConfigurationRejectsUnknownFields(): void
    {
        self::assertFalse($this->configuration->validateConfiguration([
            GeneralType::FIELD_EXAMPLE_SETTING => 'some value',
            'unexpected_field' => 'whatever',
        ]));
    }
}
