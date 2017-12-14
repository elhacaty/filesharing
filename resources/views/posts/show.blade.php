@extends('layouts.master')
@section('content')
    <div class="doc-item-cart">
        <div class="row">
            <div class="col-md-8">
                <h2 style="color: #428bca;">{{$post->title}}</h2>
                <i><h5>Đăng bởi {{$post->user->name}} lúc {{$post->created_at}}</h5></i>
                <h5>Môn học: {{$post->subject->name}}</h5>
                <h4>Nội dung: {{$post->content}}</h4>
                <label>
                    <i class="fa fa-file-o" aria-hidden="true"></i> {{$post->doc_original_name}}
                </label>

                <!-- download file button-->
                <a href="http://filesharing.app/{{$post->source}}" style="margin-right: 5px;"
                   class="btn btn-info btn-sm" role="button" onclick="downloadCount({{$post->id}})">Tải về</a>

            @if (Auth::check())
                @if (Auth::user()->id == $post->user->id)
                    @if(Auth::user()->status == "approved")
                        <!-- edit post button -->
                            <form style="display: inline" action="/posts/{{$post->id}}/edit" method="get">
                                <button class="btn btn-warning btn-sm">Chỉnh sửa bài viết</button>
                            </form>

                            <!-- Delete post button -->
                            <a style="margin-left: 5px;" class="btn btn-danger btn-sm" data-toggle="modal"
                               data-target="#delete-postModal">Xóa bài viết</a>
                            <div class="modal fade" id="delete-postModal" tabindex="-1" role="dialog"
                                 aria-labelledby="basicModal" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                                &times;
                                            </button>
                                            <h4 class="modal-title" id="myModalLabel">Xác nhận xóa</h4>
                                        </div>
                                        <div class="modal-body">
                                            <i class="fa fa-trash-o fa-2x" aria-hidden="true"> Bạn có chắc chắn muốn xóa
                                                bài
                                                viết này?</i>
                                            {{--<h3>Bạn có chắc chắn muốn xóa bình luận này?</h3>--}}
                                        </div>
                                        <div class="modal-footer">
                                            <form style="display: inline;" class="input-group" method="post"
                                                  action="/posts/{{$post->id}}/delete-post">
                                                {{method_field('DELETE')}}
                                                {{csrf_field()}}
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng
                                                </button>
                                                <button type="submit" class="btn btn-danger">
                                                    Xóa bài viết
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                @endif
            </div>

            <!-- like/dislike button-->
            <div class="col-md-4" style="margin-top:5px;" data-postid="{{$post->id}}">
                {{--like and dislike button--}}
                @if(Auth::check())
                    @if(Auth::user()->status == "approved")
                        <button class="like btn btn-success btn-sm" style="margin-right: 5px;">{{Auth::user()->likes()->where('post_id', $post->id)->first() ?
                    Auth::user()->likes()->where('post_id', $post->id)->first()->like == 1 ? 'You like this post' : 'Like' : 'Like'}}</button>
                        <button class="like btn btn-danger btn-sm">{{Auth::user()->likes()->where('post_id', $post->id)->first() ?
                    Auth::user()->likes()->where('post_id', $post->id)->first()->like == 0 ? 'You don\'t like this post' : 'Dislike' : 'Dislike'}}</button>
                    @endif
                @endif

                {{--post rating: based on views, downloads, likes--}}
                @if(($post->views + $post->downloads + $post->likes->where('like','1')->count()) > 30 )
                    <i class="fa fa-star fa-2x" aria-hidden="true" style="color: yellowgreen; margin-top: 10px;">
                        <p style="display: inline; font-size: x-large">Bài viết nổi bật</p>
                    </i>
                @endif

                <div style="margin-bottom: 5px">
                    {{--views and downloads count--}}
                    <p style="margin-top: 10px;">Đã xem: {{$post->views}} lượt</p>
                    <p>Đã tải: {{$post->downloads}} lượt</p>

                    {{--likes and dislike count--}}
                    <i style="display:inline; color:#5cb85c;>" class="fa fa-thumbs-o-up fa-lg"></i>&nbsp;
                    <h4 id="like_count"
                        style="display:inline; color:#5cb85c;">{{$post->likes->where('like', '1')->count()}}</h4>&nbsp;&nbsp;&nbsp;
                    <i style="display:inline; color: #d9534f;" class="fa fa-thumbs-o-down fa-lg"></i>&nbsp;
                    <h4 id="dislike_count"
                        style="display:inline; color: #d9534f;">{{$post->likes->where('like', '0')->count()}}</h4>
                    <br>
                </div>

            </div>
        </div>
    </div>

    <!-- show all comments of post-->
    <h3 style="color: #428bca"><i>Bình luận:</i></h3>
    @foreach($comments as $comment)
        <div class="row" style="margin-left: 10px">
            <div class="col-md-10">
                <h4>{{$comment->content}}</h4>
                <i>
                    <i><h5>by {{$comment->user->name}} at {{$comment->created_at}}</h5></i>
                </i>
            </div>

            <!-- delete comment button-->
            <div class="col-md-2">
                @if(Auth::check())
                    @if (Auth::user()->id == $comment->user->id)
                        <a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete-commentModal">Xóa</a>
                        <div class="modal fade" id="delete-commentModal" tabindex="-1" role="dialog"
                             aria-labelledby="basicModal" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                            &times;
                                        </button>
                                        <h4 class="modal-title" id="myModalLabel">Xác nhận xóa</h4>
                                    </div>
                                    <div class="modal-body">
                                        <i class="fa fa-trash-o fa-2x" aria-hidden="true"> Bạn có chắc chắn muốn xóa
                                            bình luận này?</i>
                                        {{--<h3>Bạn có chắc chắn muốn xóa bình luận này?</h3>--}}
                                    </div>
                                    <div class="modal-footer">
                                        <form method="post"
                                              action="/posts/{{$post->id}}/{{$comment->id}}/delete-comment">
                                            {{method_field('DELETE')}}
                                            {{csrf_field()}}
                                            <button type="submit" class="btn btn-danger">Xóa</button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Đóng
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    @endforeach


    <!-- add comment field and button-->
    @if(Auth::check())
        @if(Auth::user()->status == "approved")
            <form method="post" action="/posts/{{$post->id}}/comments">
                {{csrf_field()}}
                <textarea rows="4" cols="100" style="margin-top:10px" class="form-control" name="comment-content"
                          placeholder="Write comment here" required></textarea>
                <button type="submit" class="btn btn-info" style="margin-top:10px">Add comment</button>
            </form>
        @endif
    @endif

    <script>
        var token = '{{ Session::token() }}';
        var urlLike = '{{ route('like') }}';

        var urlDownloadCount = '{{route('download_count')}}'
        function downloadCount(id) {
            $.ajax({
                method: 'POST',
                url: urlDownloadCount,
                data: {postId: id, _token: token}
            })
        }

        $('.like').on('click', function (event) {
            event.preventDefault();
            postId = event.target.parentNode.dataset['postid'];
            var isLike = event.target.previousElementSibling == null;
            $.ajax({
                method: 'POST',
                url: urlLike,
                data: {isLike: isLike, postId: postId, _token: token}
            })
                .done(function (data) {
                    event.target.textContent = isLike ? event.target.textContent == 'Like' ? 'You like this post' : 'Like' :
                        event.target.textContent == 'Dislike' ? 'You don\'t like this post' : 'Dislike';
                    if (isLike) {
                        event.target.nextElementSibling.textContent = 'Dislike';
                    } else {
                        event.target.previousElementSibling.textContent = 'Like';
                    }

                    $("#like_count").html(data.like);
                    $("#dislike_count").html(data.dislike);

                });
        })
    </script>
@endsection