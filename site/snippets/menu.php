<nav>
  <ul>
    <?php foreach($site->children()->listed() as $child): ?>
    <li>
      <a
        href="<?= $child->url() ?>"
        <?= e($child->isActive(), 'aria-current="page"', '') ?>
      ><?= $child->title() ?></a>
    </li>
    <?php endforeach ?>
  </ul>
</nav>
