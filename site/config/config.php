<?php

/* Minimal .env loader — Kirby 5 doesn't auto-load .env; parses KEY=VALUE pairs into $_ENV / getenv() and exposes an env() helper. */
$envFile = dirname(__DIR__, 2) . '/.env';
if (is_file($envFile) && is_readable($envFile)) {
  foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
    $line = trim($line);
    if ($line === '' || $line[0] === '#') continue;
    if (!str_contains($line, '=')) continue;
    [$key, $value] = explode('=', $line, 2);
    $key = trim($key);
    $value = trim($value, " \t\"'");
    $_ENV[$key] = $value;
    $_SERVER[$key] = $value;
    putenv("$key=$value");
  }
}

if (!function_exists('env')) {
  function env(string $key, mixed $default = null): mixed
  {
    if (array_key_exists($key, $_ENV)) return $_ENV[$key];
    if (array_key_exists($key, $_SERVER)) return $_SERVER[$key];
    $value = getenv($key);
    return $value === false ? $default : $value;
  }
}

/* .dev is touched only by vite-plugin-kirby; while present, disable HTTP caching so a dropped Vite socket can be fixed with a plain reload. */
$isDev = is_file(dirname(__DIR__, 2) . '/.dev');

return [
  // debug is dev-only; override with KIRBY_DEBUG=true for short-lived troubleshooting.
  'debug' => $isDev ? true : (env('KIRBY_DEBUG', false) === 'true'),

  /* Secure random values for media/preview URLs and cookie signing. See: https://getkirby.com/docs/reference/system/options/content */
  'content' => [
    'salt' => env('KIRBY_CONTENT_SALT'),
  ],
  'cookie' => [
    'key' => env('KIRBY_COOKIE_KEY'),
  ],

  'hooks' => [
    'route:after' => function () use ($isDev) {
      if ($isDev && headers_sent() === false) {
        header('Cache-Control: no-store, no-cache, must-revalidate');
      }
    },

    /* After a deploy, Vite's hashed asset names change and invalidate cached HTML. */
    /* Can't flush from pnpm build (Fortrabbit builds in isolated stage). Fingerprint manifest's mtime and flush cache once. */
    /* Marker lives per-hostname, matching Kirby's own page-cache prefix — otherwise Fortrabbit's */
    /* internal health-check host consumes the marker first and the real domain stays stale. */
    'route:before' => function () use ($isDev) {
      if ($isDev === true) {
        return;
      }

      $manifest = dirname(__DIR__, 2) . '/public/dist/.vite/manifest.json';
      if (is_file($manifest) === false) {
        return;
      }

      $prefix      = str_replace(['/', ':'], '_', kirby()->system()->indexUrl());
      $marker      = kirby()->root('cache') . '/' . $prefix . '/.build';
      $fingerprint = (string) filemtime($manifest);
      $seen        = is_file($marker) ? @file_get_contents($marker) : null;

      if ($seen !== $fingerprint) {
        kirby()->cache('pages')->flush();
        @file_put_contents($marker, $fingerprint, LOCK_EX);
      }
    },
  ],

  /* Environment-specific settings. Panel installer is OFF by default; flip KIRBY_PANEL_INSTALL=true once to create first admin, then remove. */
  'panel' => [
    'install' => env('KIRBY_PANEL_INSTALL', false) === 'true',

    /* Disable Panel's runtime Vue compiler — we ship no custom Panel plugins that need it. */
    'vue' => [
      'compiler' => false,
    ],
  ],

  /* Pages cache is OFF in dev (edits show up on next reload) and ON in production. */
  /* Home excluded: kirby-uniform needs a fresh CSRF token per request. */
  'cache' => [
    'pages' => $isDev ? false : [
      'home' => false,
    ],
  ],

  'zapier' => [
    'webhook' => env('PROGRAMME_SIGNUP_WEBHOOK', ''),
  ],

  /* SEO routes. sitemap.xml from bnomei/kirby3-feed using index() (all published pages, no sort-number prefixes). */
  /* media page excluded (asset container). robots.txt allows everything and points at sitemap. */
  'routes' => [
    [
      'pattern' => 'sitemap.xml',
      'method'  => 'GET',
      'action'  => fn () => sitemap(
        fn () => site()->index()->filterBy('intendedTemplate', '!=', 'media')
      ),
    ],
    [
      'pattern' => 'robots.txt',
      'method'  => 'GET',
      'action'  => function () {
        $body = "User-agent: *\nAllow: /\nSitemap: " . site()->url() . "/sitemap.xml\n";
        return new Kirby\Http\Response($body, 'text/plain');
      },
    ],
  ],

  /* Responsive image recipe via the image snippet. Two presets (WebP + original-format) for appropriately-sized images per device. Keys are w-descriptors paired with sizes attribute. */
    'thumbs' => [
        'srcsets' => [
            'default' => [
                '480w'  => ['width' => 480,  'quality' => 80],
                '768w'  => ['width' => 768,  'quality' => 80],
                '1024w' => ['width' => 1024, 'quality' => 80],
                '1440w' => ['width' => 1440, 'quality' => 78],
                '1920w' => ['width' => 1920, 'quality' => 75],
                '2400w' => ['width' => 2400, 'quality' => 72],
            ],
            /* No AVIF — see site/snippets/image.php for why. */
            'webp' => [
                '480w'  => ['width' => 480,  'format' => 'webp', 'quality' => 76],
                '768w'  => ['width' => 768,  'format' => 'webp', 'quality' => 76],
                '1024w' => ['width' => 1024, 'format' => 'webp', 'quality' => 75],
                '1440w' => ['width' => 1440, 'format' => 'webp', 'quality' => 73],
                '1920w' => ['width' => 1920, 'format' => 'webp', 'quality' => 70],
                '2400w' => ['width' => 2400, 'format' => 'webp', 'quality' => 68],
            ],
        ],
    ],

    // Minify HTML output on production (skip in dev for readable source).
    'afbora.kirby-minify-html' => [
        'enabled' => ! $isDev,
        'ignore'  => [
            'sitemap',
            'rss',
        ],
    ],

    // humans.txt credits (sylvainallignol/humans), served at /humans.txt.
    'sylvainallignol.humans' => [
        'TEAM' => [
            [
                'Name'    => 'Francesco Imola',
                'Job'     => 'Design, copy & build',
                'Website' => 'https://francescoimola.com',
            ],
        ],
        'SITE' => [
            'Standards'  => 'HTML5, CSS3',
            'Components' => 'Kirby CMS, Graffiti UI, Vite, Lenis',
            'Software'   => 'PHP, SCSS, JavaScript',
        ],
        'THANKS' => 'Kirby CMS (https://getkirby.com)',
    ],
];