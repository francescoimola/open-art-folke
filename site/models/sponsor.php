<?php

use Kirby\Cms\Page;

/**
 * Sponsor page model.
 *
 * Splits the sponsors list into "current" (matching festival year, with logo) and "past" (most-recent first). Templates call methods, not raw SVG.
 */
class SponsorPage extends Page
{
  /**
   * The current festival year, from the site setting. Falls back to the actual
   * calendar year if the setting is empty.
   */
  protected function festivalYear(): int
  {
    return (int) site()->festivalyear()->value() ?: (int) date('Y');
  }

  /**
   * Every sponsor as a flat row, with years parsed once.
   * Each row: ['name', 'url', 'description', 'logo', 'years' => int[], 'maxYear']. Logos sanitised here once.
   */
  protected function sponsorRows(): array
  {
    $rows = [];

    foreach ($this->sponsors()->toStructure() as $s) {
      $years = array_map('intval', $s->years()->split(','));
      $rows[] = [
        'name' => $s->name(),
        'url' => $s->url(),
        'description' => $s->description(),
        'logo' => $this->sponsorLogo($s),
        'years' => $years,
        'maxYear' => $years ? max($years) : 0,
      ];
    }

    return $rows;
  }

  /**
   * Sponsors supporting the current festival year — shown under "Current" with
   * their logo. Shared by the homepage teaser and the sponsor-page roster.
   */
  public function currentSponsors(): array
  {
    $year = $this->festivalYear();

    return array_values(array_filter(
      $this->sponsorRows(),
      fn($r) => in_array($year, $r['years'], true)
    ));
  }

  /**
   * Past sponsors (not tagged with the current festival year), ordered
   * most-recent first. Each row is ['name' => Field, 'url' => Field, …].
   */
  public function pastSponsorsData(): array
  {
    $year = $this->festivalYear();

    $rows = array_values(array_filter(
      $this->sponsorRows(),
      fn($r) => !in_array($year, $r['years'], true)
    ));

    usort($rows, fn($a, $b) => $b['maxYear'] <=> $a['maxYear']);

    return $rows;
  }

  /**
   * Sanitised, theme-aware inline SVG for one sponsor's logo. Second defensive pass after Kirby's Sane\Svg. Returns '' on failure.
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
