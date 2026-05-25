<?php
if (!isset($pageJs)) {
  $pageJs = vite()->js("templates/{$page->template()}.js", ['defer' => false], try: true);
}
?>
<?= $pageJs ?>
</body>
</html>
