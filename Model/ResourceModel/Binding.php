<?php

declare(strict_types=1);

namespace SeoulCommerce\KoreaCheckoutAdapter\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Binding extends AbstractDb
{
    protected function _construct(): void
    {
        $this->_init('seoulcommerce_korea_checkout_binding', 'entity_id');
    }
}
