<?php

return [
  'debug' => true,

  // Environment-specific settings
  // On Fortrabbit, set KIRBY_LICENSE env var instead of using .license file
  'panel' => [
    'install' => false  // Set to true only for initial remote setup
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
      'avif' => [
        '480w'  => ['width' => 480,  'format' => 'avif', 'quality' => 55],
        '768w'  => ['width' => 768,  'format' => 'avif', 'quality' => 55],
        '1024w' => ['width' => 1024, 'format' => 'avif', 'quality' => 52],
        '1440w' => ['width' => 1440, 'format' => 'avif', 'quality' => 50],
        '1920w' => ['width' => 1920, 'format' => 'avif', 'quality' => 48],
        '2400w' => ['width' => 2400, 'format' => 'avif', 'quality' => 46],
      ],
    ],
  ]
];