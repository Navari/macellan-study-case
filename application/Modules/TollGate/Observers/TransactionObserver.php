<?php

namespace Modules\TollGate\Observers;

use Modules\TollGate\Models\Transaction;

class TransactionObserver
{
    /**
     * Handle the Transaction "created" event.
     *
     * @param Transaction $transaction
     * @return void
     */
    public function created(Transaction $transaction)
    {
        $transaction->userAccess()->create([
            'user_id' => $transaction->user_id
        ]);
    }

}
