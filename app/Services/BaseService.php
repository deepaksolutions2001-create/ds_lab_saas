<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Exception;

abstract class BaseService
{
    /**
     * Wrap database operations in a transaction.
     *
     * @param \Closure $callback
     * @return mixed
     * @throws Exception
     */
    protected function transaction(\Closure $callback)
    {
        DB::beginTransaction();

        try {
            $result = $callback();
            DB::commit();
            return $result;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
