<?php

use Kirby\Cms\Page;

/**
 * Sponsor page model.
 *
 * Holds the sponsors list (a structure field authored in the panel) and the
 * logic to render each sponsor's logo safely. Templates only call methods and
 * never touch raw SVG markup.
 */
class SponsorPage extends Page
{
  /**
   * Sanitised, theme-aware inline SVG for one sponsor's logo.
   *
   * Kirby's Sane\Svg already strips dangerous markup on upload; this is a
   * second, defensive pass plus the cosmetic transforms we always want:
   *   - drop <script>/<style>/<foreignObject> and any on* event attributes
   *   - force every fill onto currentColor so the logo inherits --primary
   *   - strip width/height from the root <svg> so it scales by its viewBox
   *   - add role="img" + an accessible label
   * Returns '' when no file is set or the SVG can't be parsed.
   */
  public function sponsorLogo(Kirby\Cms\StructureObject $sponsor): string
  {
    $file = $sponsor->logo()->toFile();

    if (!$file) {
      return '';
    }

    $raw = trim($file->read());

    if ($raw === '') {
      return '';
    }

    $dom = new DOMDocument();
    $prev = libxml_use_internal_errors(true);
    $loaded = $dom->loadXML($raw, LIBXML_NONET | LIBXML_NOERROR | LIBXML_NOWARNING);
    libxml_clear_errors();
    libxml_use_internal_errors($prev);

    if (!$loaded || !$dom->documentElement) {
      return '';
    }

    $svg = $dom->documentElement;

    if (strtolower($svg->localName) !== 'svg') {
      return '';
    }

    // Strip dangerous elements.
    foreach (['script', 'style', 'foreignObject'] as $tag) {
      $nodes = $svg->getElementsByTagName($tag);
      for ($i = $nodes->length - 1; $i >= 0; $i--) {
        $node = $nodes->item($i);
        $node->parentNode?->removeChild($node);
      }
    }

    // Walk every element: drop on* handlers, normalise fills to currentColor.
    $walk = function (DOMNode $node) use (&$walk): void {
      if ($node instanceof DOMElement) {
        foreach (iterator_to_array($node->attributes ?? []) as $attr) {
          if (str_starts_with(strtolower($attr->name), 'on')) {
            $node->removeAttribute($attr->name);
          }
        }
        if ($node->hasAttribute('fill') && strtolower($node->getAttribute('fill')) !== 'none') {
          $node->setAttribute('fill', 'currentColor');
        }
      }
      foreach (iterator_to_array($node->childNodes) as $child) {
        $walk($child);
      }
    };
    $walk($svg);

    // Scale by viewBox, not fixed pixels.
    $svg->removeAttribute('width');
    $svg->removeAttribute('height');

    $svg->setAttribute('role', 'img');
    $svg->setAttribute('aria-label', $sponsor->name()->value() . ' logo');

    return $dom->saveXML($svg);
  }
}
