<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Illarion\CustomerHobby\Block;

use Illarion\CustomerHobby\Model\Config\Source\HobbyOptions;
use Magento\Customer\Model\Session;
use Magento\Framework\Math\Random;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\View\Helper\SecureHtmlRenderer;

/**
 * Class Link
 */
class Link extends \Magento\Framework\View\Element\Html\Link
{
    /**
     * @var Session
     */
    protected $customerSession;

    /**
     * @param Context $context
     * @param Session $customerSession
     * @param HobbyOptions $hobbyOptions
     * @param array $data
     * @param SecureHtmlRenderer|null $secureRenderer
     * @param Random|null $random
     */
    public function __construct(
        Context $context,
        Session $customerSession,
        HobbyOptions $hobbyOptions,
        array $data = [],
        ?SecureHtmlRenderer $secureRenderer = null,
        ?Random $random = null
    ) {
        parent::__construct($context, $data);
        $this->customerSession = $customerSession;
        $this->hobbyOptions = $hobbyOptions;
    }

    /**
     * @return string
     */
    public function getHobbyLabel()
    {
        $value = $this->getCustomerHobby();
        return $this->getLabel() . ' ' . $this->hobbyOptions->getOptionText($value);
    }

    /**
     * @return mixed
     */
    public function getCustomerHobby()
    {
        // Retrieve and return the customer's hobby attribute here
        return $this->customerSession->getCustomer()->getCustomerHobby();
    }
}
