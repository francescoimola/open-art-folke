<?php

// Minimal .env loader: parses KEY=VALUE pairs into $_ENV / getenv() and
// exposes a tiny env() helper. Kirby 5 doesn't auto-load .env files, but
// they're gitignored at the project root so this is the canonical place
// to keep secrets out of version control.
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

// Dev-only: the `.dev` file is present only while the Vite dev server runs
// (written/removed by vite-plugin-kirby). When it exists we tell the browser
// never to cache page responses, so a stale/broken page from a dropped Vite
// connection can always be fixed with a plain reload — no manual cache-clear.
$isDev = is_file(dirname(__DIR__, 2) . '/.dev');

return [
  // Debug must stay OFF in production (it leaks stack traces / paths). Local
  // dev (Vite running) keeps it on; on the server set KIRBY_DEBUG=true only
  // for short-lived troubleshooting.
  'debug' => $isDev ? true : (env('KIRBY_DEBUG', false) === 'true'),

  'hooks' => [
    'route:after' => function () use ($isDev) {
      if ($isDev && headers_sent() === false) {
        header('Cache-Control: no-store, no-cache, must-revalidate');
      }
    },

    // Bust the rendered-page cache whenever a new build is deployed.
    //
    // Vite re-hashes asset filenames (index-<hash>.css) on every build and
    // deletes the old ones, but cached page HTML embeds the old names — so
    // after a deploy, cached pages 404 their CSS and image thumbnails until
    // the cache is cleared. We can't clear it from the `pnpm build` step:
    // Fortrabbit runs the build in an isolated deploy stage, so a flush
    // there never touches the live storage/. Instead we detect a new build
    // at runtime — the Vite manifest's mtime changes on every deploy — and
    // flush the pages cache once. The first request after a deploy pays a
    // single re-render; everything after is served fresh from a rebuilt
    // cache. Cheap (one filemtime + string compare per request) and self-
    // healing, so no manual SSH flush is needed after `git push`.
    'route:before' => function () use ($isDev) {
      if ($isDev === true) {
        return;
      }

      $manifest = dirname(__DIR__, 2) . '/public/dist/.vite/manifest.json';
      if (is_file($manifest) === false) {
        return;
      }

      $marker      = kirby()->root('cache') . '/.build';
      $fingerprint = (string) filemtime($manifest);
      $seen        = is_file($marker) ? @file_get_contents($marker) : null;

      if ($seen !== $fingerprint) {
        kirby()->cache('pages')->flush();
        @file_put_contents($marker, $fingerprint, LOCK_EX);
      }
    },
  ],

  // Environment-specific settings
  // Panel installer is OFF by default. To create the first admin user on a
  // fresh server, set KIRBY_PANEL_INSTALL=true in the Fortrabbit ENV vars,
  // create the account at /panel, then remove the var again.
  'panel' => [
    'install' => env('KIRBY_PANEL_INSTALL', false) === 'true'
  ],

  // In development (Vite running) the pages cache is OFF, so template,
  // snippet and content edits show up on the next reload instead of serving
  // stale rendered HTML — this is what makes live-reload reliable. In
  // production the pages cache is ON for speed; the home page is excluded
  // because kirby-uniform needs a fresh CSRF token per request.
  'cache' => [
    'pages' => $isDev ? false : [
      'home' => false,
    ],
  ],

  'zapier' => [
    'webhook' => env('PROGRAMME_SIGNUP_WEBHOOK', ''),
  ],

  // Responsive image recipe, defined once and reused everywhere via the
  // `image` snippet. One shared width ladder; three presets so a single
  // high-res upload auto-generates AVIF (smallest) → WebP → original-format
  // fallback. Keys are `w`-descriptors that pair with the `sizes` attribute.
  // Kirby never upscales past the source, so smaller originals simply top out.
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
      'webp' => [
        '480w'  => ['width' => 480,  'format' => 'webp', 'quality' => 76],
        '768w'  => ['width' => 768,  'format' => 'webp', 'quality' => 76],
        '1024w' => ['width' => 1024, 'format' => 'webp', 'quality' => 75],
        '1440w' => ['width' => 1440, 'format' => 'webp', 'quality' => 73],
        '1920w' => ['width' => 1920, 'format' => 'webp', 'quality' => 70],
        '2400w' => ['width' => 2400, 'format' => 'webp', 'quality' => 68],
      ],
      // No AVIF preset: the `image` snippet emits only WebP + original-format
      // fallback. AVIF encoding of our large source photos OOM-kills the
      // hosting container's web workers (libavif allocates outside PHP's
      // memory_limit), 503ing even at 1920w. WebP is cheap to encode and the
      // width ladder below serves every device — including large retina —
      // the right resolution via srcset. Revisit AVIF only if source images
      // are right-sized or the container gets more RAM.
    ],
  ]
];