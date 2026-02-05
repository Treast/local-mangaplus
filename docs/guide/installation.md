---
lang: en-GB
title: Installation
description: How to install and run Local MangaPlus
---

# Installation

There are two main ways to install Local MangaPlus: using a pre-built Docker image (recommended for most users) or building the application from the source code.

## Docker (Recommended)

This is the easiest and fastest way to get started.

### Run Command

You can run the application with a single `docker run` command. This will pull the latest image from the GitHub Container Registry and start it.

```sh
docker run -d \
  --name local-mangaplus \
  -p 8080:80 \
  -v local_mangaplus_data:/app/var \
  --restart unless-stopped \
  ghcr.io/treast/local-mangaplus:latest
```

After running the command, the application will be available at [http://localhost:8080](http://localhost:8080).

> **Note**: The first port number in `-p 8080:80` can be changed to any port you prefer on your host machine. The volume `local_mangaplus_data` will store the application's database and downloaded chapters, ensuring your data persists even if you update or recreate the container.

### Docker Compose

If you prefer using `docker-compose`, you can use the following configuration in your `compose.yaml` file:

```yaml
services:
  local_mangaplus:
    image: ghcr.io/treast/local-mangaplus:latest
    container_name: local-mangaplus
    restart: unless-stopped
    ports:
      - "8080:80"
    volumes:
      - local_mangaplus_data:/app/var

volumes:
  local_mangaplus_data:
```

Save this as `compose.yaml` and run `docker-compose up -d`. The application will be available at [http://localhost:8080](http://localhost:8080).

## Build it Yourself

If you want to modify the code or contribute to the project, you'll need to build the application from the source.

### Prerequisites

- [Docker](https://www.docker.com)
- [Task](https://taskfile.dev) (recommended)
- [Git](https://git-scm.com/)

### 1. Clone the Repository

First, clone the project from GitHub:

```bash
git clone https://github.com/Treast/local-mangaplus.git
cd local-mangaplus
```

### 2. Install Dependencies

The project uses `composer` for PHP dependencies and `npm` for frontend dependencies. The provided `Taskfile.yml` simplifies this process.

```bash
# This will install both composer and npm dependencies
task install
```

### 3. Setup Environment

Copy the development environment file:
```bash
cp .env .env.local
```
This file contains the default configuration for the development environment. You may edit it if needed (e.g., to change ports).

### 4. Database Setup

The application uses Doctrine Migrations to manage the database schema. Run the following command to create the database and apply the migrations:

```bash
task db:migrate
```

### 5. Run the Application

Now you can build and start the Docker containers for the development environment.

```bash
# Build the images
task build

# Start the containers in detached mode
task up
```

The application should now be running and accessible at [https://localhost](https://localhost). The development environment uses Caddy to provide automatic HTTPS.
