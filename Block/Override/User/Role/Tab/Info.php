<?php
/**
 * Copyright © Shopigo. All rights reserved.
 * See LICENSE.txt for license details (http://opensource.org/licenses/osl-3.0.php).
 */

namespace Shopigo\AdminRoleStartup\Block\Override\User\Role\Tab;

use Magento\Config\Model\Config\Source\Admin\Page;

/**
 * implementing now
 *
 * @SuppressWarnings(PHPMD.DepthOfInheritance)
 */
class Info extends \Magento\User\Block\Role\Tab\Info
{
    /**
     * @var \Magento\Config\Model\Config\Source\Admin\Page
     */
    protected $startupPage;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Config\Model\Config\Source\Admin\Page $startupPage
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Config\Model\Config\Source\Admin\Page $startupPage,
        array $data = []
    ) {
        $this->startupPage = $startupPage;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * @return void
     */
    protected function _initForm()
    {
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Role Information')]);

        $fieldset->addField(
            'role_name',
            'text',
            [
                'name' => 'rolename',
                'label' => __('Role Name'),
                'id' => 'role_name',
                'class' => 'required-entry',
                'required' => true
            ]
        );

        $fieldset->addField('startup_page', 'select', [
            'name'     => 'startup_page',
            'label'    => __('Startup Page'),
            'title'    => __('Startup Page'),
            'values'   => $this->startupPage->toOptionArray()
        ]);

        $fieldset->addField('role_id', 'hidden', ['name' => 'role_id', 'id' => 'role_id']);

        $fieldset->addField('in_role_user', 'hidden', ['name' => 'in_role_user', 'id' => 'in_role_userz']);

        $fieldset->addField('in_role_user_old', 'hidden', ['name' => 'in_role_user_old']);

        $verificationFieldset = $form->addFieldset(
            'current_user_verification_fieldset',
            ['legend' => __('Current User Identity Verification')]
        );
        $verificationFieldset->addField(
            self::IDENTITY_VERIFICATION_PASSWORD_FIELD,
            'password',
            [
                'name' => self::IDENTITY_VERIFICATION_PASSWORD_FIELD,
                'label' => __('Your Password'),
                'id' => self::IDENTITY_VERIFICATION_PASSWORD_FIELD,
                'title' => __('Your Password'),
                'class' => 'input-text validate-current-password required-entry',
                'required' => true
            ]
        );

        $data =  ['in_role_user_old' => $this->getOldUsers()];
        if ($this->getRole() && is_array($this->getRole()->getData())) {
            $data = array_merge($this->getRole()->getData(), $data);
        }
        $form->setValues($data);
        $this->setForm($form);
    }
}
