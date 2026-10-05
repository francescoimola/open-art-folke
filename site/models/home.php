<?php

use Kirby\Cms\Page;
use Kirby\Cms\Structure;

/**
 * Home page model.
 *
 * Holds countdown maths so templates only call methods. Day-granularity comparisons (dates normalised to midnight) avoid hour/timezone off-by-one.
 * All dates use UK time (GMT/BST), so days roll over at Folkestone midnight whatever the server's timezone.
 */
class HomePage extends Page
{
  private const DEFAULT_START = '2026-01-01';
  private const DEFAULT_END = '2026-10-09';
  private const DEFAULT_FESTIVAL_END = '2026-10-11';
  private const TOTAL_BLOCKS = 16;
  private const TIMEZONE = 'Europe/London';
  /** Middle sections in default order, each with its default colour (a .theme-* suffix). */
  private const SECTIONS = [
    'programme' => 'crimson',
    'countdown' => 'blush',
    'intro' => 'brand',
    'festival' => 'paper',
    'sponsors' => 'blush',
  ];
  private const THEMES = ['brand', 'crimson', 'blush', 'paper', 'ink'];

  public function countdownStartDate(): DateTimeImmutable
  {
    return $this->countdownDate('countdownstart', self::DEFAULT_START);
  }

  public function countdownEndDate(): DateTimeImmutable
  {
    return $this->countdownDate('countdownend', self::DEFAULT_END);
  }

  /** Last day of the festival; the countdown section switches to its "you missed it" copy the day after. */
  public function festivalEndDate(): DateTimeImmutable
  {
    return $this->countdownDate('festivalend', self::DEFAULT_FESTIVAL_END);
  }

  /** Opening day — the same date the countdown runs down to. */
  public function festivalStartDate(): DateTimeImmutable
  {
    return $this->countdownEndDate();
  }

  /** Festival year as shown in copy, e.g. "2026". */
  public function festivalYear(): string
  {
    return $this->festivalEndDate()->format('Y');
  }

  /** Human date range, e.g. "9–11 October 2026" or "30 September – 2 October 2026". */
  public function festivalDateRange(): string
  {
    $start = $this->festivalStartDate();
    $end = $this->festivalEndDate();

    if ($start->format('Y-m') === $end->format('Y-m')) {
      return $start == $end
        ? $end->format('j F Y')
        : $start->format('j') . '–' . $end->format('j F Y');
    }

    $startFormat = $start->format('Y') === $end->format('Y') ? 'j F' : 'j F Y';

    return $start->format($startFormat) . ' – ' . $end->format('j F Y');
  }

  /**
   * Up to two "The Festival" CTAs. Until an editor first saves the field,
   * falls back to the blueprint defaults so buttons don't vanish on deploy.
   */
  public function festivalButtons(): Structure
  {
    // Read via content(): PHP method names are case-insensitive, so $this->festivalbuttons() would recurse into this method.
    $buttons = $this->content()->has('festivalbuttons')
      ? $this->content()->get('festivalbuttons')->toStructure()
      : Structure::factory($this->blueprint()->field('festivalbuttons')['default'] ?? [], ['parent' => $this]);

    return $buttons->limit(2);
  }

  /**
   * Middle homepage sections in Panel order; each key maps to site/snippets/home/<key>.php.
   * Unsaved field falls back to the default order; unknown or duplicate keys are dropped.
   */
  public function homeSections(): array
  {
    $keys = array_keys(self::SECTIONS);

    if (!$this->content()->has('sections')) {
      return $keys;
    }

    return array_values(array_unique(array_intersect($this->content()->get('sections')->split(), $keys)));
  }

  /**
   * Theme class for a middle section, from its "<key>theme" Panel field (e.g. "theme-crimson").
   * Unsaved or unknown values fall back to the section's default colour.
   */
  public function sectionTheme(string $section): string
  {
    $theme = $this->content()->get($section . 'theme')->value();

    if (!in_array($theme, self::THEMES, true)) {
      $theme = self::SECTIONS[$section] ?? 'paper';
    }

    return 'theme-' . $theme;
  }

  /** Panel toggle wins; "auto" shows the message from the day after the festival ends. */
  public function festivalIsOver(): bool
  {
    return match ($this->countdownmode()->value()) {
      'countdown' => false,
      'over' => true,
      default => $this->today() > $this->festivalEndDate(),
    };
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

  /** Number of revealed (image) slices = elapsed fraction, nearest block. */
  public function countdownFilled(): int
  {
    $filled = (int) round((1.0 - $this->countdownFraction()) * self::TOTAL_BLOCKS);

    return max(0, min(self::TOTAL_BLOCKS, $filled));
  }

  private function countdownDate(string $field, string $fallback): DateTimeImmutable
  {
    $value = $this->content()->get($field);
    $iso = $value->isNotEmpty() ? $value->toDate('Y-m-d') : $fallback;

    return new DateTimeImmutable($iso . ' 00:00:00', new DateTimeZone(self::TIMEZONE));
  }

  private function today(): DateTimeImmutable
  {
    return new DateTimeImmutable('today', new DateTimeZone(self::TIMEZONE));
  }

  private function daysBetween(DateTimeImmutable $from, DateTimeImmutable $to): int
  {
    return (int) $from->diff($to)->format('%r%a');
  }
}
