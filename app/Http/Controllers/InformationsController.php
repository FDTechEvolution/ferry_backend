<?php

namespace App\Http\Controllers;
use App\Models\Informations;

use Illuminate\Http\Request;

class InformationsController extends Controller
{
    //

    public static function getPosition(){
        return [
            'TERM'=>'Terms & Conditions'
        ];
    }

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() 
    {
        $informations = Informations::orderBy('created_at', 'DESC')->get();
        $positions = $this->getPosition();
        return view('pages.informations.index', 
                    ['informations'=>$informations,'positions'=>$positions]
                );
    }

    public function create(){
        return view('pages.informations.create');
    }

    public function edit(Informations $information){
        return view('pages.informations.edit',['information'=>$information]);
    }


    //Model section
    public function store(Request $request){
        $request->validate([
            'title' => 'required|string',
            'position' => 'required|string',
            'body'=>'required|string'
        ]);

        $data = Informations::create([
            'title' => $request->title,
            'position' => $request->position,
            'body' => $request->body
        ]);
        
        if($data){
            return redirect()->route('information-index')->withSuccess('Information created...');
        }else{
            return redirect()->route('information-create')->withErrors('Failed');
        }
    }

    public function update(Informations $information){
        request()->validate([
            'title' => 'required|string',
            'position' => 'required|string',
            'body'=>'required|string'
        ]);

        $information->title = request()->get('title');
        $information->position = request()->get('position');
        $information->body = request()->get('body');

        $information->save();

        return redirect()->route('information-index')->withSuccess('Information is updated...');
    }

    public function destroy(string $id = null) {
        if(!is_null($id)){
            $information = Informations::find($id);
            $information->delete();
            return redirect()->route('information-index')->withSuccess('Deleted');
        }

        return redirect()->route('information-index');

    }

}