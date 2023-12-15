<?php

namespace App\Http\Controllers;

use App\Models\Partners;
use Illuminate\Http\Request;
use App\Helpers\ImageHelper;

class PartnerController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $partners = Partners::orderBy('created_at', 'DESC')->get();
       
        return view('pages.partners.index', 
                    ['partners'=>$partners]
                );
    }

    public function create(){
        return view('pages.partners.create');
    }
    public function edit(Partners $partner){
        return view('pages.partners.edit',['partner'=>$partner]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string'
        ]);

        $partner = Partners::create([
            'name'=>$request->name,
            'isactive'=>'Y'
        ]);

        if ($partner) {
            if ($request->hasFile('image_file')) {
                $imageHelper = new ImageHelper();
                $image = $imageHelper->upload($request->image_file, 'partner');

                $partner->image_id = $image->id;
                $partner->save();

            }

            return redirect()->route('partner-index')->withSuccess(sprintf('Create partner "%s"', $request->name));
        }
    }

    public function destroy(string $id = null){
        $partner = Partners::where('id',$id)->with(['routes'])->first();

        //dd($partner);
        if(($partner->routes) != null){
            $partner->isactive = 'N';
            return redirect()->route('partner-index')->withSuccess(sprintf('Disable "%s", other route(s) used.', $partner->name));
        }else{
            if (isset($partner->image->path)) {
                $imageHelper = new ImageHelper();
                $imageHelper->delete($partner->image_id);
            }

            $partner->forceDelete();
            return redirect()->route('partner-index')->withSuccess('Partner deleted.');
        }
    }
}
