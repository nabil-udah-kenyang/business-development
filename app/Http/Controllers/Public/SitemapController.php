<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Preloved\Product as PrelovedProduct;
use App\Models\Seller\Product as SellerProduct;
use App\Models\Seller\Store;

class SitemapController extends Controller
{
    public function index()
    {
        $now = now()->toAtomString();
        $urls = collect([
            ['loc' => route('home'), 'lastmod' => $now, 'changefreq' => 'weekly', 'priority' => '1.0'],
            ['loc' => route('products.index'), 'lastmod' => $now, 'changefreq' => 'daily', 'priority' => '0.9'],
            ['loc' => route('stores.index'), 'lastmod' => $now, 'changefreq' => 'daily', 'priority' => '0.8'],
            ['loc' => route('preloved.index'), 'lastmod' => $now, 'changefreq' => 'daily', 'priority' => '0.9'],
        ]);

        $urls = $urls->merge(
            SellerProduct::where('status', 'active')->get(['slug', 'updated_at'])->map(function (SellerProduct $product) use ($now) {
                return [
                    'loc' => route('products.show', $product->slug),
                    'lastmod' => $product->updated_at?->toAtomString() ?? $now,
                    'changefreq' => 'weekly',
                    'priority' => '0.8',
                ];
            })
        );

        $urls = $urls->merge(
            Store::where('is_active', true)->get(['slug', 'updated_at'])->map(function (Store $store) use ($now) {
                return [
                    'loc' => route('stores.show', $store->slug),
                    'lastmod' => $store->updated_at?->toAtomString() ?? $now,
                    'changefreq' => 'weekly',
                    'priority' => '0.7',
                ];
            })
        );

        $urls = $urls->merge(
            PrelovedProduct::where('status', 'active')->get(['slug', 'updated_at'])->map(function (PrelovedProduct $product) use ($now) {
                return [
                    'loc' => route('preloved.show', $product->slug),
                    'lastmod' => $product->updated_at?->toAtomString() ?? $now,
                    'changefreq' => 'weekly',
                    'priority' => '0.8',
                ];
            })
        );

        return response()
            ->view('public.sitemap', compact('urls'))
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    public function robots()
    {
        return response(
            "User-agent: *\nDisallow:\nSitemap: ".url('/sitemap.xml')."\n",
            200,
            ['Content-Type' => 'text/plain; charset=UTF-8'],
        );
    }
}
