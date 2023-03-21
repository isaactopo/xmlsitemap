<?php

include __DIR__ . '/src/XMLSiteMap.php';

Kirby::plugin('isaactopo/xmlsitemap', [
    'snippets' => [
        'sitemap' => __DIR__ . '/snippets/sitemap.php',
        'sitemapindex' => __DIR__ . '/snippets/sitemapindex.php'
    ],
    'routes' => [
        [
            'pattern' => 'sitemap(:all).xml',
            'action'  => function($lang) {
                $pages = site()->pages()->index()->listed();

                $addCollection = option('isaactopo.xmlsitemap.addCollection');
                if (is_callable($addCollection)) {
                    $pages = $pages->merge($addCollection());
                }
                // fetch the pages to ignore from the config settings,
                // if nothing is set, we ignore the error page
                $ignore = option('isaactopo.xmlsitemap.ignore');
                $includeImages = option('isaactopo.xmlsitemap.includeImages');

                if(kirby()->languages()->count() > 1){
                    if($lang){
                        $langcode = str_replace('_', '', $lang);
                        $content = snippet('sitemap', compact('pages', 'ignore', 'includeImages', 'langcode'), true);
                    } else {
                        $content = snippet('sitemapindex', compact('pages'), true);
                    }
                } else {
                    $langcode = '';
                    $content = snippet('sitemap', compact('pages', 'ignore', 'includeImages', 'langcode'), true);
                }
                // return response with correct header type
                return new Kirby\Cms\Response($content, 'application/xml');
            }
        ],
        [
            'pattern' => 'sitemap',
            'action'  => function() {
                return go('sitemap.xml');
            }
        ],
    ],
    'options' => [
        'addCollection' => null,
        'ignore' => [],
    ],
]);
