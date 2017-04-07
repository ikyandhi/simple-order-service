## Simple Order Service

Simple ERP Logic that allow an order with products to come from a third party application into the system (through an API), assigned existing available items in the system or create new ones if required.

## Requirements
- PHP >= 5.6.4
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension

## Development Setup
```
$ git clone {repo_url} {folder_name}
$ composer install
$ composer dump-autoload -o
$ php artisan migrate
```
Ensure email config assigned properly to have send email works. Email trap not implemented at the moment.

## Environment Configuration
Add below environment variable to .env file.
```
API_PREFIX=api
ADMIN_EMAIL=email@administrator.com
```

## API (Prefix: api/, Ie. /api/orders)

## Orders

### Create New Order (POST)
```
/api/orders

Request:
{
  "order": {
    "customer": "Soong Ha Joong",
    "address": "This is sample address",
    "total": 120,
    "items": [
      {
        "sku": "TESTSKU1",
        "quantity": 1
      },
      {
        "sku": "TESTSKU2",
        "quantity": 1
      }
    ]
  }
}
```

### Update Order (PUT)
```
/api/orders/{id}

Request:
{
  "order": {
    "customer": "Soong Ha Joong",
    "address": "This is sample address",
    "total": 100
  }
}
```

### Get Order Detail (GET)
```
/api/orders/{id}
```

## Products

### Get Product Detail (GET)
```
/api/products/{id}
```

### Create New Product (POST)
```
/api/products

Request:
{
  "product": {
    "sku": "Soong12345"
  }
}
```

## Item

### Get Item Detail (GET)
```
/api/items/{id}
```

### Create New Item (POST)
```
/api/items

Request:
{
  "item": {
    "status": "assigned",
    "physical_status": "to_order",
    "product_id": 2,
    "order_id": 1
  }
}
```

### Update Item Detail (PUT)
```
/api/items/{id}

Request:
{
  "item": {
    "physical_status": "delivered",
    "order_id": 1
  }
}
```
API POSTMAN collection can be found tests/API.postman_collection.

## Requirement Functionalities
* <s>Create order through API</s>
* <s>Create new product if doesn't exists.</s>
* <s>Create an item to be assigned to order upon created.</s>
* <s>Order completion auto upon item(s) delivered. (Happen to be on backend process).</s>
* <s>Order cancelation auto upon item(s) are removed.</s>
* <s>View listing of Orders, Products, and Items (Bootstrap, Vue JS).</s>
* <s>Send email order confirmation to customer upon complete.</s>
* <s>Send email notification to admin regarding new product generated. </s>
* Manage Orders, Products and Items.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
