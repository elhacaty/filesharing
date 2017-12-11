@extends('layouts.master')
@section('content')
    @if($count==0)
        <div class="doc-item-cart">
            <h3>Bạn chưa thích bài viết nào :(</h3>
        </div>
    @else
        @foreach($likes as $like)
            <div class="doc-item-cart">
                <div class="row">
                    <div class="col-md-9">
                        <a href="/posts/{{$like->post->id}}"><h2 style="color: #428bca;">{{$like->post->title}}</h2></a>
                        <i><h5>Đăng bởi {{$like->post->user->name}} lúc {{$like->post->created_at}}</h5></i>
                        <h5>Môn học: {{$like->post->subject->name}}</h5>
                        <h4>Nội dung: {{$like->post->content}}</h4>
                        <label>
                            <i class="fa fa-file-o" aria-hidden="true"></i> {{$like->post->doc_original_name}}
                        </label>
                        <a href="http://filesharing.app/{{$like->post->source}}" style="margin-right: 5px;"
                           class="btn btn-info btn-sm" role="button">Tải về</a>
                    </div>
                    <div class="co-md-3" style="margin-top: 25px;">
                        <i style="display:inline; color:#5cb85c;>" class="fa fa-thumbs-o-up fa-2x"></i>&nbsp;
                        <h3 style="display:inline; color:#5cb85c;">{{$like->post->likes->where('like', '1')->count()}}</h3>&nbsp;&nbsp;&nbsp;
                        <i style="display:inline; color: #d9534f;" class="fa fa-thumbs-o-down fa-2x"></i>&nbsp;
                        <h3 style="display:inline; color: #d9534f;">{{$like->post->likes->where('like', '0')->count()}}</h3>
                    </div>
                </div>
            </div>
            </div>
        @endforeach
    @endif
@endsection