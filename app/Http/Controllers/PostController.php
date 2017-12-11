<?php

namespace App\Http\Controllers;

use App\Institute;
use App\Like;
use App\Post;
use App\Program;
use App\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $posts = Post::where('user_id', Auth::user()->id)
//        -> where('status', 'approved')->get();
        $posts = Auth::user()->posts;
        $count = Auth::user()->posts->count();
        return view('posts.index', compact('posts', 'count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $institutes = Institute::all();
        $departments = Program::all();
        return view('posts.create', compact('institutes', 'departments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array|\Illuminate\Http\UploadedFile
     */
    public function store(Request $request)
    {
        $post = new Post;
        $post->user_id = Auth::user()->id;
        $post->subject_id = request('subject');
        $post->title = request('title');
        $post->content = request('content');
        $post->doc_original_name = $request->document->getClientOriginalName();
        $doc_original_name = $request->document->getClientOriginalName();
        $tmp = Auth::user()->id . "_" . \request('subject') . "_" . $doc_original_name;
        $post->doc_managed_name = $tmp;
        $request->file('document')->move(public_path("/documents"), $tmp);
        $post->source = 'documents/' . $tmp;
        $post->status = 'waiting for approval';
        $post->views = 0;
        $post->downloads = 0;
        $post->save();

        return redirect('/posts')->with('success', 'Bài viết mới của bạn đã được tạo thành công');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $comments = $post->comments;
        return view('posts.show', compact('post', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $institutes = Institute::all();
        $departments = Program::all();
        return view('posts.edit', compact('post', 'institutes', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $comments = $post->comments;
        foreach ($comments as $comment) {
            $comment->delete();
        }
        $old_file = public_path() . '/documents/' . $post->user_id . '_' . $post->subject_id . '_' . $post->doc_original_name;
        unlink($old_file);
        $post->delete();
        return redirect('/posts')->with('success', 'Bài viết của bạn đã được xóa thành công!');;
    }

    public function like(Request $request)
    {
        $post_id = $request['postId'];
        $is_like = $request['isLike'] === 'true';
        $update = false;
        $post = Post::find($post_id);

        $counter = [
            "like" => 0,
            "dislike" => 0
        ];
        if (!$post) {
            return null;
        }
        $user = Auth::user();
        $like = $user->likes()->where('post_id', $post_id)->first();
        if ($like) {
            $already_like = $like->like;
            $update = true;
            if ($already_like == $is_like) {
                $like->delete();
                $counter["like"] = $post->likes->where('like', '1')->count();
                $counter["dislike"] = $post->likes->where('like', '0')->count();

                return $counter;
            }
        } else {
            $like = new Like();
        }
        $like->like = $is_like;
        $like->user_id = $user->id;
        $like->post_id = $post->id;
        if ($update) {
            $like->update();
        } else {
            $like->save();
        }

        $counter["like"] = $post->likes->where('like', '1')->count();
        $counter["dislike"] = $post->likes->where('like', '0')->count();

        return $counter;
    }

    public function liked()
    {
        $count = Auth::user()->likes->where('like', '1')->count();
        $likes = Auth::user()->likes->where('like', '1');
        return view('posts.liked', compact('likes', 'count'));
    }

    public function commented()
    {
        $count = Auth::user()->comments->count();
        $comments = Auth::user()->comments;
        return view('posts.commented', compact('comments', 'count'));
    }

    public function save(Request $request, Post $post)
    {
        $old_file = public_path() . '/documents/' . $post->user_id . '_' . $post->subject_id . '_' . $post->doc_original_name;
        $post->subject_id = request('subject');
        $post->title = request('title');
        $post->content = request('content');
        $post->doc_original_name = request('document')->getClientOriginalName();
        $doc_original_name = request('document')->getClientOriginalName();
        $tmp = Auth::user()->id . "_" . request('subject') . "_" . $doc_original_name;
        $post->doc_managed_name = $tmp;
        $request->file('document')->move(public_path("/documents"), $tmp);
        $post->source = 'documents/' . $tmp;
        $post->status = 'waiting for approval';
        unlink($old_file);
        $post->save();
        return redirect('/posts/')->with('success', 'Bài viết của bạn đã được chỉnh sửa thành công');
    }

    /**
     * @param Request $request
     * @return null
     */
    public function view_count(request $request)
    {
        $post_id = $request['postId'];
        $post = Post::find($post_id);
        $tmp = $post->views;
        $tmp = $tmp + 1;
        $post->views = $tmp;
        $post->save();
        return null;
    }

    public function download_count(request $request)
    {
        $post_id = $request['postId'];
        $post = Post::find($post_id);
        $tmp = $post->downloads;
        $tmp = $tmp + 1;
        $post->downloads = $tmp;
        $post->save();
        return null;
    }

    public function search(Request $request)
    {
        $find_by = $request->get('findby');
        $sort_by = $request->get('sortby');

//        FIND BY POST'S TITLE
        if ($find_by == 'title') {
            if ($sort_by == 'views') {
                $posts = Post::where('title', 'like', '%' . $request->get('search') . '%')
                    ->where('status', 'approved')
                    ->orderBy('views', 'desc')
                    ->get();
                $count = $posts->count();
            } elseif ($sort_by == 'downloads') {
                $posts = Post::where('title', 'like', '%' . $request->get('search') . '%')
                    ->where('status', 'approved')
                    ->orderBy('downloads', 'desc')
                    ->get();
                $count = $posts->count();
            } elseif ($sort_by == 'likes') {
                $string = $request->get('search');
                $posts_ids = DB::select(
                    "select posts.id as id, count(*)
                    from posts, likes
                    where posts.id = likes.post_id
                    and posts.status = 'approved'
                    and posts.title like '%$string%'
                    and likes.like = '1'
                    group by posts.id
                    order by count(*) desc"
                );
                $count = count($posts_ids);
                $posts = [];
                $ids = [];
                foreach ($posts_ids as $posts_id) {
                    array_push($ids, $posts_id->id);
                }

                foreach ($ids as $id) {
                    $tmp = Post::find($id);
                    array_push($posts, $tmp);
                }
            }
        } //        FIND BY SUBJECT
        elseif ($find_by == 'subject') {
            if ($sort_by == 'views') {
                $subjects = Subject::where('name', 'like', '%' . $request->get('search') . '%')->get();
                $posts = new Collection();
                foreach ($subjects as $subject) {
                    $tmp = $subject->posts->where('status', 'approved');
                    $posts = $posts->merge($tmp);
                }
                $posts->sortByDesc('views');
                $count = count($posts);
            } elseif ($sort_by == 'downloads') {
                $subjects = Subject::where('name', 'like', '%' . $request->get('search') . '%')->get();
                $posts = new Collection();
                foreach ($subjects as $subject) {
                    $tmp = $subject->posts->where('status', 'approved');
                    $posts = $posts->merge($tmp);
                }
                $posts->sortByDesc('downloads');
                $count = count($posts);
            } elseif ($sort_by == 'likes') {
                $string = $request->get('search');
                $posts_ids = DB::select(
                    "select posts.id as id, count(*)
                    from posts, likes, subjects
                    where posts.id = likes.post_id
                    and posts.subject_id = subjects.id
                    and posts.status = 'approved'
                    and subjects.name like '%$string%'
                    and likes.like = '1'
                    group by posts.id
                    order by count(*) desc"
                );
                $posts = [];
                $ids = [];
                foreach ($posts_ids as $posts_id) {
                    array_push($ids, $posts_id->id);
                }

                foreach ($ids as $id) {
                    $tmp = Post::find($id);
                    array_push($posts, $tmp);
                }
                $count = count($posts);
            }
        } //        FIND BY POST'S CONTENT
        elseif ($find_by == 'content') {
            if ($sort_by == 'views') {
                $posts = Post::where('content', 'like', '%' . $request->get('search') . '%')
                    ->where('status', 'approved')
                    ->orderBy('views', 'desc')
                    ->get();
                $count = $posts->count();
            } elseif ($sort_by == 'downloads') {
                $posts = Post::where('content', 'like', '%' . $request->get('search') . '%')
                    ->where('status', 'approved')
                    ->orderBy('downloads', 'desc')
                    ->get();
                $count = $posts->count();
            } elseif ($sort_by == 'likes') {
                $string = $request->get('search');
                $posts_ids = DB::select(
                    "select posts.id as id, count(*)
                    from posts, likes
                    where posts.id = likes.post_id
                    and posts.status = 'approved'
                    and posts.content like '%$string%'
                    and likes.like = '1'
                    group by posts.id
                    order by count(*) desc"
                );
                $count = count($posts_ids);
                $posts = [];
                $ids = [];
                foreach ($posts_ids as $posts_id) {
                    array_push($ids, $posts_id->id);
                }

                foreach ($ids as $id) {
                    $tmp = Post::find($id);
                    array_push($posts, $tmp);
                }
            }
        }

        return view('posts.search-result', compact('posts', 'count'));
    }
}
