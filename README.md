[![Telegram Bot SDK][img-hero]][link-repo]

<p align="center">
<a href="https://phpchat.co"><img src="https://img.shields.io/badge/Slack-PHP%20Chat-5c6aaa.svg?logo=slack&labelColor=4A154B&style=for-the-badge" alt="Join PHP Chat"/></a>
<a href="https://t.me/PHPChatCo"><img src="https://img.shields.io/badge/Chat-on%20Telegram-2CA5E0.svg?logo=telegram&style=for-the-badge" alt="Chat on Telegram"/></a>
<a href="https://github.com/telegram-bot-sdk/telegram-bot-sdk/actions"><img src="https://img.shields.io/github/actions/workflow/status/telegram-bot-sdk/telegram-bot-sdk/ci.yml?style=for-the-badge" alt="Build Status"/></a>
<a href="https://github.com/telegram-bot-sdk/telegram-bot-sdk/releases"><img src="https://img.shields.io/github/release/telegram-bot-sdk/telegram-bot-sdk.svg?style=for-the-badge" alt="Latest Version"/></a>
<a href="https://packagist.org/packages/telegram-bot-sdk/telegram-bot-sdk"><img src="https://img.shields.io/packagist/dt/telegram-bot-sdk/telegram-bot-sdk.svg?style=for-the-badge" alt="Total Downloads"/></a>
</p>

# Telegram Bot API - PHP SDK

> [Telegram Bot SDK][link-site] lets you develop Telegram Bots in PHP easily! Supports [Laravel][link-laravel-package] framework and comes with addons to enhance your bot development experience.
>
> [Telegram Bot API][link-telegram-bot-api] is an HTTP-based interface created for developers keen on building bots for Telegram.
>
> To learn more about the Telegram Bot API, please consult the [Introduction to Bots][link-telegram-bot-api] and [Bot FAQ](https://core.telegram.org/bots/faq) on Telegram's official site.
>
> To get started writing your bots using **[Telegram Bot SDK][link-site]**, please refer the [SDK Documentation][link-docs].
>
> **NOTE:** SDK has been migrated from the original repo [irazasyed/telegram-bot-sdk][link-old-repo] since **4.x**.

## Usage

Documentation for the SDK can be found on the [website][link-docs].

## Upgrade from version <4.x

Starting from version 4.x, the project has been renamed from `irazasyed/telegram-bot-sdk` to `telegram-bot-sdk/telegram-bot-sdk`.

In order to receive the new version and future updates, **you need to rename it in your composer.json**:

```diff
"require": {
-    "irazasyed/telegram-bot-sdk": "(version you use)",
+    "telegram-bot-sdk/telegram-bot-sdk": "(version you use)",
}
```

### Laravel

Laravel service provider in addition to various other Laravel specific features have been moved to its own package.

```diff
"require": {
-    "irazasyed/telegram-bot-sdk": "(version you use)",
+    "telegram-bot-sdk/laravel": "^4.0",
}
```

and run `composer update`.

## Are You Using Telegram Bot SDK?

If you're using this SDK to build your Telegram Bots or have a project that's relevant to this SDK, We'd love to know and share it with the world.

Head over to [Awesome Telegram Bots][link-awesome-telegram-bots] to share, discover, and learn more.

## Contributing

Thank you for considering contributing to the project. Please read [the contributing guide][link-contributing] before creating an issue or sending in a pull request.

## Code of Conduct

Please read our [Code of Conduct][link-code-of-conduct] before contributing or engaging in discussions.

## Security

If you discover a security vulnerability within this project, please email Syed at `security at telegram-bot-sdk.com`. All security vulnerabilities will be promptly addressed. You may view our full security policy [here][link-security-policy].

## Credits

- [Irfaq Syed][link-author]
- [SDK Team][link-team]
- [All Contributors][link-contributors]

## Disclaimer

The Telegram Bot SDK is a third-party library and is not associated with, endorsed by, or affiliated with Telegram or its products. For more details, please read the [Disclaimer][link-disclaimer]

## License

This project is open-sourced software licensed under the [BSD 3-Clause][link-license] license.

[img-hero]: https://user-images.githubusercontent.com/1915268/75023827-7879f780-54be-11ea-98c1-436a14e7e633.png

[link-author]: https://github.com/irazasyed
[link-site]: https://telegram-bot-sdk.com
[link-docs]: https://telegram-bot-sdk.com/docs/
[link-repo]: https://github.com/telegram-bot-sdk/telegram-bot-sdk
[link-old-repo]: https://github.com/irazasyed/telegram-bot-sdk
[link-laravel-package]: https://github.com/telegram-bot-sdk/laravel
[link-team]: https://github.com/orgs/telegram-bot-sdk/people
[link-contributors]: https://github.com/telegram-bot-sdk/telegram-bot-sdk/contributors
[link-license]: https://github.com/telegram-bot-sdk/telegram-bot-sdk/blob/master/LICENSE.md
[link-contributing]: https://github.com/telegram-bot-sdk/telegram-bot-sdk/blob/master/.github/CONTRIBUTING.md
[link-code-of-conduct]: https://github.com/telegram-bot-sdk/telegram-bot-sdk/blob/master/.github/CODE_OF_CONDUCT.md
[link-security-policy]: https://github.com/telegram-bot-sdk/telegram-bot-sdk/security/policy
[link-awesome-telegram-bots]: https://github.com/telegram-bot-sdk/awesome-telegram-bots
[link-telegram-bot-api]: https://core.telegram.org/bots
[link-disclaimer]: https://telegram-bot-sdk.com/license/#disclaimer
