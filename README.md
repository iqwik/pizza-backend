#Backend (PHP)

__Structure:__
- lib
    - api (custom api models)
    - common (main classes/engine)
    - util (additional & other)
    - vendor (the project uses php-jwt)
- sessions (need to create folder)

__Config:__
- copy and rename config.php.EXAMPLE to config.php (do not rename)
in those folder
- Set up your config.php
    - DB connection
    - set domain
    - smtp

_use dump.sql_

__Request methods:__
```
GET
POST
PUT
DELETE
```

_All requests and responses in JSON_

__Response:__
```
{"status":200,"message":"OK","data":[]}
```

__How to use:__

Simple in use. 
`{classname}.{method}` (dot is separates api name and method)
any public method adding as `f_list` / `f_edit` / `f_something`, where the name of method starts from `f_`

__Example:__
```
GET pizza.list
GET users.list / GET users.list?id=1

POST auth.login
    body: {"email":"demo@demo.com","password":"123456"}

POST orders.create
    body: {"order":{...}}
```

__Add api:__

If would you like to add new api, just create new class in `api/` folder 
(for example you can use the same way from any class there)
