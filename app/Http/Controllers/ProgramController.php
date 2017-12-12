<?php

namespace App\Http\Controllers;

use App\Program;
use App\Subject;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ProgramController extends Controller
{
    public function is_posts(){
        $subjects = Subject::where('program_id', '5')->get();
        $posts = new Collection();
        foreach ($subjects as $subject) {
            $tmp = $subject->posts->where('status', 'approved');
            $posts = $posts->merge($tmp);
        }
        $posts->sortByDesc('views');
        $count = count($posts);
        return view('programs.is', compact('posts', 'count'));
    }
}
