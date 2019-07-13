# How to use felixdorn/dot-env
> composer require `felixdorn/dot-env`

> Easier than you think ! 
```php
    use Felix\DotEnv;
    DotEnv::register('.env');
```
> Note that you could register multiple .env

.env
```dotenv
FOO=BAR # You can access to FOO by typing $_SERVER['FOO'] or $_ENV['FOO'] or getenv('FOO')
NAME=Hello${FOO} #  Will print HelloBar
NICKNAME=Felix
# You can write comment ! Yeah !
SENTENCE="Hey Guys" # space allowed only when value is in parentheses
ANOTHER_SENTENCES="Hey ${NICKNAME}" # will print Hey Felix
baDCase=DUMMY_VALUE # baDCase became BADCASE when parsing so access to baDCase value with $_SERVER['BADCASE']
something # To make workflow more simple, this will output an empty value like $_ENV['SOMETHING']
fdsldjs=${UNEXISTING} # This will be simply removed while this value doesn't exist 
```
