<?php

use Kirby\Cms\Page;

/**
 * Home page model.
 *
 * Holds the countdown maths so templates and snippets only call methods and
 * never compute dates inline. All comparisons run at day granularity (dates
 * normalised to midnight) so the count is stable through the day and free of
 * hour/timezone off-by-one.
 */
class HomePage extends Page
{
  private const DEFAULT_START = '2026-01-01';
  private const DEFAULT_END = '2026-10-09';
  private const TOTAL_BLOCKS = 16;

  public function countdownStartDate(): DateTimeImmutable
  {
    return $this->countdownDate('countdownstart', self::DEFAULT_START);
  }

  public function countdownEndDate(): DateTimeImmutable
  {
    return $this->countdownDate('countdownend', self::DEFAULT_END);
  }

  /** Whole days from today to the end date, never negative. */
  public function daysRemaining(): int
  {
    return max(0, $this->daysBetween($this->today(), $this->countdownEndDate()));
  }

  /** Share of the window still remaining, clamped to 0–1. */
  public function countdownFraction(): float
  {
    $total = $this->daysBetween($this->countdownStartDate(), $this->countdownEndDate());

    if ($total <= 0) {
      return 0.0;
    }

    $remaining = $this->daysBetween($this->today(), $this->countdownEndDate());

    return max(0.0, min(1.0, $remaining / $total));
  }

  /** Total number of slices in the banner (illustrative, fixed). */
  public function countdownTotalBlocks(): int
  {
    return self::TOTAL_BLOCKS;
  }

  /** Number of revealed (image) slices = remaining fraction, nearest block. */
  public function countdownFilled(): int
  {
    $filled = (int) round($this->countdownFraction() * self::TOTAL_BLOCKS);

    return max(0, min(self::TOTAL_BLOCKS, $filled));
  }

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

  private function countdownDate(string $field, string $fallback): DateTimeImmutable
  {
    $value = $this->content()->get($field);
    $iso = $value->isNotEmpty() ? $value->toDate('Y-m-d') : $fallback;

    return new DateTimeImmutable($iso . ' 00:00:00');
  }

  private function today(): DateTimeImmutable
  {
    return new DateTimeImmutable('today');
  }

  private function daysBetween(DateTimeImmutable $from, DateTimeImmutable $to): int
  {
    return (int) $from->diff($to)->format('%r%a');
  }
}
