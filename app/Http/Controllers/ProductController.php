<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Container\Attributes\Log;
use Illuminate\Container\Attributes\Storage;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(6); // Ambil semua produk
        return view('product.index', compact('products'));
    }

    public function create()
    {
        return view('product.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'harga' => 'required|numeric',
            'foto' => 'required|image|mimes:jpeg,jpg,png'
        ]);

        if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
            $foto = $request->file('foto');
            $fileName = $foto->hashName();

            // Pindahkan file ke folder public/images
            $foto->move(public_path('images'), $fileName);

            // Simpan data ke database
            Product::create([
                'nama' => $request->nama,
                'harga' => str_replace(".","", $request->harga),
                'deskripsi' => $request->deskripsi,
                'foto' => $fileName
            ]);

            return redirect()->route('product.index')->with('success', 'Product berhasil ditambahkan');
        } else {
            // Log error jika file tidak valid
            
            return redirect()->back()->withErrors('File tidak valid');
        }
    }

    public function edit(Product $product)
    {
        return view('product.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required',
            'harga' => 'required|numeric',
        ]);

        // Update data produk
        $product->nama = $request->nama;
        $product->harga = $request->harga;
        $product->deskripsi = $request->deskripsi;

        // Cek apakah ada file foto baru yang diunggah
        if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
            // Hapus foto lama jika ada
            if ($product->foto && file_exists(public_path('images/' . $product->foto))) {
                unlink(public_path('images/' . $product->foto));
            }

            // Simpan foto baru
            $foto = $request->file('foto');
            $fileName = $foto->hashName();
            $foto->move(public_path('images'), $fileName);

            // Update nama file di database
            $product->foto = $fileName;
        }

        // Simpan perubahan ke database
        $product->save();

        return redirect()->route('product.index')->with('success', 'Product berhasil diperbarui');
    }

}
