<?php

namespace App\Packages\Logger\Entities;

interface IListParams
{
    public function get(string $key, $defatulValue = null): mixed;
}