<?php

namespace Modules\Transaction\Observers;

use Modules\Transaction\Entities\Transaction;
use Modules\User\Entities\User;

class TransactionObserver
{
    /**
     * Handle the Transaction "creating" event.
     *
     * @param Transaction $transaction
     * @return void
     */
    public function created(Transaction $transaction)
    {
        $user = User::find($transaction->user_id);

        switch ($transaction->type_id)
        {
            case 1: // credito
                $user->current_amount += $transaction->value;
                $user->save();
                break;

            case 2: // debito
                $user->current_amount -= $transaction->value;
                $user->save();
                break;

            case 3: // estorno
                $user->current_amount += $transaction->value;
                $user->save();
                break;
        }
    }


    /**
     * Handle the Transaction "deleting" event.
     *
     * @param Transaction $transaction
     * @return void
     */
    public function deleting(Transaction $transaction)
    {
        $user = User::find($transaction->user_id);

        switch ($transaction->type_id)
        {
            case 1: // credito
                $user->current_amount -= $transaction->value;
                $user->save();
                break;

            case 2: // debito
                $user->current_amount += $transaction->value;
                $user->save();
                break;

            case 3: // estorno
                $user->current_amount -= $transaction->value;
                $user->save();
                break;
        }
    }

}
