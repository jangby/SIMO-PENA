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
    /**
     * Helper: Cek Hak Akses Artikel
     */
    private function checkAccess(Article $article)
    {
        $user = Auth::user();
        // Jika bukan PAC, pastikan penulis artikel berasal dari organisasi yang sama
        if ($user->organization_id != 1) {
            if ($article->author->organization_id != $user->organization_id) {
                abort(403, 'Anda tidak berhak mengedit/menghapus artikel dari organisasi lain.');
            }
        }
    }

    public function index()
    {
        $user = Auth::user();
        $isPac = $user->organization_id == 1;

        $query = Article::with('author')->latest();

        // --- FILTER ARTIKEL ---
        if (!$isPac) {
            // Hanya tampilkan artikel yang penulisnya satu organisasi dengan admin login
            $query->whereHas('author', function($q) use ($user) {
                $q->where('organization_id', $user->organization_id);
            });
        }

        $articles = $query->paginate(10);
        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        return view('admin.articles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'thumbnail' => 'nullable|image|max:2048', 
            'status' => 'required|in:published,draft'
        ]);

        $data = $request->all();
        
        $data['slug'] = Str::slug($request->title);
        $data['user_id'] = Auth::id(); // Otomatis terikat ke User yang login

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('articles', 'public');
        }

        Article::create($data);

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil diterbitkan!');
    }

    public function edit(Article $article)
    {
        $this->checkAccess($article);
        return view('admin.articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $this->checkAccess($article);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'thumbnail' => 'nullable|image|max:2048',
            'status' => 'required|in:published,draft'
        ]);

        $data = $request->all();
        
        if($request->title != $article->title) {
            $data['slug'] = Str::slug($request->title);
        }

        if ($request->hasFile('thumbnail')) {
            if ($article->thumbnail) Storage::delete('public/' . $article->thumbnail);
            $data['thumbnail'] = $request->file('thumbnail')->store('articles', 'public');
        }

        $article->update($data);

        return redirect()->route('admin.articles.index')->with('success', 'Artikel diperbarui.');
    }

    public function destroy(Article $article)
    {
        $this->checkAccess($article);

        if ($article->thumbnail) Storage::delete('public/' . $article->thumbnail);
        $article->delete();
        
        return redirect()->back()->with('success', 'Artikel dihapus.');
    }
}