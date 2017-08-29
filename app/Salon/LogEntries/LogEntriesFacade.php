<?php
namespace Salon\LogEntries;

use Illuminate\Support\Facades\Facade;

class LogEntriesFacade extends Facade{

    protected static function getFacadeAccessor()
    {
        return 'logentries';
    }
}
