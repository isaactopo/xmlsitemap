<?php

include __DIR__ . '/src/XMLSiteMap.php';

Kirby::plugin('isaactopo/xmlsitemap', [
    'snippets' => [
        'sitemap' => __DIR__ . '/snippets/sitemap.php'
    ],
    'routes' => [
        [
            'pattern' => 'sitemap.xml',
            'action'  => function() {
                $pages = site()->pages()->index()->listed();

                $addCollection = option('isaactopo.xmlsitemap.addCollection');
                if (is_callable($addCollection)) {
                    $pages = $pages->merge($addCollection());
                }
                // fetch the pages to ignore from the config settings,
                // if nothing is set, we ignore the error page
                $ignore = option('isaactopo.xmlsitemap.ignore');
                $includeImages = option('isaactopo.xmlsitemap.includeImages');
                $content = snippet('sitemap', compact('pages', 'ignore', 'includeImages'), true);
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

