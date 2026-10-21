<?php
/**
 * Benefits table — what each sponsorship Tier gets (docs/components/benefits-table.md).
 * A real <table> with explicit ARIA roles: the Stacked layout turns rows into grids, which drops table semantics in some browsers.
 * Split once the table is at least 480px wide (benefit half the width, three tiers share the rest); Stacked below
 * (each benefit on its own line, its tiers beneath; the "Benefit" header is visually hidden).
 * A blank tier = "Not included"; Yes/y/✓/true = a Check; anything else is shown as text.
 *
 * Usage: snippet('benefits-table', ['rows' => $page->benefits()->toStructure()])
 *
 * @var \Kirby\Cms\Structure|iterable $rows   items with benefit, gold, silver, bronze fields; empty renders nothing
 * @var string                        $class  extra classes on the wrapper
 */
$rows = $rows ?? [];
if (count($rows) === 0) return;

$tiers = ['gold' => 'Gold', 'silver' => 'Silver', 'bronze' => 'Bronze'];

/* One tier cell: blank → hidden "Not included"; an affirmative value → a Check; anything else → the text. */
$cell = function ($field): string {
  $value = trim((string)$field);

  if ($value === '') {
    return '<span class="visually-hidden">Not included</span>';
  }

  if (in_array(mb_strtolower($value), ['yes', 'y', '✓', '✔', 'true'], true)) {
    return snippet('icon', ['glyph' => 'check', 'class' => 'benefits-table__tick'], return: true)
      . '<span class="visually-hidden">Included</span>';
  }

  return esc($value);
};
?>
<div class="<?= esc(trim('benefits-table ' . ($class ?? '')), 'attr') ?>">
  <table class="benefits-table__table" role="table">
    <thead role="rowgroup">
      <tr class="benefits-table__row" role="row">
        <th class="benefits-table__benefit" scope="col" role="columnheader">Benefit</th>
        <?php foreach ($tiers as $tier): ?>
          <th scope="col" role="columnheader"><?= esc($tier) ?></th>
        <?php endforeach ?>
      </tr>
    </thead>
    <tbody role="rowgroup">
      <?php foreach ($rows as $row): ?>
        <tr class="benefits-table__row" role="row">
          <th class="benefits-table__benefit" scope="row" role="rowheader"><?= esc((string)$row->benefit()) ?></th>
          <?php foreach (array_keys($tiers) as $key): ?>
            <td role="cell"><?= $cell($row->$key()) ?></td>
          <?php endforeach ?>
        </tr>
      <?php endforeach ?>
    </tbody>
  </table>
</div>
