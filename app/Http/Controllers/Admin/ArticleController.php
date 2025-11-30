<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    // 1. Tampilkan Daftar Artikel
    public function index()
    {
        $articles = Article::with('author')->latest()->paginate(10);
        return view('admin.articles.index', compact('articles'));
    }

    // 2. Form Tambah
    public function create()
    {
        return view('admin.articles.create');
    }

    // 3. Simpan Artikel Baru
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'thumbnail' => 'nullable|image|max:2048', // Max 2MB
            'status' => 'required|in:published,draft'
        ]);

        $data = $request->all();
        
        // Buat Slug Otomatis (Judul Artikel -> judul-artikel)
        $data['slug'] = Str::slug($request->title);
        $data['user_id'] = Auth::id(); // Ambil ID Admin yang login

        // Upload Gambar
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('articles', 'public');
        }

        Article::create($data);

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil diterbitkan!');
    }

    // 4. Form Edit
    public function edit(Article $article)
    {
        return view('admin.articles.edit', compact('article'));
    }

    // 5. Update Artikel
    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'thumbnail' => 'nullable|image|max:2048',
            'status' => 'required|in:published,draft'
        ]);

        $data = $request->all();
        
        // Update Slug jika judul berubah
        if($request->title != $article->title) {
            $data['slug'] = Str::slug($request->title);
        }

        // Cek Ganti Gambar
        if ($request->hasFile('thumbnail')) {
            if ($article->thumbnail) Storage::delete('public/' . $article->thumbnail);
            $data['thumbnail'] = $request->file('thumbnail')->store('articles', 'public');
        }

        $article->update($data);

        return redirect()->route('admin.articles.index')->with('success', 'Artikel diperbarui.');
    }

    // 6. Hapus Artikel
    public function destroy(Article $article)
    {
        if ($article->thumbnail) Storage::delete('public/' . $article->thumbnail);
        $article->delete();
        
        return redirect()->back()->with('success', 'Artikel dihapus.');
    }
}