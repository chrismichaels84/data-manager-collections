<?php
namespace Michaels\ManagerCollections\Tests;

use Michaels\Manager\Contracts\ManagesItemsInterface;
use Michaels\Manager\Traits\ChainsNestedItemsTrait;
use Michaels\Manager\Traits\ManagesItemsTrait;
use Michaels\ManagerCollections\CollectionTrait;

class NestedAndCollectionsStub implements ManagesItemsInterface
{
    use ManagesItemsTrait, ChainsNestedItemsTrait, CollectionTrait {
        CollectionTrait::__call insteadof ChainsNestedItemsTrait;
    }

    public function __construct(array $items = null)
    {
        $this->initManager($items);
    }
}
