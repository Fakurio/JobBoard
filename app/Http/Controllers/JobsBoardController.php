<?php

namespace App\Http\Controllers;

use Exception;
use File;
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
            "company_name" => "required|string|regex:/^[a-zA-Z\s]+$/",
            "title" => "required|string|regex:/^[a-zA-Z\s]+$/",
            "salary" => "required|numeric",
            "logo" => "required|image|mimes:jpeg,png,jpg,svg",
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

        try {
            $postToUpdate = new JobPost(
                [
                    "company_name" => $request->company_name,
                    "title" => $request->title,
                    "salary" => $request->salary,
                    "logo" => $newName,
                    "is_featured" => $request->has("is_featured") ? true : false,
                ]
            );
            $level = Level::where("name", $request->level)->first();
            $postToUpdate->level()->associate($level);

            $contract_type = ContractType::where("name", $request->contract_type)->first();
            $postToUpdate->contract_type()->associate($contract_type);

            $country = Country::where("name", $request->location)->first();
            $postToUpdate->country()->associate($country);

            $postToUpdate->user()->associate(auth()->user());
            $postToUpdate->save();

            $postToUpdate->languages()->attach($this->getLanguagesIDs($request->languages));
            $postToUpdate->save();

            return redirect()->route("home")->with("success", "Job post created successfully");
        } catch (Exception $e) {
            return redirect()->route("home")->with("error", "Error creating job post");
        }
    }

    /**
     * Display posts of the authenticated user.
     */
    public function show()
    {
        $currentUserPosts = JobPost::with(['user', 'country', 'contract_type', 'level', 'languages'])
            ->where("author", auth()->user()->id)
            ->orderBy("is_featured", "desc")->get();
        return view("editPost", ["posts" => $currentUserPosts]);
    }

    /**
     * Show the form for editing the specific post.
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
     * Update the specified post in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "company_name" => "required|string|regex:/^[a-zA-Z\s]+$/",
            "title" => "required|string|regex:/^[a-zA-Z\s]+$/",
            "salary" => "required|numeric",
            "logo" => "image|mimes:jpeg,png,jpg,svg",
            "level" => "required|string",
            "contract_type" => "required|string",
            "location" => "required|string",
            "languages" => "required|array",
        ]);


        $postToUpdate = JobPost::find($id);
        $postToUpdate->company_name = $request->company_name;
        $postToUpdate->title = $request->title;
        $postToUpdate->salary = $request->salary;
        $postToUpdate->is_featured = $request->has("is_featured") ? true : false;

        try {
            $newLogo = $request->file("logo");
            if (!File::exists(public_path("/logos/$newLogo"))) {
                File::delete(public_path("/logos/$postToUpdate->logo"));
                $newName = time() . "." . $newLogo->extension();
                $newLogo->move(public_path("/logos"), $newName);
                $postToUpdate->logo = $newName;
            }
        } catch (Exception $e) {
            return redirect()->back()->with("error", "Error uploading logo");
        }

        try {
            $newlevel = Level::where("name", $request->level)->first();
            $postToUpdate->level()->dissociate();
            $postToUpdate->level()->associate($newlevel);

            $newContractType = ContractType::where("name", $request->contract_type)->first();
            $postToUpdate->contract_type()->dissociate();
            $postToUpdate->contract_type()->associate($newContractType);

            $newCountry = Country::where("name", $request->location)->first();
            $postToUpdate->country()->dissociate();
            $postToUpdate->country()->associate($newCountry);

            $postToUpdate->languages()->detach();
            $postToUpdate->languages()->attach($this->getLanguagesIDs($request->languages));

            $postToUpdate->save();

            return redirect()->route("home")->with("success", "Job post updated successfully");
        } catch (Exception $e) {
            return redirect()->route("home")->with("error", "Error updating job post");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}