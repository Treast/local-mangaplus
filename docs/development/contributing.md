---
lang: en-GB
title: Contributing
description: How to contribute to Local MangaPlus.
---

# Contributing to Local MangaPlus

We welcome contributions of all kinds to Local MangaPlus, from bug reports to new features, documentation improvements, and code cleanups. Before you start, please take a moment to read these guidelines.

## Code of Conduct

Please note that this project is released with a [Contributor Code of Conduct](https://github.com/Treast/local-mangaplus/blob/main/CODE_OF_CONDUCT.md). By participating in this project, you agree to abide by its terms.

## How to Contribute

### Reporting Bugs

If you find a bug, please open an issue on our [GitHub repository](https://github.com/Treast/local-mangaplus/issues). When reporting a bug, please include:

-   A clear and concise description of the bug.
-   Steps to reproduce the behavior.
-   Expected behavior.
-   Screenshots or videos if applicable.
-   Your operating system and browser.

### Suggesting Enhancements

We love new ideas! If you have a suggestion for an enhancement or a new feature, please open an issue on our [GitHub repository](https://github.com/Treast/local-mangaplus/issues). Please describe the enhancement, why you think it would be valuable, and any potential implementation details.

### Pull Request Guidelines

1.  **Fork the repository** and clone it to your local machine.
2.  **Create a new branch** from `main` for your feature or bug fix:
    ```bash
    git checkout main
    git pull origin main
    git checkout -b feature/your-feature-name
    ```
    or
    ```bash
    git checkout -b bugfix/your-bugfix-name
    ```
3.  **Set up your development environment** as described in the [Installation Guide](/guide/installation.html#build-it-yourself).
4.  **Make your changes**. Ensure your code adheres to the project's coding standards (see below).
5.  **Write tests** for your changes, if applicable.
6.  **Run tests** to ensure everything is still working correctly (see below).
7.  **Commit your changes** using a descriptive commit message (see below).
8.  **Push your branch** to your forked repository.
9.  **Open a Pull Request** against the `main` branch of the original repository.
    -   Provide a clear title and description for your PR.
    -   Reference any related issues.
    -   Be prepared to discuss your changes and address feedback.

## Development Setup

To get your development environment up and running, please refer to the [Build it Yourself section of the Installation Guide](/guide/installation.html#build-it-yourself).

## Coding Style

We strive to maintain a consistent coding style throughout the project. We use various tools to enforce this:

-   **PHP**: We follow the [Symfony Coding Standards](https://symfony.com/doc/current/contributing/code/standards.html) and use `php-cs-fixer`. You can check your code with:
    ```bash
    task cs-fixer:check
    # To fix automatically:
    task cs-fixer:fix
    ```
-   **Twig**: We use `twig-cs-fixer` for Twig template formatting.
    ```bash
    task twig-cs-fixer:check
    # To fix automatically:
    task twig-cs-fixer:fix
    ```
-   **JavaScript/TypeScript/JSON/Markdown**: We use [Biome](https://biomejs.dev/) for formatting and linting. The configuration is in `biome.json`.
    ```bash
    # Check for formatting and linting issues
    biome check --app .
    # Fix formatting issues
    biome format --write .
    ```

Please ensure your code passes these checks before submitting a Pull Request.

## Commit Message Guidelines

We use [Gitmoji](https://gitmoji.dev/) to make our commit messages clear and informative at a glance. Please start your commit message with the appropriate Gitmoji, followed by a space and the subject.

The format is:
```
:gitmoji: Subject
```

**Examples:**
-   `:sparkles: Add chapter download functionality`
-   `:bug: Correct image display on mobile`
-   `:memo: Update docker-compose example in installation guide`
-   `:recycle: Improve error handling in MangaPlus client`

Please refer to the [full Gitmoji list](https://gitmoji.dev/) to find the most appropriate emoji for your changes. Here are some common ones:

-   `:sparkles:` for new features.
-   `:bug:` for bug fixes.
-   `:memo:` for documentation changes.
-   `:lipstick:` for styling and UI improvements.
-   `:recycle:` for refactoring code.
-   `:zap:` for performance improvements.
-   `:white_check_mark:` for adding or updating tests.
-   `:wrench:` for chores and tooling.
