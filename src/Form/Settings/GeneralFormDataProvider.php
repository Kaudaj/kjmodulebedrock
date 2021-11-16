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

namespace Kaudaj\Module\ModuleBedrock\Form\Settings;

use PrestaShop\PrestaShop\Core\Configuration\DataConfigurationInterface;
use PrestaShop\PrestaShop\Core\Form\FormDataProviderInterface;

/**
 * Class GeneralFormDataProvider
 */
class GeneralFormDataProvider implements FormDataProviderInterface
{
    /**
     * @var DataConfigurationInterface
     */
    private $generalConfiguration;

    /**
     * @param DataConfigurationInterface $generalConfiguration
     */
    public function __construct(DataConfigurationInterface $generalConfiguration)
    {
        $this->generalConfiguration = $generalConfiguration;
    }

    /**
     * {@inheritdoc}
     *
     * @return array<string, mixed> The form data as an associative array
     */
    public function getData(): array
    {
        return $this->generalConfiguration->getConfiguration();
    }

    /**
     * {@inheritdoc}
     *
     * @param array<string, mixed> $data
     *
     * @return array<int, array<string, mixed>> An array of errors messages if data can't persisted
     */
    public function setData(array $data): array
    {
        return $this->generalConfiguration->updateConfiguration($data);
    }
}
