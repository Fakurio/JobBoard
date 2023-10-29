<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\JobPost;
use App\Models\Language;
use App\Models\Country;
use App\Models\ContractType;
use App\Models\Level;

class JobsBoardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = JobPost::with(['user', 'country', 'contract_type', 'level', 'languages'])
            ->orderBy("is_featured", "desc")->orderBy("title", "asc")->get();

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
        })->orderBy("is_featured", "desc")->orderBy("title", "asc")->get();

        return view("home", ["posts" => $response]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = Language::all();
        $countries = Country::all();
        $contractTypes = ContractType::all();
        $levels = Level::all();

        return view("addPost", [
            "languages" => $languages,
            "countries" => $countries,
            "contractTypes" => $contractTypes,
            "levels" => $levels
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */

    private function getLanguagesIDs($languages)
    {
        $languagesIDs = [];
        foreach ($languages as $language) {
            $languageID = Language::where("name", $language)->first()->id;
            array_push($languagesIDs, $languageID);
        }
        return $languagesIDs;
    }

    public function store(Request $request)
    {
        $request->validate([
            "company_name" => "required|string",
            "title" => "required|string",
            "salary" => "required|numeric",
            "logo" => "required|image",
            "level" => "required|string",
            "contract_type" => "required|string",
            "location" => "required|string",
            "languages" => "required|array",
        ]);

        try {
            $logo = $request->file("logo");
            $path = public_path("/logos");
            $newName = time() . "." . $logo->extension();
            $logo->move($path, $newName);
        } catch (Exception $e) {
            return redirect()->back()->with("error", "Error uploading logo");
        }

        $newPost = new JobPost(
            [
                "company_name" => $request->company_name,
                "title" => $request->title,
                "salary" => $request->salary,
                "logo" => $newName,
                "is_featured" => $request->has("is_featured") ? true : false,
            ]
        );
        $level = Level::where("name", $request->level)->first();
        $newPost->level()->associate($level);

        $contract_type = ContractType::where("name", $request->contract_type)->first();
        $newPost->contract_type()->associate($contract_type);

        $country = Country::where("name", $request->location)->first();
        $newPost->country()->associate($country);

        $newPost->user()->associate(auth()->user());
        $newPost->save();

        $newPost->languages()->attach($this->getLanguagesIDs($request->languages));
        $newPost->save();

        return redirect()->route("home")->with("success", "Job post created successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $currentUserPosts = JobPost::with(['user', 'country', 'contract_type', 'level', 'languages'])
            ->where("author", auth()->user()->id)
            ->orderBy("is_featured", "desc")->get();
        return view("editPost", ["posts" => $currentUserPosts]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $languages = Language::all();
        $countries = Country::all();
        $contractTypes = ContractType::all();
        $levels = Level::all();

        $post = JobPost::with(['user', 'country', 'contract_type', 'level', 'languages'])
            ->where("id", $id)->first();

        return view("editPostForm", [
            "post" => $post,
            "languages" => $languages,
            "countries" => $countries,
            "contractTypes" => $contractTypes,
            "levels" => $levels
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            "company_name" => "required|string",
            "title" => "required|string",
            "salary" => "required|numeric",
            "logo" => "image",
            "level" => "required|string",
            "contract_type" => "required|string",
            "location" => "required|string",
            "languages" => "required|array",
        ]);

        var_dump($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}