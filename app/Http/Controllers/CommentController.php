<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;


class CommentController extends Controller
{

    public function store(Post $post)
    {
        $comment = new Comment;
        $comment->user_id = Auth::user()->id;
        $comment->post_id = $post->id;
        $comment->content = request('comment-content');
        $comment->save();

        return redirect('/posts/'.$post->id);
    }

    public function destroy($post_id, $comment_id){
        $comment = Comment::find($comment_id);
        $comment->delete();
        return redirect('/posts/'.$post_id);
    }
}
