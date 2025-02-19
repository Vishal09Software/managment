<?php

namespace App\Services;


class TransactionService
{
    public function filterTransactions($query)
    {
        return $query
            ->when(request('customer_id'), fn($q) => $q->where('customer_id', request('customer_id')))
            ->when(request('date_from'), fn($q) => $q->whereDate('payment_date', '>=', request('date_from')))
            ->when(request('date_to'), fn($q) => $q->whereDate('payment_date', '<=', request('date_to')))
            ->when(request('payment_method'), fn($q) => $q->where('payment_method', request('payment_method')));
    }
    public function filterTransactionsOut($query)
    {
        return $query
            ->when(request('type'), function($query) {
                $query->where('type', request('type'));

                if (request('type') === 'vendor' && request('vendor_id')) {
                    $query->where('vendor_id', request('vendor_id'));
                }

                if (request('type') === 'vehicle' && request('vehicle_id')) {
                    $query->where('vehicle_id', request('vehicle_id'));
                }

                return $query;
            })
            ->when(request('date_from'), fn($q) => $q->whereDate('payment_date', '>=', request('date_from')))
            ->when(request('date_to'), fn($q) => $q->whereDate('payment_date', '<=', request('date_to')))
            ->when(request('payment_method'), fn($q) => $q->where('payment_method', request('payment_method')));
    }
}
