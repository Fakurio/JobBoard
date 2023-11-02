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
        print("Moje aplikacje");
    }

    public function showApplicants()
    {
        print("Moje oferty");
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
            "status" => $applicationStatus,
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
