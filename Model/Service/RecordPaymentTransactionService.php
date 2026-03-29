<?php

declare(strict_types=1);

namespace SeoulCommerce\KoreaCheckoutAdapter\Model\Service;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\DB\TransactionFactory;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Model\Order\Payment\Transaction;
use Magento\Sales\Model\Order\Payment\Transaction\BuilderInterface as TransactionBuilderInterface;
use Magento\Sales\Model\ResourceModel\Order\Payment\Transaction\CollectionFactory as TransactionCollectionFactory;

class RecordPaymentTransactionService
{
    public function __construct(
        private readonly TransactionBuilderInterface $transactionBuilder,
        private readonly TransactionCollectionFactory $transactionCollectionFactory,
        private readonly TransactionFactory $transactionFactory,
        private readonly ResourceConnection $resourceConnection
    ) {
    }

    /**
     * @param array<string, mixed> $rawDetails
     */
    public function execute(OrderInterface $order, string $transactionId, array $rawDetails = []): bool
    {
        $payment = $order->getPayment();
        if ($payment === null) {
            return false;
        }

        if ($this->exists((int) $order->getEntityId(), $transactionId)) {
            return false;
        }

        $payment->setLastTransId($transactionId);
        $payment->setTransactionId($transactionId);
        $payment->setAdditionalInformation(Transaction::RAW_DETAILS, $rawDetails);

        $transaction = $this->transactionBuilder
            ->setPayment($payment)
            ->setOrder($order)
            ->setTransactionId($transactionId)
            ->setAdditionalInformation([Transaction::RAW_DETAILS => $rawDetails])
            ->setFailSafe(true)
            ->build(Transaction::TYPE_CAPTURE);

        $payment->addTransactionCommentsToOrder(
            $transaction,
            __('Payment captured by Korea Checkout orchestration.')
        );
        $payment->setParentTransactionId(null);

        $connection = $this->resourceConnection->getConnection();
        $connection->beginTransaction();

        try {
            $saveTransaction = $this->transactionFactory->create();
            $saveTransaction->addObject($payment);
            $saveTransaction->addObject($transaction);
            $saveTransaction->addObject($order);
            $saveTransaction->save();
            $connection->commit();
        } catch (\Throwable $exception) {
            $connection->rollBack();
            throw $exception;
        }

        return true;
    }

    private function exists(int $orderId, string $transactionId): bool
    {
        $collection = $this->transactionCollectionFactory->create();
        $collection->addOrderIdFilter($orderId);
        $collection->addTxnTypeFilter(Transaction::TYPE_CAPTURE);
        $collection->addFieldToFilter('txn_id', $transactionId);

        return $collection->getSize() > 0;
    }
}
