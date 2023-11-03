<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\JobApplicationsStatus;
use App\Models\JobPost;
use Illuminate\Http\Request;

class JobApplicationsController extends Controller
{
    public function showApplications()
    {
        $applications = JobApplication::with(["status", "post", "post.level", "post.contract_type", "post.country", "post.languages", "post.user"])
            ->where("user_id", auth()->user()->id)->get();

        return view("myApplications", ["applications" => $applications]);
    }

    public function showApplicants()
    {
        $posts = JobPost::with(["user", "level", "contract_type", "languages", "country", "applications", "applications.user"])
            ->where("author", auth()->user()->id)
            ->whereHas("applications", function ($q) {
                $q->where("job_post_id", "!=", null);
            })
            ->get();

        return view("myOfferts", ["posts" => $posts]);
    }

    //store current user application for job in database
    public function store(Request $request)
    {
        $postAuthorID = JobPost::where("id", $request->postID)->first()->author;
        if ($postAuthorID == request()->user()->id) {
            return back()->with("error", "You can't apply for your own job offer");
        }

        $applicationStatus = JobApplicationsStatus::where("name", "Sent")->first()->id;
        $newApplication = JobApplication::create([
            "status_id" => $applicationStatus,
            "user_id" => request()->user()->id,
            "job_post_id" => $request->postID,
        ]);
        $newApplication->save();

        return back()->with("success", "Application sent");
    }

    public function update($newStatus, $id)
    {
        print("" . $newStatus . "" . $id);
    }
}
