## Setting encryption key
You need to generate the encryption key - 
```bash
$ docker exec auth-service-php-fpm php -r 'echo base64_encode(random_bytes(32)), PHP_EOL;'
```
or
```bash
$ make generate-encryption-key'
```
In the .env file, you need to change param OAUTH2_ENCRYPTION_KEY
## Setting public and private keys
You need to generate public and private keys -
```bash
$ openssl rsa -in private.key -passin pass:_passphrase_ -pubout -out public.key
```
```bash
$ openssl genrsa -passout pass:_passphrase_ -out private.key 2048
```
The generated keys must be moved to the `/var/oauth` folder
## Setting network auth
To authenticate via social networks, you need to configure the following parameters in `.env` -
```dotenv
OAUTH_FACEBOOK_CLIENT_ID=
OAUTH_FACEBOOK_CLIENT_SECRET=

OAUTH_GOOGLE_CLIENT_ID=
OAUTH_GOOGLE_CLIENT_SECRET=
```