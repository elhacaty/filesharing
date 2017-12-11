@extends('layouts.master')
@section('content')
    @if($count==0)
        <div class="doc-item-cart">
            <h3>Bạn chưa bình luận ở bài viết nào :(</h3>
        </div>
    @else
        @foreach($comments as $comment)
            <div class="doc-item-cart">
                <div class="row">
                    <div class="col-md-8">
                        <a style="cursor: pointer;" onclick="viewCount({{$comment->post->id}})"><h2 style="color: #428bca;">{{$comment->post->title}}</h2></a>
                        <i><h5>Đăng bởi {{$comment->post->user->name}} lúc {{$comment->post->created_at}}</h5></i>
                        <h5>Môn học: {{$comment->post->subject->name}}</h5>
                        <h4>Nội dung: {{$comment->post->content}}</h4>
                        <label>
                            <i class="fa fa-file-o" aria-hidden="true"></i> {{$comment->post->doc_original_name}}
                        </label>
                        <a href="http://filesharing.app/{{$comment->post->source}}" style="margin-right: 5px;"
                           class="btn btn-info btn-sm" role="button" onclick="downloadCount({{$comment->post->id}})">Tải về</a>
                    </div>
                    <div class="co-md-4" style="margin-top: 25px;">
                        @if(($comment->post->views + $comment->post->downloads + $comment->post->likes->where('like','1')->count()) > 30 )
                            <i class="fa fa-star fa-2x" aria-hidden="true" style="color: yellowgreen;">
                                <p style="display: inline; font-size: x-large">Bài viết nổi bật</p>
                            </i>
                        @endif

                        <div style="margin-bottom: 5px">
                            {{--views and downloads count--}}
                            <p style="margin-top: 10px;">Đã xem: {{$comment->post->views}} lượt</p>
                            <p>Đã tải: {{$comment->post->downloads}} lượt</p>

                            {{--likes and dislike count--}}
                            <i style="display:inline; color:#5cb85c;>" class="fa fa-thumbs-o-up fa-lg"></i>&nbsp;
                            <h4 id="like_count"
                                style="display:inline; color:#5cb85c;">{{$comment->post->likes->where('like', '1')->count()}}</h4>&nbsp;&nbsp;&nbsp;
                            <i style="display:inline; color: #d9534f;" class="fa fa-thumbs-o-down fa-lg"></i>&nbsp;
                            <h4 id="dislike_count"
                                style="display:inline; color: #d9534f;">{{$comment->post->likes->where('like', '0')->count()}}</h4>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

    <script>
        var token = '{{ Session::token() }}';

        var urlViewCount = '{{ route('view_count') }}';
        var urlDownloadCount = '{{route('download_count')}}';

        function downloadCount(id) {
            $.ajax({
                method: 'POST',
                url: urlDownloadCount,
                data: {postId: id, _token: token}
            })
        }

        function viewCount(id) {
            $.ajax({
                method:'POST',
                url: urlViewCount,
                data:{postId: id, _token: token},
                success: function () {
                    window.location.href = '/posts/'+id;
                }
            })
        }
    </script>
@endsection