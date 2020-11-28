# CHS MCLink Backend

This web backend is built on the [laravel/lumen][1] micro framework.

It handles the requests from [gudchalmers/chs-mclink][2] and [gudchalmers/chs-mclink-velocity][3] to check and register Minecraft accounts with a student email, it shares a token to auth the systems.

When trying to access the api without the shared token or any other url a default page is displayed.

It stores a hashed version of the email that it sent the verification email to along with the Minecraft UUID.

## Requirements

- PHP >= 7.2
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- A MySQL server
- A way to send emails
- [Composer][4]
- Apache (If running Nginx have a look at [this][5])

## Setup

First install all the dependencies.
```sh
composer install --optimize-autoloader --no-dev
```

Then rename the `.env.example` to `.env` and fill it in with your information.

A note on the `APP_KEY` value from the [Lumen setup][6]:
> #### Application Key
> The next thing you should do after installing Lumen is set your application key to a random string.
> Typically, this string should be 32 characters long.
> The key can be set in the .env environment file.
> If you have not renamed the .env.example file to .env, you should do that now.
> **If the application key is not set, your user encrypted data will not be secure!**

The `TOKEN` value is the shared key with for [gudchalmers/chs-mclink][2] and [gudchalmers/chs-mclink-velocity][3].

## License

[MIT][7]

[1]: https://lumen.laravel.com/
[2]: https://github.com/gudchalmers/chs-mclink
[3]: https://github.com/gudchalmers/chs-mclink-velocity
[4]: https://getcomposer.org/
[5]: https://laravel.com/docs/7.x/deployment#nginx
[6]: https://lumen.laravel.com/docs/7.x#installation
[7]: https://choosealicense.com/licenses/mit/
