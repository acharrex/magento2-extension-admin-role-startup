<?php
/**
 * Copyright © Shopigo. All rights reserved.
 * See LICENSE.txt for license details (http://opensource.org/licenses/osl-3.0.php).
 */

namespace Shopigo\AdminRoleStartup\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class SetStartupPageObserver implements ObserverInterface
{
    /**
     * Set startup page
     *
     * @param Observer $observer
     * @return $this
     */
    public function execute(Observer $observer)
    {
        $event  = $observer->getEvent();

        $role = $event->getObject();
        $request = $event->getRequest();

        $startupPage = $request->getParam('startup_page', null);
        if ($startupPage) {
            $role->setStartupPage($startupPage);
        }

        return $this;
    }
}