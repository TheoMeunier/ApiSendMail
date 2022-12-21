# Api Send mail
This api is for sending emails from a contact form in a portfolio.

## Setup process

- Verify settings in composer.json like the project name and description
- Move .env.example or .env.prod.example to .env and edit parameters to match your project
- Make sure permission are well-defined for 1000:1000 (`sudo chown 1000:1000 /path/ -R`)
- Start containers with `docker-compose up -d`
- Go into the php container with `docker-compose exec php bash`
- Install libs with `composer install`
- Setup nodejs with `yarn`
- Run either `yarn dev` or `yarn build`
- Generate application secret key in .env at field `APP_SECRET` with `bin/console key-generate`
- Migrate migration `bin/console d:m:m`

## Use the Api

I - Configure the .env to connect to your smtp server
```
MAILER_DSN=smtp://user:pass@smtp.exemple.com:25
```
I let you go to the [documentation](https://symfony.com/doc/current/mailer.html) for more information

II - The data expected by the api

Api attention this type of json:
- to: email of the sender
- from: recipient's email
- subject: the subject of the mail
- data: les données du formulaire de contact

```json
{
  "to": "emailto@exemple.com",
  "from": "emailfrom@exemple.com",
  "subject": "Portfolio",
  "data": {
    "name": "Firstname Lastname",
    "email": "client@exemple.com",
    "content": "the client's message"
  }
}
```

