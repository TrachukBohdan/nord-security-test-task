# Secure Information Storage REST API

### Project setup

* Add `secure-storage.localhost` to your `/etc/hosts`: `127.0.0.1 secure-storage.localhost`

* Run `make init` to initialize project

* Open in browser: http://secure-storage.localhost:8000/item Should get `Full authentication is required to access this resource.` error, because first you need to make `login` call (see `postman_collection.json` or `SecurityController` for more info).

### Run tests

make tests

### API credentials

* User: john
* Password: maxsecure

### Postman requests collection

You can import all available API calls to Postman using `postman_collection.json` file

### API documentation

`POST http://secure-storage.localhost:8000/login` - login

accepts json, with the next structure
`{
     "username": "john",
     "password": "maxsecure"
 }`

***

`http://secure-storage.localhost:8000/logout` - logout

***

`GET http://secure-storage.localhost:8000/item` - list of user items

response, example

```
[
    {
        "id": 20,
        "data": "new item secret 1",
        "created_at": {
            "date": "2021-04-10 18:43:35.000000",
            "timezone_type": 3,
            "timezone": "UTC"
        },
        "updated_at": {
            "date": "2021-04-10 18:43:35.000000",
            "timezone_type": 3,
            "timezone": "UTC"
        }
    },
    {
        "id": 21,
        "data": "new item secret 1asdf",
        "created_at": {
            "date": "2021-04-10 18:43:53.000000",
            "timezone_type": 3,
            "timezone": "UTC"
        },
        "updated_at": {
            "date": "2021-04-10 18:43:53.000000",
            "timezone_type": 3,
            "timezone": "UTC"
        }
    },
    {
        "id": 22,
        "data": "very secure new item data",
        "created_at": {
            "date": "2021-04-10 18:44:16.000000",
            "timezone_type": 3,
            "timezone": "UTC"
        },
        "updated_at": {
            "date": "2021-04-10 18:44:16.000000",
            "timezone_type": 3,
            "timezone": "UTC"
        }
    }
]
```

***

`POST http://secure-storage.localhost:8000/item` - create item

accepts form-data with next params

```
[required][string] data - your secret text
```

***

`PUT http://secure-storage.localhost:8000/item` - updates item

accepts x-www-form-urlencoded with next params

```
[required][int] id - a user id
[required][string] data - new data text
```

***

`DELETE http://secure-storage.localhost:8000/item/{itemId}` - deletes item by `{itemId}`