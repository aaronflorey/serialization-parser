# serialization-parser

**Parse PHP serialized strings into rich, structured objects — fast, simple, and flexible.**

**serialization-parser** is a PHP package that parses serialized data into a structured, lightweight AST (Abstract Syntax Tree) format.  
Each value is converted into a specific typed object (`ArrayType`, `StringType`, `IntegerType`, etc.), with an option to easily export the structure as a plain array.

## Installation

You can install the package via composer:

```bash
composer require mochaka/serialization-parser
```

## Usage

```php
use Mochaka\SerializationParser\SerializationParser;
$data = serialize(['foo' => 'bar', 'baz' => 1]);
$result = SerializationParser::parse($data);
```

The above result will be an instance of `Mochaka\SerializationParser\Data\ArrayType`:

```php
var_dump($result);
Mochaka\SerializationParser\Data\ArrayType {#4172
    +name: null,
    +visibility: null,
    +properties: [
      Mochaka\SerializationParser\Data\StringType {#4170
        +name: "foo",
        +visibility: null,
        +value: "bar",
      },
      Mochaka\SerializationParser\Data\IntegerType {#4171
        +name: "baz",
        +visibility: null,
        +value: 1,
      },
    ],
  }
```

All types also have a `->toArray()` method to dump the schema as an array.
```php
var_dump($result->toArray());

[
    "name" => null,
    "properties" => [
      [
        "name" => "foo",
        "type" => "String",
        "value" => "bar",
        "visibility" => null,
      ],
      [
        "name" => "baz",
        "type" => "Integer",
        "value" => 1,
        "visibility" => null,
      ],
    ],
    "type" => "Array",
    "visibility" => null,
  ]
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Aaron Florey](https://github.com/aaronflorey)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
