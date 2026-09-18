<?php

namespace App\Http\Controllers;

class LegalController extends Controller
{
    public const PAGES = [
        'distance-sales-agreement' => ['Distance Sales Agreement', 'legal.mesafeli-satis'],
        'pre-information'           => ['Pre-Information Form', 'legal.on-bilgilendirme'],
        'returns-delivery'         => ['Returns & Delivery Terms', 'legal.iade-teslimat'],
        'data-protection'          => ['Data Protection Notice', 'legal.kvkk'],
        'privacy-policy'           => ['Privacy Policy', 'legal.gizlilik'],
        'cookie-policy'            => ['Cookie Policy', 'legal.cerez'],
    ];

    public function show(string $slug)
    {
        abort_unless(isset(self::PAGES[$slug]), 404);

        [$title, $view] = self::PAGES[$slug];

        return view('pages.legal.wrapper', [
            'pageTitle' => $title,
            'bodyView'  => $view,
        ]);
    }
}
