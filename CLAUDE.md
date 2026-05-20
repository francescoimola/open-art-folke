# Open Art Folke — Maintenance Guide

## Starting the dev server

```bash
pnpm dev
```

This starts two things at once:
- The website at **http://localhost:8888**
- The Vite asset compiler in the background

Requires Node.js, pnpm, and PHP 8.4 (`/opt/homebrew/opt/php@8.4/bin/php`) to be installed.

## Editing content (recommended)

Open **http://localhost:8888/panel** in your browser.  
Log in, go to **Site → Pages**, pick a page, and edit the Text field.  
Changes save instantly and appear on the front-end on refresh.

## Editing content (manual)

Plain-text files inside `content/`:

| Page | File |
|------|------|
| Home | `content/home/home.txt` |
| About | `content/about/about.txt` |
| Contact | `content/contact/contact.txt` |

Fields are separated by `----`. Save the file and refresh the browser.

## Adding a new page

1. Create a folder inside `content/` (e.g. `content/events/`)
2. Add a `.txt` file inside it with `Title:` and `Text:` fields
3. Add a matching blueprint in `site/blueprints/pages/`
4. Add a matching template in `site/templates/`
