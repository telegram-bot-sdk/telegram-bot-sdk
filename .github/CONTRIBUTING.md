# Contributing Guide

We welcome contributions to this project. Please read the following guide before posting an issue or sending in pull requests. 
Please also read our [Code of Conduct](CODE_OF_CONDUCT.md) before contributing or engaging in discussions.

## Issues

- **Feature requests** need to describe as thoroughly as possible and perhaps contain some info on how you would implement it.
- **Bug reports** need to be described in detail what the problem is, how it was triggered and perhaps contain a possible solution.
- **Questions** are free to be asked about the internals of the codebase and about the project, check out [Support](SUPPORT.md) for more details.

## Pull Requests

- **Feature requests** first need to be discussed and accepted through an issue before sending in a pull request.
- **Bug fixes** should contain [regression tests](https://laracasts.com/lessons/regression-testing).
- **[Coding standards](#coding-standards)** should be followed.
- **Add tests** Ensure that the current tests pass, and if you've added something new, add the tests where relevant.
- **Document any change in behaviour** - Make sure the relevant documentation are up-to-date.
- **Consider our release cycle** - We try to follow [SemVer v2.0.0](https://semver.org/). Randomly breaking public APIs is not an option.
- **Create feature branches** - Don't ask us to pull from your master branch.
- **One pull request per feature** - If you want to do more than one thing, send multiple pull requests.
- **Send coherent history** - Make sure each individual commit in your pull request is meaningful.

## Coding Standards

- [PSR-12 Coding Standard](https://www.php-fig.org/psr/psr-12/) will automatically be applied by Github Actions.
- Make sure to typehint and declare return type where applicable.

## Testing

All tests can be run with the following command.

``` bash
$ composer test
```

**Happy coding**!
