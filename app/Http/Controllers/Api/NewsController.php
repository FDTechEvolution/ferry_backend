<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\News;

class NewsController extends Controller
{
    public function getNews() {
        $news = News::where('isactive', 'Y')->orderBy('created_at', 'DESC')->get();

        return response()->json(['data' => $news]);
    }

    public function getNewByView() {
        $news = News::where('isactive', 'Y')->select(['id', 'title', 'slug', 'created_at'])->orderBy('view', 'DESC')->limit(10)->get();

        return response()->json(['data' => $news], 200);
    }

    public function getNewsById(string $id = null) {
        $news = News::find($id);
        if(isset($news)) {
            if($news->isactive == 'Y') {
                $news->view = $news->view +1;
                $news->save();

                return response()->json(['data' => $news], 200);
            }
        }

        return response()->json(['data' => false], 200);
    }

    public function getNewsBySlug(string $slug = null) {
        $news = News::where('slug', $slug)->where('isactive', 'Y')->first();
        if(isset($news)) {
            $news->view = $news->view +1;
            $news->save();

            return response()->json(['data' => $news], 200);
        }

        return response()->json(['data' => false], 200);
    }
}
