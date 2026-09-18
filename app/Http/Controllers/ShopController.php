<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::active()->whereNull('parent_id')
            ->withCount(['products' => fn ($q) => $q->where('durum', true)])
            ->orderBy('sira')->get();

        $query = Product::active()->with('category');

        $activeCat = null;
        if ($request->filled('category')) {
            $activeCat = Category::where('slug', $request->category)->first();
            if ($activeCat) {
                $query->where('category_id', $activeCat->id);
            }
        }

        if ($request->filled('q')) {
            // Türkçe karakter duyarsız + kelime kelime "yakın" arama
            // (gözlük=gozluk, güneş=gunes; ad/marka/sku/açıklama/kategori)
            $fold = function (string $s): string {
                $s = str_replace(
                    ['ı','İ','ş','Ş','ğ','Ğ','ü','Ü','ö','Ö','ç','Ç'],
                    ['i','i','s','s','g','g','u','u','o','o','c','c'],
                    $s
                );
                return mb_strtolower($s, 'UTF-8');
            };
            $norm = function (string $col): string {
                $pairs = [['ı','i'],['İ','i'],['ş','s'],['Ş','s'],['ğ','g'],['Ğ','g'],
                          ['ü','u'],['Ü','u'],['ö','o'],['Ö','o'],['ç','c'],['Ç','c']];
                $expr = $col;
                foreach ($pairs as [$a, $b]) {
                    $expr = "REPLACE($expr,'$a','$b')";
                }
                return "LOWER($expr)";
            };
            $cols = ['products.name', 'products.brand', 'products.sku', 'products.short_desc', 'products.description'];
            $tokens = preg_split('/\s+/', trim($request->q), -1, PREG_SPLIT_NO_EMPTY);

            $query->where(function ($outer) use ($tokens, $fold, $norm, $cols) {
                foreach ($tokens as $tok) {
                    $like = '%' . $fold($tok) . '%';
                    $outer->where(function ($w) use ($like, $norm, $cols) {
                        foreach ($cols as $c) {
                            $w->orWhereRaw($norm($c) . ' LIKE ?', [$like]);
                        }
                        $w->orWhereHas('category', function ($cq) use ($like, $norm) {
                            $cq->whereRaw($norm('categories.name') . ' LIKE ?', [$like]);
                        });
                    });
                }
            });
        }

        match ($request->get('sort')) {
            'price-asc' => $query->orderByRaw('COALESCE(sale_price, price) asc'),
            'price-desc' => $query->orderByRaw('COALESCE(sale_price, price) desc'),
            'newest' => $query->latest(),
            default  => $query->orderBy('sira'),
        };

        $products = $query->paginate(12)->withQueryString();

        return view('shop.index', compact('products', 'categories', 'activeCat'));
    }

    public function show(Product $product)
    {
        abort_unless($product->durum, 404);

        $related = Product::active()
            ->where('category_id', $product->category_id)
            ->where('id', '<>', $product->id)
            ->take(4)->get();

        return view('shop.show', compact('product', 'related'));
    }
}
