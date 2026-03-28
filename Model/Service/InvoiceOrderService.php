<?php

declare(strict_types=1);

namespace SeoulCommerce\KoreaCheckoutAdapter\Model\Service;

use Magento\Framework\DB\TransactionFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Model\Service\InvoiceService;

class InvoiceOrderService
{
    public function __construct(
        private readonly InvoiceService $invoiceService,
        private readonly TransactionFactory $transactionFactory
    ) {
    }

    /**
     * @return array{attempted:bool,created:bool,reason:?string}
     */
    public function execute(OrderInterface $order): array
    {
        if (!$order->canInvoice()) {
            return [
                'attempted' => true,
                'created' => false,
                'reason' => 'order_not_invoiceable',
            ];
        }

        $invoice = $this->invoiceService->prepareInvoice($order);

        if (!$invoice || !$invoice->getTotalQty()) {
            return [
                'attempted' => true,
                'created' => false,
                'reason' => 'empty_invoice',
            ];
        }

        $invoice->register();
        $invoice->pay();
        $order->setIsInProcess(true);

        $transaction = $this->transactionFactory->create();
        $transaction->addObject($invoice);
        $transaction->addObject($order);
        $transaction->save();

        return [
            'attempted' => true,
            'created' => true,
            'reason' => null,
        ];
    }
}
