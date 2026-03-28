<?php

declare(strict_types=1);

namespace SeoulCommerce\KoreaCheckoutAdapter\Model\Service;

class StatusMapper
{
    /**
     * @return array{state:string,status:string}
     */
    public function map(string $normalizedStatus, string $currentState, string $currentStatus): array
    {
        switch ($normalizedStatus) {
            case 'paid':
                return ['state' => 'processing', 'status' => 'processing'];
            case 'processing':
            case 'requires_action':
            case 'authorized':
            case 'unknown_needs_reconciliation':
                return ['state' => 'payment_review', 'status' => 'payment_review'];
            case 'cancelled':
                return ['state' => 'canceled', 'status' => 'canceled'];
            case 'expired':
                return ['state' => 'canceled', 'status' => 'payment_expired'];
            case 'failed':
                return ['state' => $currentState, 'status' => 'payment_failed'];
            case 'created':
            case 'ready':
            case 'awaiting_customer':
            case 'submitted':
            default:
                return [
                    'state' => $currentState ?: 'new',
                    'status' => $currentStatus ?: 'pending_payment',
                ];
        }
    }
}
