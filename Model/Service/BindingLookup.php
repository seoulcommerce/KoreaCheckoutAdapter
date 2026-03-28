<?php

declare(strict_types=1);

namespace SeoulCommerce\KoreaCheckoutAdapter\Model\Service;

use SeoulCommerce\KoreaCheckoutAdapter\Model\Binding;
use SeoulCommerce\KoreaCheckoutAdapter\Model\ResourceModel\Binding\CollectionFactory;

class BindingLookup
{
    public function __construct(
        private readonly CollectionFactory $bindingCollectionFactory
    ) {
    }

    public function getByOrderId(int $orderId): ?Binding
    {
        $collection = $this->bindingCollectionFactory->create();
        $collection->addFieldToFilter('order_id', $orderId);
        $collection->setPageSize(1);

        $binding = $collection->getFirstItem();

        return $binding->getId() ? $binding : null;
    }

    public function getByPaymentSessionId(string $paymentSessionId): ?Binding
    {
        $collection = $this->bindingCollectionFactory->create();
        $collection->addFieldToFilter('payment_session_id', $paymentSessionId);
        $collection->setPageSize(1);

        $binding = $collection->getFirstItem();

        return $binding->getId() ? $binding : null;
    }
}
