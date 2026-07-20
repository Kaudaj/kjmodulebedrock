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

// Unit bootstrap: no database. The module main file is guarded by `_PS_VERSION_`,
// so the constant must exist before any autoload happens.
if (!defined('_PS_VERSION_')) {
    define('_PS_VERSION_', getenv('_PS_VERSION_') ?: '9.0.0');
}

// Module autoloader (PSR-4 Kaudaj\Module\ModuleBedrock\ -> src/).
require dirname(__DIR__, 2) . '/vendor/autoload.php';

// PrestaShop core autoloader when available (provides AbstractMultistoreConfiguration,
// MultistoreCheckboxEnabler...). Without it the affected tests skip via their setUp().
$psRoot = getenv('_PS_ROOT_DIR_');
if (is_string($psRoot) && $psRoot !== '' && is_file($psRoot . '/vendor/autoload.php')) {
    require_once $psRoot . '/vendor/autoload.php';
}
