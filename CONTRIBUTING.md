# Contributing to GameShop Magento 2 Extension

🎮 Thank you for your interest in contributing to the GameShop Magento 2 extension! We welcome all contributions, whether it's bug reports, feature requests, documentation improvements, or code contributions.

## 📋 Table of Contents
- [How Can I Contribute?](#how-can-i-contribute)
  - [Reporting Bugs](#reporting-bugs)
  - [Suggesting Enhancements](#suggesting-enhancements)
  - [Pull Requests](#pull-requests)
- [Development Setup](#development-setup)
- [Coding Standards](#coding-standards)
- [Commit Message Guidelines](#commit-message-guidelines)
- [Testing](#testing)
- [License](#license)

## How Can I Contribute?

### Reporting Bugs

Bugs are tracked as [GitHub issues](https://github.com/blopa/magento-2-retro-game-shop-page/issues). When creating a bug report, please include:

1. A clear, descriptive title
2. Steps to reproduce the issue
3. Expected vs. actual behavior
4. Magento version, PHP version, and any relevant environment details
5. Screenshots or error logs if applicable

### Suggesting Enhancements

We welcome enhancement suggestions! Please:

1. Check if a similar feature request already exists
2. Clearly describe the enhancement and why it would be valuable
3. Include any relevant use cases or examples

### Pull Requests

1. **Fork** the repository and create your branch from `main`
2. **Test** your changes thoroughly
3. **Document** any new features or changes in the README
4. **Update** tests if applicable
5. **Lint** your code before submitting
6. **Submit** a pull request with a clear description of changes

## Development Setup

### Prerequisites

- Magento 2.4.x
- PHP 7.4+
- Composer
- Node.js 14+ (for frontend development)

### Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/blopa/magento-2-retro-game-shop-page.git
   ```

2. Install dependencies:
   ```bash
   composer install
   ```

3. Set up the module:
   ```bash
   bin/magento module:enable Werules_GameShop
   bin/magento setup:upgrade
   bin/magento setup:di:compile
   bin/magento setup:static-content:deploy -f
   ```

## Coding Standards

We follow Magento's coding standards:
- [Magento 2 Coding Standards](https://devdocs.magento.com/guides/v2.4/coding-standards/bk-coding-standards.html)
- PSR-12 for PHP code
- ESLint for JavaScript

### PHP Code Sniffer

Run PHPCS to check for coding standard violations:
```bash
vendor/bin/phpcs --standard=Magento2 app/code/Werules/GameShop
```

## Commit Message Guidelines

We follow [Conventional Commits](https://www.conventionalcommits.org/) for commit messages:

```
<type>(<scope>): <subject>
<BLANK LINE>
[optional body]
<BLANK LINE>
[optional footer(s)]
```

### Types:
- `feat`: A new feature
- `fix`: A bug fix
- `docs`: Documentation changes
- `style`: Code style changes (formatting, etc.)
- `refactor`: Code changes that don't fix bugs or add features
- `perf`: Performance improvements
- `test`: Adding or modifying tests
- `chore`: Changes to build process or auxiliary tools

## Testing

### Unit Tests

Run PHPUnit tests:
```bash
vendor/bin/phpunit -c dev/tests/unit/phpunit.xml.dist app/code/Werules/GameShop/Test/Unit
```

### Integration Tests

Run integration tests:
```bash
vendor/bin/phpunit -c dev/tests/integration/phpunit.xml.dist app/code/Werules/GameShop/Test/Integration
```

## License

By contributing, you agree that your contributions will be licensed under the [MIT License](LICENSE).