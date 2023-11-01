<?php

namespace App\Http\Controllers;

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

    public function store(Request $request)
    {
        print("Aplikuj" . $request->postID);
    }

    public function update($newStatus, $id)
    {
        print("" . $newStatus . "" . $id);
    }
}
