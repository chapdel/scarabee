<?php

namespace Chapdel\Scarabee\Observers;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\DB;

class QueryObserver
{
    private $status = false;
    private $called_by;

    public function register(): void
    {
        DB::listen(function (QueryExecuted $query) {
            if (!$this->status) {
                return;
            }

            $sqlQuery = str_replace(['?'], ['\'%s\''], $query->sql);
            $sqlQuery = vsprintf($sqlQuery, $query->bindings);

            scarabee()->sendRequest([
                'view' => view('scarabee::query', [
                    'query' => $sqlQuery,
                    'time' => $query->time,
                    'connectionName' => $query->connectionName,
                    'call' => $this->called_by,
                ])->render(),
            ]);
        });
    }

    public function enable($called_by)
    {
        DB::enableQueryLog();
        $this->status = true;
        $this->called_by = $called_by;
    }

    public function disable($called_by)
    {
        DB::disableQueryLog();
        $this->status = false;
        $this->called_by = $called_by;
    }
}
