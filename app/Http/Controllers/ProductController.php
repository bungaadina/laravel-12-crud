<?php

namespace App\Http\Controllers;

// Import Model Product
use App\Models\Product; 

// Import Return Type View
use Illuminate\View\View;

// Import Http Request (Perbaikan Namespace)
use Illuminate\Http\Request;

// Import Return Type RedirectResponse (Perbaikan Namespace)
use Illuminate\Http\RedirectResponse;

// Import Facades Storage untuk Manajemen File
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * index (Menampilkan semua data dengan Pagination & Fitur Cari)
     *
     * @param  Request $request
     * @return View
     */
    public function index(Request $request) : View
    {
        // Tangkap kata kunci pencarian dari input user bernama 'search'
        $keyword = $request->get('search');

        // Jalankan query: jika ada keyword cari yang mirip judul, jika tidak ambil terbaru
        $products = Product::latest()
            ->when($keyword, function ($query, $keyword) {
                return $query->where('title', 'like', '%' . $keyword . '%');
            })
            ->paginate(5); // Menampilkan 5 data per halaman

        // Render view dengan mengirim data produk dan keyword
        return view('products.index', compact('products', 'keyword'));
    }

    /**
     * create (Menampilkan halaman form tambah produk)
     *
     * @return View
     */
    public function create(): View
    {
        return view('products.create');
    }

    /**
     * store (Memproses penyimpanan data produk baru)
     *
     * @param  Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi Form
        $request->validate([
            'image'       => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'title'       => 'required|min:5',
            'description' => 'required|min:10',
            'price'       => 'required|numeric',
            'stock'       => 'required|numeric'
        ]);

        // Upload Gambar Baru ke Storage Disk 'public'
        $image = $request->file('image');
        $image->storeAs('products', $image->hashName(), 'public');

        // Create Product ke Database
        Product::create([
            'image'       => $image->hashName(),
            'title'       => $request->title,
            'description' => $request->description,
            'price'       => $request->price,
            'stock'       => $request->stock
        ]);

        // Redirect ke Index dengan Pesan Sukses
        return redirect()->route('products.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }
    
    /**
     * show (Menampilkan detail lengkap satu data produk)
     *
     * @param  string $id
     * @return View
     */
    public function show(string $id): View
    {
        // Ambil data produk berdasarkan ID, jika tidak ada otomatis 404
        $product = Product::findOrFail($id);

        // Kirim data ke view detail
        return view('products.show', compact('product'));
    }
    
    /**
     * edit (Menampilkan form edit data berdasarkan ID)
     *
     * @param  string $id
     * @return View
     */
    public function edit(string $id): View
    {
        // Ambil data produk berdasarkan ID
        $product = Product::findOrFail($id);

        // Render view form edit
        return view('products.edit', compact('product'));
    }
        
    /**
     * update (Memproses update data produk)
     *
     * @param  Request $request
     * @param  string $id
     * @return RedirectResponse
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        // Validasi Form
        $request->validate([
            'image'       => 'image|mimes:jpeg,jpg,png|max:2048',
            'title'       => 'required|min:5',
            'description' => 'required|min:10',
            'price'       => 'required|numeric',
            'stock'       => 'required|numeric'
        ]);

        // Ambil data produk lama
        $product = Product::findOrFail($id);

        // Cek apakah ada file gambar baru yang di-upload?
        if ($request->hasFile('image')) {

            // Upload gambar baru ke disk public
            $image = $request->file('image');
            $image->storeAs('products', $image->hashName(), 'public');

            // Hapus gambar lama dari storage agar hemat memori
            Storage::disk('public')->delete('products/' . $product->image);

            // Update data dengan gambar baru
            $product->update([
                'image'       => $image->hashName(),
                'title'       => $request->title,
                'description' => $request->description,
                'price'       => $request->price,
                'stock'       => $request->stock
            ]);

        } else {

            // Update data tanpa mengganti gambar lama
            $product->update([
                'title'       => $request->title,
                'description' => $request->description,
                'price'       => $request->price,
                'stock'       => $request->stock
            ]);
        }

        // Redirect ke Index dengan Pesan Sukses
        return redirect()->route('products.index')->with(['success' => 'Data Berhasil Diubah!']);
    }
    
    /**
     * destroy (Menghapus data produk dan gambarnya)
     *
     * @param  string $id
     * @return RedirectResponse
     */
    public function destroy(string $id): RedirectResponse
    {
        // Ambil data produk berdasarkan ID
        $product = Product::findOrFail($id);

        // Hapus file gambar asli dari disk public
        Storage::disk('public')->delete('products/' . $product->image);

        // Hapus baris data dari database
        $product->delete();

        // Redirect ke Index dengan Pesan Sukses
        return redirect()->route('products.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}