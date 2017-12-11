@extends('layouts.master')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">Đổi mật khẩu</div>
        <div class="panel-body">
            <form class="form-horizontal" method="POST" action="/password-change">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('passwordold') ? ' has-error' : '' }}">
                    <label for="password" class="col-md-4 control-label">Mật khẩu cũ:</label>

                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control" name="passwordold" required>

                        @if ($errors->has('passwordold'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('passwordold') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password" class="col-md-4 control-label">Mật khẩu mới:</label>

                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control" name="password" required>

                        @if ($errors->has('password'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label for="password-confirm" class="col-md-4 control-label">Xác nhận mật khẩu mới:</label>

                    <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control"
                               name="password_confirmation" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                            Đổi mật khẩu
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
