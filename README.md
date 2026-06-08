# Open Art Folke

[![Licence: GPL v3](https://img.shields.io/badge/Licence-GPLv3-blue.svg)](LICENSE.md)
![Kirby CMS](https://img.shields.io/badge/Kirby-5-000000?logo=kirby&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.4-777BB4?logo=php&logoColor=white)
![Vite](https://img.shields.io/badge/Vite-8-646CFF?logo=vite&logoColor=white)

If you've landed here, hello. This is the website for Open Art Folke, Folkestone's first artist-run festival of open studios, exhibitions, performances and workshops.

## It's built with

- [Kirby CMS](https://getkirby.com)
- PHP templates
- [Vite](https://vitejs.dev/) for bundling
- [Graffiti UI](https://graffiti-ui.com/) for styling
- SCSS and PostCSS
- [Lenis](https://lenis.darkroom.engineering/) for smooth scrolling

## How to run it locally

You'll need PHP 8.4, Node, Composer and pnpm.

```bash
composer install
pnpm install
pnpm dev
```

That serves the site at http://localhost:8888, with the panel at http://localhost:8888/panel. Templates, styles and scripts reload as you edit them.

To ship it, push it to `main`. Fortrabbit picks up the push and rebuilds the site on the server. There is nothing to upload by hand. You can edit (most) words and images in the live panel.