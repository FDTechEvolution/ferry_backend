<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reviews;

class ReviewsController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() 
    {
        $reviews = Reviews::orderBy('seq', 'ASC')->get();
        return view('pages.reviews.index', 
                    ['reviews'=>$reviews]
                );
    }

    public function create(){
        return view('pages.reviews.create');
    }

    public function edit(){

    }


    //Model section
    public function store(Request $request){
        $request->validate([
            'title' => 'required|string',
            'reviewname' => 'required|string',
            'body'=>'required|string'
        ]);

        $newSeq = Reviews::max('seq')+1;
        //dd($newSeq);
        $data = Reviews::create([
            'title' => $request->title,
            'reviewname' => $request->reviewname,
            'body' => $request->body,
            'rating' => $request->rating,
            'seq'=>$newSeq
        ]);
        
        if($data){
            return redirect()->route('review-index')->withSuccess('Review created...');
        }else{
            return redirect()->route('review-create')->withErrors('Failed');
        }
    }

    public function update($id = null){

    }

    public function destroy(string $id = null) {
        if(!is_null($id)){
            $review = Reviews::find($id);
            $review->delete();
            return redirect()->route('review-index')->withSuccess('Deleted');
        }

        return redirect()->route('review-index');

    
    }
}
