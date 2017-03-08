[![Latest Version](https://img.shields.io/github/release/chrismichaels84/data-manager-collections.svg?style=flat-square)](https://github.com/chrismichaels84/data-manager-collections/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/chrismichaels84/data-manager-collections/master.svg?style=flat-square)](https://travis-ci.org/chrismichaels84/data-manager-collections)
[![Coverage Status](https://coveralls.io/repos/chrismichaels84/data-manager-collections/badge.svg?branch=master)](https://coveralls.io/r/chrismichaels84/data-manager-collections?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/michaels/data-manager-collections.svg?style=flat-square)](https://packagist.org/packages/michaels/data-manager-collections)

# Data Manager and Collections
This repo is an addition to http://github.com/michaels/data-manager.
You do NOT need to require that specifically. Composer will do its magic.

## Install
Via Composer
``` bash
$ composer require michaels/data-manager-collections
```

## Overview
On top of being a powerful data-manager, `Manager` can be used as an array collection.
This means it provides several helper methods to work with the data.

The Collections API is based on (and uses) [Arrayzy](https://github.com/bocharsky-bw/Arrayzy), so be sure
to look at that package for a complete list of available methods.

Also note that some conflicts exist (such as `contains`) in these cases, Manager's method is used.
There should be little or no difference in the behavior.

## Setup and Usage
Simply include the `Michaels\Manager\Collections` in your class.

**NOTE THAT** `CollectionTrait` depends on ManagesItemsTrait. 
If you to use `CollectionTrait` without `ManagesItemsTrait`, you will get all sorts of errors.

### Returning Collections
Once you have that included, it will (by default) return a collection every time you ask for an array.
That means
```php
$manager = new Manager([
   'one' => [
      'two' => [
         'three' => 'three',
         'four' => 'four',
         'five' => 'five'
      ]
   ]
]);

$value = $manager->get('one.two');
```

Will return an instance that allows you to `push`, `pop` and all sorts of things.
```php
$value->shift('six');
```
And so on. Again, look at [Arrayzy](https://github.com/bocharsky-bw/Arrayzy) for details.

Of course, if you ask for an item that can't be used as a collection, you get the item itself.

Lastly, you may enable or disable whether to return collections by changing the `$useCollections` property on the class.

### Using Dot Notation
You can also use the Collection API via dot notation
```php
$manager = new Collection(['one' => ['two' => ['a', 'b', 'c']]]);
$manager->unshift('one.two', 'y', 'z');

// ['y', 'z', 'a', 'b', 'c']
```

In these cases, the only difference between Manager's api and Arrayzy's api is that the FIRST argument
is the alias you want to mess with.

When doing this, these methods return data. By default they will return arrays.
You may change this. You can return arrays, collections, or modify the data in manager itself by adding a third argument.

```php
$manager->unshift('one.two', 'y', Collection::$RETURN_COLLECTION);
```
This will do exactly the same as above, but will give you back a collection instead of array.

At present the following flags exist:
  1. `static::$RETURN_ARRAY` by default
  2. `static::$RETURN_COLLECTION` gives you an Arrayzy Collection
  3. `static::$MODIFY_MANIFEST` will modify the data inside manager and return manager ($this) to you.
  
An example of the last:
```php
$manager = new Collection(['one' => ['two' => ['a', 'b', 'c']]]);
$manager->add('three', 'three-value');

$actual = $manager->walk('one.two', function(&$value, $key) {
    $value = "$value-new";
}, Collection::$MODIFY_MANIFEST);

// $actual is the manager itself
// $manager->get('three') === 'three-value'
// $manager->get('one.two') === ['a-new', 'b-new', 'c-new'];
```

## Using with `ChainsNestedItemsTrait`
It is possible to combine these two traits, though it isn't recommended. With so many changable method names, you are bound
to run into some name collisions and there is no telling how it will be handled. This feature is not officially supported, but
I did make it possible and am open to suggestions (PRs) for improvement.

In order to do this, you MUST setup your class like
```php
class MyCoolCollection implements ManagesItemsInterface
{
    use ManagesItemsTrait, ChainsNestedItemsTrait, CollectionTrait {
        CollectionTrait::__call insteadof ChainsNestedItemsTrait;
    }

    public function __construct(array $items = null)
    {
        $this->initManager($items);
    }
}
```

## Contributing
Contributions are welcome and will be fully credited. Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security
If you discover any security related issues, please email chrismichaels84@gmail.com instead of using the issue tracker.

## Credits
- [Michael Wilson](https://github.com/chrismichaels84)
- [Scott](https://github.com/smolinari)
- Open an issue to join in!

## License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
