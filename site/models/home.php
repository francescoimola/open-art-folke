<?php

use Kirby\Cms\Block;
use Kirby\Cms\Blocks;
use Kirby\Cms\Page;

/**
 * Home page model.
 *
 * Homepage sections are the "Homepage sections" Blocks field, `sectionblocks` (ADR-0007): one block per section,
 * rendered by site/snippets/blocks/<type>.php. Placeholders (programme, about, sponsors) carry no content,
 * only position and visibility; their copy lives in the page's own fields.
 */
class HomePage extends Page
{
  /** Block types the homepage renders, each with the most instances that render; later extras are dropped. */
  public const SECTION_LIMITS = [
    'programme' => 1,
    'about'     => 1,
    'sponsors'  => 1,
    'custom'    => 2,
  ];

  /** Order used while the field is empty (live, right after the switch-over). */
  private const DEFAULT_SECTIONS = ['programme', 'about', 'sponsors'];

  private ?Blocks $sections = null;

  /**
   * Visible Homepage sections in Panel order, capped per type (SECTION_LIMITS).
   * An empty field (or one Kirby can't parse) falls back to Programme → About → Sponsors.
   */
  public function homeSections(): Blocks
  {
    if ($this->sections !== null) {
      return $this->sections;
    }

    $field = $this->content()->get('sectionblocks');
    $blocks = null;

    if (Blocks::parse($field->value()) !== []) {
      try {
        $blocks = $field->toBlocks();
      } catch (Throwable) {
        $blocks = null;
      }
    }

    $blocks ??= Blocks::factory(
      array_map(fn (string $type) => ['type' => $type, 'id' => 'default-' . $type, 'content' => []], self::DEFAULT_SECTIONS),
      ['parent' => $this]
    );

    $counts = [];
    $this->sections = $blocks->filter(function (Block $block) use (&$counts): bool {
      $type = $block->type();
      $counts[$type] = ($counts[$type] ?? 0) + 1;
      return $counts[$type] <= (self::SECTION_LIMITS[$type] ?? 0);
    });

    return $this->sections;
  }

  /**
   * Whether the Programme section is on the homepage. The Nav list and the Footer's visitor item hide
   * their programme links when it isn't, so no link points to a missing section.
   */
  public function showsProgramme(): bool
  {
    return $this->homeSections()->filterBy('type', 'programme')->isNotEmpty();
  }
}
