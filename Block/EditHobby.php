<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Illarion\CustomerHobby\Block;

use Magento\Framework\View\Element\Template;
use Magento\Customer\Model\Session;
use Magento\Framework\Data\Form\FormKey;
use Illarion\CustomerHobby\Model\Config\Source\HobbyOptions;

/**
 * Class Edit Hobby
 */
class EditHobby extends Template
{
    /**
     * @var Session
     */
    protected $customerSession;

    /**
     * @var HobbyOptions
     */
    protected $hobbyOptions;

    /**
     * @var FormKey
     */
    protected $formKey;

    /**
     * @param Template\Context $context
     * @param Session $customerSession
     * @param FormKey $formKey
     * @param HobbyOptions $hobbyOptions
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        Session $customerSession,
        FormKey $formKey,
        HobbyOptions $hobbyOptions,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->formKey = $formKey;
        $this->customerSession = $customerSession;
        $this->hobbyOptions = $hobbyOptions;
    }

    /**
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getFormKey()
    {
        return $this->formKey->getFormKey();
    }

    /**
     * @return array|array[]
     */
    public function getHobbyOptions()
    {
        return $this->hobbyOptions->getAllOptions();
    }

    /**
     * @return string
     */
    public function geyHobbyLabel()
    {
        $value = $this->getCustomerHobby();
        return $this->hobbyOptions->getOptionText($value);
    }

    /**
     * @param $value
     * @return string
     */
    public function getSelectedOption($value)
    {
        $customerHobby = $this->getCustomerHobby();
        return $customerHobby == $value ? 'selected' : '';
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
