# Supplier Stock Info Package

Package for fetching data about items from specified suppliers.

## Installation

Use the [composer](https://getcomposer.org/download/) to install package.

```bash
composer require lqasz/supplier-stock-info
```

## Usage

```php
use SupplierStockInfo\SupplierStock;

$supplierStock = new SupplierStock();

# return item data based on supplier type
$supplierStock->suppliers([
  [
    'name' => 'stanley-stella', // required
    'token' => '<stanley-stella-token>', // required
  ]
])->items([
  [
    'identifier' => '<item-id>' // required
  ]
])->get();

```

## Available Suppliers

For now this package supports:

- Stanley/Stella Stock API v4:
  - ``<stanley-stella-token>`` - text with email:password e.g. ``'test@test.com:password'``
  - ``<item-id>`` - Stanley/Stella SKU text

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)