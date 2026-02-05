---
lang: en-GB
title: Roadmap
description: Future plans for Local MangaPlus.
---

# Roadmap

This document outlines a potential roadmap for Local MangaPlus, focusing on features that could significantly enhance the user experience and make it a best-in-class self-hosted manga reader. These are suggestions and ideas to inspire future development.

Your input is what truly shapes the project! If any of these ideas resonate with you, or if you have different ones, please [open an issue](https://github.com/Treast/local-mangaplus/issues) to start a discussion.

## Short-term: Reader & Library Polish

These features focus on improving the core experience of reading and managing the library.

-   **Reading Progress Tracking**:
    -   Automatically save the last read page for each chapter.
    -   Mark chapters as "in progress" or "read".
    -   A "Continue Reading" section on the homepage.
-   **Enhanced Search & Filtering**:
    -   Filter library by read/unread status.
    -   Full-text search on manga titles and descriptions.

## Mid-term: Deeper Integration & Smarter Library

These ideas aim to connect Local MangaPlus with other services and make the library more intelligent.

-   **OPDS Feed (Open Publication Distribution System)**:
    -   This is a game-changer for mobile users. Exposing the library via an OPDS feed would allow users to connect to their Local MangaPlus instance with a huge range of compatible reader apps (like Tachiyomi for Android or Paperback for iOS), giving them a native mobile reading experience while keeping their manga self-hosted.
-   **Richer Metadata from External Sources**:
    -   Integrate with services like **AniList** or **MyAnimeList** to fetch richer metadata for your manga series:
        -   Alternative titles, genres, author/artist info.
        -   Community ratings, status (ongoing, finished).
        -   This would make the library much more engaging and browsable.

## Long-term: The "Ultimate" Self-Hosted Experience

These are ambitious, long-term goals that would solidify Local MangaPlus as a premier self-hosted application.

-   **Full Progressive Web App (PWA) with Offline Support**:
    -   Allow users to "install" the app on their devices.
    -   Pre-download selected chapters for offline reading directly in the browser, perfect for travel.
-   **Smart Recommendations**:
    -   Based on the manga in a user's library, recommend other series available on MangaPlus. This could be based on genre, author, or "users who liked X also liked Y" type of logic (if metadata is available).
-   **Backup & Restore**:
    -   Create a simple UI in the settings to create a zip backup of the database and manga covers, and a way to restore from it.

## How to Influence the Roadmap

-   **Open Issues**: For new features or significant changes, open an issue on GitHub to discuss your ideas.
-   **Submit Pull Requests**: The fastest way to get a feature implemented is often to contribute the code yourself!
-   **Provide Feedback**: Let us know what you love, what you don't, and what you'd like to see next.
