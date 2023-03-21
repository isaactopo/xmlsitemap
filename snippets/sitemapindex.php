<?= '<?xml version="1.0" encoding="utf-8"?>'; ?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <?php foreach (kirby()->languages() as $language): ?>
    <sitemap>
    <loc><?= $language->baseUrl()?>/sitemap<?='_'.$language->code()?>.xml</loc>
    </sitemap>
    <?php endforeach ?>
</sitemapindex>