<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Illarion\CustomerHobby\Controller\Hobby;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Customer\Model\Session;
use Magento\Customer\Model\CustomerFactory;

/**
 * Class Save Hobby
 */
class Save extends Action
{
    /**
     * @var Session
     */
    protected $customerSession;

    /**
     * @var CustomerFactory
     */
    protected $customerFactory;

    /**
     * @param Context $context
     * @param Session $customerSession
     * @param CustomerFactory $customerFactory
     */
    public function __construct(
        Context $context,
        Session $customerSession,
        CustomerFactory $customerFactory
    ) {
        parent::__construct($context);
        $this->customerSession = $customerSession;
        $this->customerFactory = $customerFactory;
    }

    /**
     * @inheritdoc
     */
    public function execute()
    {
        // Check if the customer is logged in
        if (!$this->customerSession->isLoggedIn()) {
            $this->messageManager->addErrorMessage(__('Please log in to edit your hobby.'));
            return $this->_redirect('customer/account/login');
        }

        $resultRedirect = $this->resultRedirectFactory->create();

        $customer = $this->customerSession->getCustomer();

        $hobby = $this->getRequest()->getParam('customer_hobby');

        try {
            $customer->setCustomerHobby($hobby);

            $customer->save();

            $this->messageManager->addSuccessMessage(__('Your hobby has been updated.'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        return $resultRedirect->setPath('customer/hobby/edit');
    }
}
