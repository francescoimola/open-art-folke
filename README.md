# Open Art Folke

Website for Open Art Folke, Folkestone's first artist-run festival of open studios, exhibitions, performances and workshops. A non-profit, unincorporated association.

## Tech Stack

- [Kirby CMS](https://getkirby.com) - File-based content management
- [Vite](https://vitejs.dev/) - Frontend build tool with live reloading

## Installation

```bash
composer install
pnpm install  # or npm install
```

## Development

```bash
pnpm dev      # or npm run dev
```

Visit `localhost:8888` in the browser.

## Build

```bash
pnpm build    # or npm run build
```

## Deployment

The site is configured for Composer-based deployment. The following paths are excluded from version control:

- `/kirby`, `/vendor` - Managed by Composer
- `/content` - Content synced separately via rsync
- `/storage` - User accounts, cache, sessions (server-generated)
