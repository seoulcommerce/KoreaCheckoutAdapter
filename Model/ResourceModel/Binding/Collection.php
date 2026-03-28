<?php

declare(strict_types=1);

namespace SeoulCommerce\KoreaCheckoutAdapter\Model\ResourceModel\Binding;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use SeoulCommerce\KoreaCheckoutAdapter\Model\Binding as BindingModel;
use SeoulCommerce\KoreaCheckoutAdapter\Model\ResourceModel\Binding as BindingResource;

class Collection extends AbstractCollection
{
    protected function _construct(): void
    {
        $this->_init(BindingModel::class, BindingResource::class);
    }
}
