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

namespace Kaudaj\Module\ModuleBedrock\Controller\Admin;

use PrestaShop\PrestaShop\Core\Form\FormHandlerInterface;
use PrestaShopBundle\Controller\Admin\PrestaShopAdminController;
use PrestaShopBundle\Security\Attribute\AdminSecurity;
use PrestaShopBundle\Security\Attribute\DemoRestricted;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SettingsController extends PrestaShopAdminController
{
    public function __construct(
        private readonly FormHandlerInterface $generalFormHandler,
    ) {
    }

    #[AdminSecurity("is_granted('read', request.get('_legacy_controller'))", message: 'You do not have permission to access this.')]
    public function indexAction(): Response
    {
        $generalForm = $this->generalFormHandler->getForm();

        return $this->render('@Modules/kjmodulebedrock/views/templates/back/layouts/settings.html.twig', [
            'general_form' => $generalForm->createView(),
            'layoutTitle' => $this->trans('Module Bedrock', [], 'Modules.Kjmodulebedrock.Admin'),
        ]);
    }

    #[AdminSecurity("is_granted('update', request.get('_legacy_controller'))", message: 'You do not have permission to update this.', redirectRoute: 'kj_module_bedrock_settings')]
    #[DemoRestricted(redirectRoute: 'kj_module_bedrock_settings')]
    public function processGeneralFormAction(Request $request): RedirectResponse
    {
        $form = $this->generalFormHandler->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $errors = is_array($data) ? $this->generalFormHandler->save($data) : [];

            if (0 === count($errors)) {
                $this->addFlash('success', $this->trans('Successful update', [], 'Admin.Notifications.Success'));
            } else {
                $this->addFlashErrors($errors);
            }
        }

        return $this->redirectToRoute('kj_module_bedrock_settings');
    }
}
