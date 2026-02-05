# Local MangaPlus

[![License: GPL v3](https://img.shields.io/badge/License-GPLv3-blue.svg)](https://www.gnu.org/licenses/gpl-3.0) [![Symfony](https://img.shields.io/badge/Symfony-8.0.3-000000?style=flat&logo=symfony)](https://symfony.com)
![Github CI](https://github.com/Treast/local-mangaplus/actions/workflows/deploy.yml/badge.svg)

A dedicated MangaPlus monitor that automatically fetches your bookmarked chapters the second they are published. No more manual checking - just sync and read.

## Screenshots

### Homepage
![Homepage](https://raw.githubusercontent.com/Treast/local-mangaplus/refs/heads/main/docs/home.png)

### Library
![Homepage](https://raw.githubusercontent.com/Treast/local-mangaplus/refs/heads/main/docs/library.png)

### Manga page
![Homepage](https://raw.githubusercontent.com/Treast/local-mangaplus/refs/heads/main/docs/manga.png)


## Features
-   **Automated monitoring**: Tracks the official MangaPlus catalog for new releases in real-time.
-   **Smart fetching**: Seamlessly archives new chapters as they drop.
-   **100% local & private**: Self-hosted, no account, no tracking, no cloud syncing

## Tech Stack
-   **Backend**: PHP 8.5+ / Symfony 8+
-   **Database**: SQLite
-   **Frontend**: Twig, Tailwind CSS, Alpine.js, & Symfony UX Live Components

## Getting started

The easiest way to get Local MangaPlus up and running is with Docker.

### Quick Start with Docker

Run the following command to start Local MangaPlus:

```sh
docker run -d \
  --name local-mangaplus \
  -p 8080:80 \
  -v local_mangaplus_data:/app/var \
  --restart unless-stopped \
  ghcr.io/treast/local-mangaplus:latest
```

Then, open your browser to [http://localhost:8080](http://localhost:8080).

For more detailed installation instructions, including Docker Compose and building from source, please refer to our [Installation Guide](https://github.com/Treast/local-mangaplus/blob/main/docs/guide/installation.md).

## Documentation

Full documentation, including usage, architecture, and advanced topics, is available [here](https://github.com/Treast/local-mangaplus/blob/main/docs/README.md).

## Contributing

We welcome contributions! Please see our [Contributing Guide](https://github.com/Treast/local-mangaplus/blob/main/docs/development/contributing.md) for details on how to get started.

## License

This project is licensed under the GPL v3 License - see the [LICENSE](LICENSE) file for details.

