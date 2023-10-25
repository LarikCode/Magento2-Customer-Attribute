<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Illarion\CustomerHobby\Model\Resolver;

use Magento\CustomerGraphQl\Model\Customer\GetCustomer;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlAuthorizationException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\GraphQl\Model\Query\ContextInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;

/**
 * Change customer password resolver
 */
class UpdateCustomerHobby implements ResolverInterface
{
    private $customerRepository;

    /**
     * @var GetCustomer
     */
    private $getCustomer;

    /**
     * @param GetCustomer $getCustomer
     * @param CustomerRepositoryInterface $customerRepository
     */
    public function __construct(
        GetCustomer                $getCustomer,
        CustomerRepositoryInterface $customerRepository
    ) {
        $this->getCustomer = $getCustomer;
        $this->customerRepository = $customerRepository;
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

        $customerId = $args['input']['customer_id'];

        if ($context->getUserId() !== $customerId) {
            throw new GraphQlAuthorizationException(__('You are not authorized to update another customer\'s hobby.'));
        }

        $hobby = $args['input']['hobby'];

        try {
            $customer = $this->getCustomer->execute($context);
            $customer->setCustomAttribute('customer_hobby', $hobby);
            $this->customerRepository->save($customer);
        } catch (LocalizedException $e) {
            throw new LocalizedException(__($e->getMessage()));
        }

        return ["hobby" => $hobby];
    }
}
