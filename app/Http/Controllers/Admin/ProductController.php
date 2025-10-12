<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.products.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
        ]);

        Product::create($data);
        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'El producto se ha creado con éxito.'
        ]);
        return redirect()->route('admin.products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $data_edit = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product->update($data_edit);
        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'El producto se ha actualizado con éxito.'
        ]);
        return redirect()->route('admin.products.index', $product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if($product->inventories()->exists()){
            session()->flash('swal', [
                'icon' => 'error',
                'title' => '¡Ups!',
                'text' => 'No se puede eliminar el producto porque tiene inventario asociado.'
            ]);
            return redirect()->route('admin.products.index');
        }

        if ($product->purchaseOrders()->exists() || $product->quotes()->exists()) {
            session()->flash('swal', [
                'icon' => 'error',
                'title' => '¡Ups!',
                'text' => 'No se puede eliminar el producto porque tiene órdenes de compra o cotizaciones asociadas.'
            ]);
            return redirect()->route('admin.products.index');
        }
        
        $product->delete();
        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'El producto se ha eliminado con éxito.'
        ]);
        return redirect()->route('admin.products.index');
    }

    public function dropzone(Request $request, Product $product)
    {
        $image =$product->images()->create([
            'path' => Storage::put('/images', $request->file('file')),
            'size' => $request->file('file')->getSize()
        ]);

        return response()->json([
            'id' => $image->id,
            'path' => $image->path
        ]);
    }
}
