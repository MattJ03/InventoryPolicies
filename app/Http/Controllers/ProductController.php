<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Policies\ProductPolicy;
use Spatie\Permission\Models\Role;
use App\Models\Product;

class ProductController extends Controller
{
    public function index() {
        if(auth()->user()->hasRole('admin')) {
            $products = Product::all();
        }
        else {
            $products = Product::where('user_id', auth()->id()->get());
        }
        return view('products.index', compact('products'));
    }

    public function create() {
        $this->authorize('create', Product::class);
        return view('products.create');
    }

    public function show($product) {
        $product = Product::findOrFail($product);
        if(!$product) {
            abort(404);
        }
        $this->authorize('view', $product);
        return view('products.show', compact('product'));

    }
}
