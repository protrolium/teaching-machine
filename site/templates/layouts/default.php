<?= $rockfrontend->renderIf("sections/default-page.latte", "template=default-page") ?>
<?= $rockfrontend->renderIf("sections/tag.latte", "template=tag") ?>
<?= $rockfrontend->renderIf("sections/zones.latte", "name=zones") ?>
<?= $rockfrontend->renderIf("sections/zone.latte", "name=cinema|events|print|music|web|installation|virtual-reality|mixtape") ?>
<?= $rockfrontend->renderIf("sections/about.latte", "name=about") ?>