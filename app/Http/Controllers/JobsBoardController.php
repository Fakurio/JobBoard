<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobPost;
use App\Models\Language;

class JobsBoardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = JobPost::with(['user', 'country', 'contract_type', 'level', 'languages'])
            ->get()->sortByDesc("is_featured");


        return view("home", ["posts" => $posts]);
    }

    private function getAllLanguages()
    {
        $languages = Language::all()->toArray();
        return array_map(function ($language) {
            return strtolower($language["name"]);
        }, $languages);
    }

    public function filter(Request $request)
    {
        $request->validate([
            "tags" => "required|array",
            "tags.*" => "required|string"
        ]);

        $languages = $this->getAllLanguages();
        $response = JobPost::with(["languages", "level"])->where(function ($query) use ($request, $languages) {
            foreach ($request->tags as $tag) {
                if (in_array($tag, $languages)) {
                    $query->whereHas("languages", function ($q) use ($tag) {
                        $q->where('name', 'like', "$tag");
                    });
                } else {
                    $query->whereHas("level", function ($q) use ($tag) {
                        $q->where("name", "like", "%$tag%")->orWhere("title", "like", "%$tag%");
                    });
                }
            }
        })->get()->sortByDesc("is_featured");

        return view("home", ["posts" => $response]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}