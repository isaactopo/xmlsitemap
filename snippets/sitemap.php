<?= '<?xml version="1.0" encoding="utf-8"?>'; ?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">
    <?php
    foreach ($pages as $p): ?>
        <?php if (in_array($p->uri(), $ignore)) continue ?>
        <?php
        $locales = [];
        foreach (kirby()->languages() as $language){
            $locales[] = [
                'hreflang' => $language->code(),
                'href' => $p->urlForLanguage($language->code())
            ];
        }
        $last_modified = $p->modified('c', 'date');
        ?>
         <url>
            <loc><?= $p->urlForLanguage($langcode) ?></loc>
            <?php
            if(kirby()->languages()->count() > 1):
                foreach($locales as $locale): ?>
            <xhtml:link rel="alternate" hreflang="<?= $locale['hreflang'] ?>" href="<?= $locale['href'] ?>"/>
            <?php endforeach; endif ?>

            <lastmod><?= $p->modified('c', 'date') ?></lastmod>
            <changefreq><?= getChangeFreq($last_modified) ?></changefreq>
            <priority><?php
            if(!$p->sitemapPriority()->exists()){
                echo ($p->isHomePage()) ? 1 : number_format(0.5 / $p->depth(), 1);
            } else {
                echo $p->sitemapPriority()->toFloat();
            }
            ?></priority>

            <?php if ($includeImages && $p->hasImages()) : ?>
                <?php foreach ($p->images() as $image) : ?>
            <image:image xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
                <image:loc><?= html($image->url()) ?></image:loc>

                <?php if ($image->caption()->isNotEmpty()) : ?>
                <image:caption><![CDATA[<?= $image->caption() ?>]]></image:caption>
                <?php elseif ($image->alt()->isNotEmpty()) : ?>
                <image:caption><![CDATA[<?= $image->alt() ?>]]></image:caption>
                <?php endif ?>
            </image:image>
                <?php endforeach ?>
            <?php endif ?>
        </url>
    <?php endforeach ?>
</urlset>