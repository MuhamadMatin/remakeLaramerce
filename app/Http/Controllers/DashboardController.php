<?php
namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
  public function home()
  {
    $categories        = Category::withCount('products')->get();
    $featured_products = Product::with(['category'])->with(['variants.images' => function ($query) {
      $query->where('is_primary', true);
    }])->where('is_featured', 1)->limit(12)->get();
    $newest_products = Product::with(['category'])->with(['variants.images' => function ($query) {
      $query->where('is_primary', true);
    }])->orderBy('created_by', 'DESC')->limit(12)->get();
    $brands = Brand::inRandomOrder()->get();

    return Inertia('index', compact('categories', 'featured_products', 'newest_products', 'brands'));
  }

  public function products(Request $request)
  {
    $categories = Category::withCount('products')->get();
    $brands     = Brand::get();

    $query = Product::with(['category', 'store'])->with(['variants.images' => function ($query) {
      $query->where('is_primary', true);
    }])
    // ->when($request->search, function ($query) use ($request) {
    //   $query->where(function ($q) use ($request) {
    //     $q->where('name', 'like', '%' . $request->search . '%')
    //       ->orWhere('slug', 'like', '%' . $request->search . '%')
    //       ->orWhereHas('variants', function ($q2) use ($request) {
    //         $q2->where('name', 'like', '%' . $request->search . '%')
    //           ->orWhere('slug', 'like', '%' . $request->search . '%');
    //       });
    //   });
    // })
      ->when($request->search, function ($query) use ($request) {
        $query->where('name', 'like', '%' . $request->search . '%')
          ->orWhere('slug', 'like', '%' . $request->search . '%')
          ->orWhereHas('variants', function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%')
              ->orWhere('slug', 'like', '%' . $request->search . '%');
          });
      })
      ->when($request->category, function ($query) use ($request) {
        $query->whereHas('category', function ($query) use ($request) {
          $query->where('slug', $request->category);
        });
      })
      ->when($request->brand, function ($query) use ($request) {
        $query->whereHas('brand', function ($query) use ($request) {
          $query->where('slug', $request->brand);
        });
      })
      ->when($request->sorting, function ($query) use ($request) {
        if ($request->sorting == 'newest') {
          $query->orderBy('created_at', 'DESC');
        } elseif ($request->sorting == 'oldest') {
          $query->orderBy('created_at', 'ASC');
        } elseif ($request->sorting == 'price-asc') {
          $query->withMin('variants', 'price')->orderBy('variants_min_price', 'ASC');
        } elseif ($request->sorting == 'price-desc') {
          $query->withMax('variants', 'price')->orderBy('variants_max_price', 'DESC');
        }
      });

    $products = Inertia::scroll(fn() => $query->paginate(24));

    return Inertia::render('Products/index', compact('categories', 'products', 'brands'));
  }

  public function show(Product $product)
  {
    $product->load(['category', 'brand', 'variants.images', 'store']);
    $related_products = Product::with(['category', 'brand', 'variants.images', 'store'])
      ->where('category_id', $product->category_id)
      ->where('id_product', '!=', $product->id_product)
      ->inRandomOrder()->limit(8)->get();

    return Inertia('Products/slug', compact('product', 'related_products'));
  }

  public function carts(Product $product)
  {
    return Inertia('cart');
  }
}
