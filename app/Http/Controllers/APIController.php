<?php

namespace App\Http\Controllers;

use App\Program;
use App\Institute;
use Illuminate\Http\Request;

class APIController extends Controller
{
    public function getInstituteData($id)
    {
        $institute =  Institute::findOrFail($id);
        $tmp = ["|"];
        foreach($institute->programs as $program){
            $item = $program->id.'|'.$program->name;
            array_push($tmp, $item);
        }
        return $tmp;

    }

    public function getProgramData($id)
    {
        $program =  Program::findOrFail($id);
        $tmp = ["|"];
        foreach($program->subjects as $subject){
            $item = $subject->id.'|'.$subject->name;
            array_push($tmp, $item);
        }
        return $tmp;

    }
}
