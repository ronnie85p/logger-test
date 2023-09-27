<?php 
namespace App\Packages\Logger;

use App\Packages\Logger\Entities\IEntity;

class LoggerFactory 
{
    public function __construct(
        private IEntity $entity
    ) { }

    public function entity()
    {
        return $this->entity;
    }
}