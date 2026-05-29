<?php
if (!isset($pageJs)) {
  $pageJs = vite()->js("templates/{$page->template()}.js", ['defer' => false], try: true);
}
?>
  </main>
<?= $pageJs ?>
</body>
</html>
