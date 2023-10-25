<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Illarion\CustomerHobby\Model\Resolver;

use Illarion\CustomerHobby\Model\Config\Source\HobbyOptions;
use Magento\CustomerGraphQl\Model\Customer\GetCustomer;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlAuthorizationException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\GraphQl\Model\Query\ContextInterface;


/**
 * Change customer password resolver
 */
class CustomerAttribute implements ResolverInterface
{
    /**
     * @var GetCustomer
     */
    private $getCustomer;

    protected $hobbyOptions;

    /**
     * @param GetCustomer $getCustomer
     */
    public function __construct(GetCustomer $getCustomer, HobbyOptions $hobbyOptions)
    {
        $this->getCustomer = $getCustomer;
        $this->hobbyOptions = $hobbyOptions;
    }

    /**
     * @inheritdoc
     */
    public function resolve(
        Field       $field,
                    $context,
        ResolveInfo $info,
        array       $value = null,
        array       $args = null
    ) {
        /** @var ContextInterface $context */
        if (false === $context->getExtensionAttributes()->getIsCustomer()) {
            throw new GraphQlAuthorizationException(__('The current customer isn\'t authorized.'));
        }

        try {
            $customer = $this->getCustomer->execute($context);
            $customerHobby = $customer->getCustomAttribute('customer_hobby');
            $attributeValue = $customerHobby->getValue();
            $label = $this->hobbyOptions->getOptionText($attributeValue);
        } catch (LocalizedException $e) {
            throw new LocalizedException(__($e->getMessage()));
        }

        return ['label' => $label, 'value' => $attributeValue];
    }
}
