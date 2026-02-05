---
lang: en-GB
title: Architecture
description: A look at the technical architecture of Local MangaPlus.
---

# Architecture

Local MangaPlus is built as a modern web application using the Symfony framework. The architecture is designed to be modular, scalable, and easy to maintain.

Here is a breakdown of the main components:

## Core: Symfony Framework

The entire application is built on top of the [Symfony](https://symfony.com/) framework. Symfony provides a solid foundation with a powerful dependency injection container, a flexible event dispatcher, and a robust HTTP kernel. This allows for a clean separation of concerns and a structured codebase.

The main components of the application are organized into the following directories within `src/`:

- `Controller/`: Handles incoming HTTP requests and returns responses.
- `Entity/`: Contains Doctrine entities, which are PHP objects that represent rows in the database.
- `Repository/`: Contains Doctrine repositories for querying entities.
- `Command/`: For creating custom console commands (e.g., for database tasks or cron jobs).
- `Message/` & `MessageHandler/`: For handling asynchronous operations with Symfony Messenger.

## Database: Doctrine & SQLite

Data persistence is managed by [Doctrine](https://www.doctrine-project.org/), the default ORM for Symfony. Doctrine makes it easy to work with the database by allowing developers to map database tables to PHP objects (Entities).

For simplicity and portability, the default database is **SQLite**. This means the entire database is stored in a single file located in `var/data.db`, which makes backups and development setup straightforward.

## Frontend: Twig & Symfony UX

The frontend is rendered server-side using the [Twig](https://twig.symfony.com/) templating engine.

To create a more interactive experience without the complexity of a full-blown JavaScript framework, the project leverages the [Symfony UX](https://symfony.com/ux) ecosystem:

- **Symfony UX LiveComponents**: For creating dynamic components with real-time updates directly from the server.
- **Stimulus**: A modest JavaScript framework for connecting HTML to JavaScript objects. It's used for client-side interactivity.
- **Alpine.js**: For small, declarative client-side behaviors.
- **Tailwind CSS**: A utility-first CSS framework for rapid UI development.

## Automated Jobs: Scheduler & Messenger

A key feature of Local MangaPlus is its ability to automatically check for and download new chapters. This is handled by a combination of a scheduler and Symfony's Messenger component.

- **Scheduler**: A cron job, managed by `src/Schedule.php`, runs periodically (e.g., every minute) to dispatch messages for checking manga updates.
- **Symfony Messenger**: These messages are handled asynchronously by message handlers (`src/MessageHandler/`). This ensures that long-running tasks like checking multiple manga or downloading files do not block the main application or HTTP requests.

## MangaPlus API Communication

The application communicates with the official MangaPlus services to get information about manga and chapters. This is done through a client that interacts with what appears to be a gRPC API.

The `resources/ShueishaMangaPlus.proto` file defines the structure of the API requests and responses, providing a typed and efficient way to communicate with the service.