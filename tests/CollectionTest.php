<?php
namespace Michaels\ManagerCollections\Tests;

use PHPUnit_Framework_TestCase;

class CollectionTest extends PHPUnit_Framework_TestCase
{
   use CollectionScenario;

   public function getManager($items = [])
   {
      return new CollectionStub($items);
   }
}