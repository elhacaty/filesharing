@extends("layouts.master")
@section('content')
    @if($count==0)
        <div class="doc-item-cart">
            <h3>Bạn chưa có bài viết nào. Hãy <a href="/posts/create">tạo bài viết mới</a> ngay hôm nay!</h3>
        </div>
    @endif
    @foreach($posts as $post)
        <div class="doc-item-cart">
            <div class="row">
                <div class="col-md-8">
                    <a href="/posts/{{$post->id}}"><h3>{{$post->title}}</h3></a>
                    <p>{{$post->content}}</p>
                    <p>Môn học: {{$post->subject->name}}</p>
                    <label><i class="fa fa-file-o" aria-hidden="true"></i> {{$post->doc_original_name}}</label>
                    <a href="http://filesharing.app/{{$post->source}}" style="margin-right: 5px;"
                       class="btn btn-info btn-sm" role="button">Tải về</a>
                </div>
                <div class="col-md-4">
                    @if($post->status == 'approved')
                        <div class="alert alert-success" role="alert" style="text-align: center">
                            <b>Đã được duyệt</b>
                        </div>
                    @elseif($post->status == 'waiting for approval')
                        <div class="alert alert-warning" role="alert" style="text-align: center">
                            <b>Đang chờ duyệt</b>
                        </div>
                    @else
                        <div class="alert alert-danger" role="alert" style="text-align: center">
                            <b>Đã bị chặn</b>
                        </div>
                    @endif

                    {{--post rating: based on views, downloads, likes--}}
                    @if(($post->views + $post->downloads + $post->likes->where('like','1')->count()) > 30 )
                        <i class="fa fa-star fa-lg" aria-hidden="true" style="color: yellowgreen; margin-bottom: 10px;">
                            <p style="display: inline; font-size: x-large">Bài viết nổi bật</p>
                        </i>
                    @endif

                    <p>Đã xem: {{$post->views}} lượt</p>
                    <p>Đã tải: {{$post->downloads}} lượt</p>

                </div>
            </div>
        </div>
    @endforeach
@endsection