<?php

namespace App\Http\Controllers;

use App\Models\Product;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Policies\ProductPolicy;
use Spatie\Permission\Models\Role;

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

    public function store(Request $request) {
        $this->authorize('create', Product::class);
        $validatedData = $request->validate([
           'name' => 'required|max:100',
           'quantity' => 'required|numeric|min:1|max:1000',
            'price' => 'required|numeric|min:1|max:1000',
            'category_id' => 'required|exists:categories,id',
        ]);
        $validatedData['user_id'] = auth()->id();
        Product::create($validatedData);
        return redirect()->route('products.index');
    }

    public function edit(Product $product) {
        $this->authorize('edit', $product);

    }
}
