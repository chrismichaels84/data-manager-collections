<?php
namespace Michaels\ManagerCollections\Tests;

use Michaels\Manager\Traits\CollectionTrait;
use Michaels\Manager\Traits\ManagesItemsTrait;

/**
 * Class CustomizedManagerStub
 * @package Stubs
 */
class CollectionStub
{
    use ManagesItemsTrait, CollectionTrait;

    public function __construct($items = null)
    {
        $this->initManager($items);
    }
}
