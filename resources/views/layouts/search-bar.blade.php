<div class="container" style="margin-top: 10px;">
    <div class="well" style="background: #fbfbfb;">
        <div class="row">
            <form method="get" action="/search">
                <div class="col-md-6">
                    <div class="input-group" id="custom-search-input" style="margin-top: 5px;">
                        <input type="text" name="search" class="form-control input-lg" placeholder="Type in here"/>
                        <span class="input-group-btn">
                        <button class="btn btn-info btn-lg" type="submit">
                            <i class="glyphicon glyphicon-search"></i>
                        </button>
                    </span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div style="padding-top: 0px;">
                        <label>Tìm theo: </label>
                        <label class="radio-inline"><input type="radio" name="findby" value="title" checked>Tiêu đề bài viết</label>
                        <label class="radio-inline"><input type="radio" name="findby" value="subject">Tên môn học</label>
                        <label class="radio-inline"><input type="radio" name="findby" value="content">Nội dung bài
                            viết</label>
                    </div>
                    <div style="padding-top: 10px;">
                        <label>Thứ tự sắp xếp: </label>
                        <label class="radio-inline"><input type="radio" name="sortby" value="views" checked><i class="fa fa-eye"
                                                                                                 aria-hidden="true"></i>
                            Số lượt xem</label>
                        <label class="radio-inline"><input type="radio" name="sortby" value="downloads"><i class="fa fa-download"
                                                                                         aria-hidden="true"></i> Số lượt
                            tải</label>
                        <label class="radio-inline"><input type="radio" name="sortby" value="likes"><i class="fa fa-thumbs-o-up"
                                                                                         aria-hidden="true"></i> Số lượt
                            thích</label>
                    </div>
                </div>
            </form>
            {{--<div style="padding-top: 10px;">--}}
            {{--<label>Loại tài liệu cần tìm: </label>--}}
            {{--<label class="radio-inline"><input type="radio" name="filetype"><i class="fa fa-file-word-o" aria-hidden="true"></i> Word</label>--}}
            {{--<label class="radio-inline"><input type="radio" name="filetype"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF</label>--}}
            {{--<label class="radio-inline"><input type="radio" name="filetype"><i class="fa fa-file-zip-o" aria-hidden="true"></i> Zip</label>--}}
            {{--<label class="radio-inline"><input type="radio" name="filetype"><i class="fa fa-file-o" aria-hidden="true"></i> Khác</label>--}}
            {{--</div>--}}
        </div>
    </div>
</div>
</div>
