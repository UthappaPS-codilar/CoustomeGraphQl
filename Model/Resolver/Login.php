<?php

namespace Codilar\CoustomerGraphQl\Model\Resolver;

use Magento\Customer\Api\AccountManagementInterface;
use Magento\Customer\Model\Session;
use Magento\CustomerGraphQl\Model\Customer\ExtractCustomerData;
use Magento\CustomerGraphQl\Model\Customer\GetCustomer;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlAuthorizationException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\GraphQl\Model\Query\ContextInterface;

class Login implements ResolverInterface
{
    /**
     * @var GetCustomer
     */
    private $getCustomer;

    /**
     * @var ExtractCustomerData
     */
    private $extractCustomerData;

    /**
     * @param GetCustomer $getCustomer
     * @param ExtractCustomerData $extractCustomerData
     */
    public function __construct(
        GetCustomer                $getCustomer,
        ExtractCustomerData        $extractCustomerData,
        AccountManagementInterface $customerAccountManagement,
        Session $customerSession
    )
    {
        $this->getCustomer = $getCustomer;
        $this->extractCustomerData = $extractCustomerData;
        $this->customerAccountManagement = $customerAccountManagement;
        $this->session = $customerSession;
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
    )
    {

                $customer = $this->customerAccountManagement->authenticate($args['email'], $args['password']);
               $a=$this->session->setCustomerDataAsLoggedIn($customer);
                $customer1 = $this->getCustomer->execute($context);
                return $this->extractCustomerData->execute($customer1);




    }
}
