<?php

declare(strict_types=1);

namespace SeoulCommerce\KoreaCheckoutAdapter\Model;

use Magento\Framework\Model\AbstractModel;
use SeoulCommerce\KoreaCheckoutAdapter\Model\ResourceModel\Binding as BindingResource;

class Binding extends AbstractModel
{
    protected function _construct(): void
    {
        $this->_init(BindingResource::class);
    }
}
