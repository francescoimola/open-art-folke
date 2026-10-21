<?php

use Kirby\Cms\Block;
use Kirby\Cms\Blocks;
use Kirby\Cms\Page;
use Kirby\Toolkit\Str;

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

  /** Ids already on the homepage; a Custom section's id avoids them (and each "<id>-title" heading id). */
  private const RESERVED_IDS = ['main', 'drawer', 'content', 'programme', 'about', 'sponsors'];

  private ?Blocks $sections = null;

  /** @var array<string, string>|null Custom section anchor ids, keyed by block id */
  private ?array $customIds = null;

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
   * A section's anchor id: the type for placeholders (#programme, #about, #sponsors). A Custom section takes
   * its heading's slug, suffixed "-2", "-3"… if another id on the page has it, so it stays stable while the heading does.
   */
  public function sectionId(Block $block): string
  {
    if ($block->type() !== 'custom') {
      return $block->type();
    }

    if ($this->customIds === null) {
      $this->customIds = [];
      $taken = [];
      foreach (self::RESERVED_IDS as $id) {
        $taken[$id] = $taken[$id . '-title'] = true;
      }

      foreach ($this->homeSections()->filterBy('type', 'custom') as $custom) {
        /* Footer group headings and Link + hint lines use these prefixes. */
        $base = Str::slug($custom->heading()->value()) ?: 'section';
        if (preg_match('/^(footer|hint)-/', $base)) $base = 'section-' . $base;

        $id = $base;
        for ($n = 2; isset($taken[$id]) || isset($taken[$id . '-title']); $n++) {
          $id = $base . '-' . $n;
        }
        $taken[$id] = $taken[$id . '-title'] = true;
        $this->customIds[$custom->id()] = $id;
      }
    }

    return $this->customIds[$block->id()] ?? 'section-' . $block->id();
  }

  /**
   * Options for the Statement arrow's target (the `arrow_target` select): the first section, the placeholders,
   * then each Custom section that renders, by block id so renaming its heading keeps the choice.
   *
   * @return array<string, string>
   */
  public function arrowTargets(): array
  {
    $targets = [
      'content'   => 'First section',
      'programme' => 'Programme',
      'about'     => 'About',
      'sponsors'  => 'Sponsors',
    ];
    foreach ($this->homeSections()->filterBy('type', 'custom') as $block) {
      if ($block->heading()->isNotEmpty()) $targets[$block->id()] = 'Custom section: ' . $block->heading()->value();
    }
    return $targets;
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
