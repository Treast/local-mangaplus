# Local MangaPlus

[![License: GPL v3](https://img.shields.io/badge/License-GPLv3-blue.svg)](https://www.gnu.org/licenses/gpl-3.0) [![Symfony](https://img.shields.io/badge/Symfony-8.0.3-000000?style=flat&logo=symfony)](https://symfony.com)

A dedicated MangaPlus monitor that automatically fetches your bookmarked chapters the second they are published. No more manual checking - just sync and read.

## Screenshots

### Homepage
![Homepage](https://raw.githubusercontent.com/Treast/local-mangaplus/refs/heads/main/docs/home.png)

### Library
![Homepage](https://raw.githubusercontent.com/Treast/local-mangaplus/refs/heads/main/docs/library.png)

### Manga page
![Homepage](https://raw.githubusercontent.com/Treast/local-mangaplus/refs/heads/main/docs/manga.png)


## Features
- **Automated monitoring**: Tracks the official MangaPlus catalog for new releases in real-time.
- **Smart fetching**: Seamlessly archives new chapters as they drop.
- **100% local & private**: Self-hosted, no account, no tracking, no cloud syncing

## Tech Stack
- **Backend**: PHP 8.5+ / Symfony 8
- **Database**: SQLite
- **Frontend**: Twig, Tailwind CSS, Alpine.js, & Symfony UX Live Components

## Getting started

### Prerequisites
- [Docker](https://www.docker.com)
- [Task](https://taskfile.dev) (recommended)


1. **Clone the repository**
```bash
git clone https://github.com/Treast/local-mangaplus.git
local-mangaplus
```

2. **Install dependencies**
```bash
task composer:install
```

3. **Database setup**
```bash
task db:migrate
```

4. **Run container**
```bash
task build
task up
```

5. **Open the website**

[https://localhost/](https://localhost/)
