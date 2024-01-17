<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Section;

class SectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = Section::orderBy('sort', 'ASC')->get();

        return view('pages.sections.index', ['sections' => $sections]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sections = Section::orderBy('sort', 'ASC')->get();

        return view('pages.sections.create', ['sections' => $sections]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        if ($this->checkSectionName($request->name)) {
            $section = Section::create(['name' => $request->name]);
            if ($section)
                return redirect()->route('section.index')->withSuccess('Section created...');
            else
                return redirect()->route('section.create')->withFail('Something is wrong. Please try again.');
        }
        return redirect()->route('create-section')->withFail('Section name is exist.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        if ($this->checkSectionName($request->name, $request->section_id)) {
            $section = Section::find($request->section_id);
            $oldSort = $section->sort;

            if (isset($section)) {
                $section->name = $request->name;
                $section->sort = $request->sort;

                if ($section->save()) {
                    if ($oldSort != $request->sort) {
                        $maxSeq = $this->getMaxSortBySection(($request->sort > $oldSort ? 'ASC' : 'DESC'));
                    }

                    return redirect()->route('section.index')->withSuccess('Section created...');
                } else {
                    return redirect()->route('section.index')->withFail('Something is wrong. Please try again.');
                }
            }
            return redirect()->route('section.index')->withFail('Section record not exist. Please check again.');
        }
        return redirect()->route('section.index')->withFail('Section name is exist.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //dd($id);
        $section = Section::find($id);
       
        //dd(sizeof($section->stations));

        if (sizeof($section->stations)>0) {
            $section->isactive = 'N';
            $section->save();
            return redirect()->route('section.index')->withSuccess('this section has any stations, set to Inactive.');
        }else{
            $section->delete();
        }
        return redirect()->route('section.index')->withSuccess('');
    }

    private function checkSectionName(string $name = null, string $section_id = null)
    {
        $section = Section::where('name', $name)->where('id', '!=', $section_id)->where('isactive', 'Y')->first();
        if (isset($section))
            return false;
        return true;
    }

    private function getMaxSortBySection($sort = 'DESC')
    {
        $sections = Section::orderBy('sort', 'ASC')
            ->orderBy('updated_at', $sort)
            ->get();
        //dd($sections);

        foreach ($sections as $index => $section) {
            $section->sort = ($index + 1);
            $section->save();
        }

        return sizeof($sections);
    }
}
