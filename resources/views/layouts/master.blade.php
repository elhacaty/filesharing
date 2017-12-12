<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <title>Filesharing for HUST students</title>

    <link href="/css/nav.css" rel="stylesheet">
    <link href="/css/footer.css" rel="stylesheet">
    <link href="/css/side-bar.css" rel="stylesheet">



    <!--<link href="/css/search-bar.css" rel="stylesheet">-->

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
          integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.5/sweetalert2.all.js"></script>

    <style>
        .doc-item-cart{
            background: white;
            padding:5px;
            margin-bottom: 5px;
        }
        label {
            display: inline-block;
            margin-right: 10px;
        }
    </style>
</head>

<body>
@include('layouts.navbar')

<div class="container">
    @if(Session::has('success'))
        <div style="text-align: center;" class="alert alert-success alert-dismissible show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>{{ Session::get('success')}}</strong>
        </div>
    @endif

        @if(Session::has('error'))
            <div style="text-align: center;" class="alert alert-danger alert-dismissible show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>{{ Session::get('error')}}</strong>
            </div>
        @endif

    @if ($errors->has('email'))
        <div style="text-align: center;" class="alert alert-warning alert-dismissible show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>Không phát hiện tài khoản của bạn trong cơ sở dữ liệu của chúng tôi, xin vui lòng kiểm tra lại.</strong>
        </div>
    @endif
</div>

@include('layouts.carousel')

@include('layouts.search-bar')

<div class="container">
    <div class="row">
        @include('layouts.side-bar')

        <div class="col-sm-9 col-md-9">
            <div class="well" style="background: #fbfbfb;">
                @yield('content')
            </div>
        </div>
    </div>
</div>

@include('layouts.footer')
</body>

</html>
