<div class="container">

    <nav class="navbar navbar-default navbar-inverse" role="navigation">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <a class="navbar-brand" href="/">Filesharing for HUST Students</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                @if(!Auth::check())
                    <ul class="nav navbar-nav navbar-right">
                        <li><p class="navbar-text">Bạn đã có tài khoản?</p></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><b>Đăng nhập</b> <span
                                        class="caret"></span></a>
                            <ul id="login-dp" class="dropdown-menu">
                                <li>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <form class="form" role="form" method="post" action="{{ route('login') }}"
                                                  accept-charset="UTF-8" id="login-nav">
                                                {{csrf_field()}}

                                                <div class="form-group">
                                                    <input type="email" class="form-control" id="email" name="email"
                                                           placeholder="Email" required>

                                                    @if ($errors->has('email'))
                                                        <span class="help-block">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <input type="password" class="form-control" id="password"
                                                           name="password" placeholder="Mật khẩu" required>
                                                    <div class="help-block text-right">
                                                        <a href="/password/reset">Bạn quên mật khẩu?</a>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary btn-block">
                                                        Đăng nhập
                                                    </button>
                                                </div>
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox"
                                                               name="remember" {{ old('remember') ? 'checked' : '' }}>
                                                        Remember Me
                                                    </label>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="bottom text-center">
                                            Chưa có tài khoản? <a href="/register"><b>Đăng kí ngay!</b></a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                @else
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <p class="navbar-text">Xin chào, {{Auth::user()->name}}</p>
                        </li>
                        @if (Auth::user()->status == "approved")
                            <li><a href="/posts/create/">Tạo bài viết mới</a></li>
                        @endif
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Tài khoản <span
                                        class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="/posts">Các bài viết đã đăng</a></li>
                                <li><a href="/posts/liked">Các bài viết đã thích</a></li>
                                <li><a href="/posts/commented">Các bài viết đã bình luận</a></li>
                                <li class="divider"></li>
                                <li><a href="/password-change">Thay đổi mật khẩu</a></li>
                                <li class="divider"></li>
                                <li><a data-toggle="modal" data-target="#logoutModal" style="cursor: pointer">Đăng
                                        xuất</a></li>
                            </ul>
                        </li>
                    </ul>
                @endif
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>

    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModal"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Xác nhận đăng xuất</h4>
                </div>
                <div class="modal-body">
                    <i class="fa fa-sign-out fa-2x" aria-hidden="true"> Bạn có chắc chắn muốn đăng xuất?</i>
                </div>
                <div class="modal-footer">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        {{ csrf_field() }}
                        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-danger">
                            Đăng xuất
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div><!-- End nav-bar-->