<?php

use Kirby\Cms\Page;

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
