<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::with('author')->where('status', 'published');

        // Fitur Pencarian
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Ambil data (Terbaru di atas)
        $articles = $query->latest()->get();
        
        // Ambil 1 berita utama (paling baru)
        $featured = $articles->first();
        
        // Sisa berita lainnya
        $others = $articles->skip(1);

        return view('member.articles.index', compact('articles', 'featured', 'others'));
    }

    public function show($slug)
    {
        $article = Article::where('slug', $slug)->where('status', 'published')->firstOrFail();
        
        // Rekomendasi berita lain (kecuali yg sedang dibuka)
        $related = Article::where('status', 'published')
                    ->where('id', '!=', $article->id)
                    ->latest()
                    ->take(3)
                    ->get();

        return view('member.articles.show', compact('article', 'related'));
    }
}