<?php
/**
 *
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Paypal\Controller\Adminhtml\Billing\Agreement;

class Cancel extends \Magento\Paypal\Controller\Adminhtml\Billing\Agreement
{
    /**
     * Cancel billing agreement action
     *
     * @return void
     */
    public function execute()
    {
        $agreementModel = $this->_initBillingAgreement();

        if ($agreementModel && $agreementModel->canCancel()) {
            try {
                $agreementModel->cancel();
                $this->messageManager->addSuccess(__('You canceled the billing agreement.'));
                $this->_redirect('paypal/*/view', ['_current' => true]);
                return;
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addError(__('We can\'t cancel the billing agreement.'));
                $this->_objectManager->get('Psr\Log\LoggerInterface')->critical($e);
            }
            $this->_redirect('paypal/*/view', ['_current' => true]);
        }
        return $this->_redirect('paypal/*/');
    }

    /**
     * {@inheritDoc}
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Magento_Paypal::actions_manage');
    }
}
