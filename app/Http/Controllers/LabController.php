<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LabController extends Controller
{
    public function index()
    {
        $data = ['name' => 'Sophie', 'role' => 'Student'];
        return view('welcome', $data);
    }

    public function about()
    {
        $data = ['name' => 'Sophie', 'role' => 'Student', 'description' => 'I hate summer', 'age' => 10];
        return view('about', $data);
    }

    public function contact()
    {
        $data = ['email' => 'sofiyalev06@gmail.com', 'phone' => '+380684297891'];
        return view('contact', $data);
    }

    public function hobbies()
    {
        $data = ['name' => 'Sophie', 'hobbies' => 'Reading, singing'];
        return view('hobbies', $data);
    }
}
