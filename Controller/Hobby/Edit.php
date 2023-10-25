<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Illarion\CustomerHobby\Controller\Hobby;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Edit Hobby
 */
class Edit extends \Magento\Framework\App\Action\Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var Session
     */
    protected $customerSession;

    /**
     * @param Context $context
     * @param Session $customerSession
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        Session $customerSession,
        PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->customerSession = $customerSession;
        parent::__construct($context);
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

        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set(__('Edit Hobby'));
        return $resultPage;
    }
}
