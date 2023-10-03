<?php

namespace AK\Shared\Domain\Bus\Query;

interface QueryBus
{
    public function ask(Query $query);//: void;
}
