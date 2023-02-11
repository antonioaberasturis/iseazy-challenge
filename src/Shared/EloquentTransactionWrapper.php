<?php

declare(strict_types=1);

namespace Shared;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;

class EloquentTransactionWrapper
{
    public function __invoke(callable ...$callbacks)
    {
        try{
            DB::beginTransaction();

            foreach($callbacks as $callback){
                $callback();
            }

        }catch(QueryException $e){
            DB::rollBack();
            
            Log::critical($e->getMessage(), [$e->getTraceAsString()]);
            
            throw new PersistenceTransactionException();
            
        }catch(Throwable $e){
            DB::rollBack();
            
            throw new $e;
        }

        DB::commit();
    }
}
