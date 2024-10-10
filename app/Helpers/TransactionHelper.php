<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransactionHelper {
    /**
     * Exécute une fonction donnée dans une transaction.
     *
     * @param \Closure $callback
     * @return mixed
     */
    public static function transactionWrapper(\Closure $callback) {
        DB::beginTransaction();

        try {
            $result = $callback();

            DB::commit();

            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);

            // Vous pouvez personnaliser la réponse ou la gestion des erreurs ici
            throw $e;  // ou return response()->json(['message' => 'An error occurred.'], 500);
        }
    }
}
