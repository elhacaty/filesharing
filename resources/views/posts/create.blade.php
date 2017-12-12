@extends('layouts.master')
@section('content')
    <form action="/posts" method="post" enctype="multipart/form-data">
        <h3 style="margin-top: 0px;">
            Tạo bài viết mới:
        </h3>

        {{csrf_field()}}

        <div class="form-group">
            <label for="title">Tiêu đề:</label>
            <input style="height: 35px;" class="form-control" type="text" name="title" required>
        </div>

        <div class="form-group">
            <label style="margin-bottom: 10px;">Chọn Viện:</label>
            <select class="form-control" id="institute" name="institute" onchange="populatePrograms('institute', 'program')" required>
                <option></option>
                @foreach($institutes as $institute)
                    <option value="{{$institute->id}}">{{$institute->name}}</option>
                @endforeach
            </select>

            <label style="margin-bottom: 10px; margin-top: 10px;">Chọn Chương trình đào tạo:</label>
            <select class="form-control" id="program" name="program" onchange="populateSubjects('program', 'subject')" required>

            </select>

            <label style="margin-bottom: 10px; margin-top: 10px;">Chọn Môn học:</label>
            <select class="form-control" id="subject" name="subject" required>

            </select>
        </div>

        <div class="form-group">
            <label>File input</label>
            <input type="file" class="form-control-file" name="document" required>
            {{--<small id="fileHelp" class="form-text text-muted">This is some placeholder block-level help text for the--}}
                {{--above input. It's a bit lighter and easily wraps to a new line.--}}
            {{--</small>--}}
        </div>

        <div class="form-group">
            <label for="content">Nội dung:</label>
            <textarea style="height: 150px;" type="text" name="content" class="form-control" id="content" required></textarea>
        </div>

        <button type="submit" class="btn btn-success">Upload</button>

        <a href="/posts/">
            <button style="margin-left: 5px;" class="btn btn-info" type="button">Cancel</button>
        </a>
    </form>

    <script>
        function populatePrograms(s1, s2) {
            var s1 = document.getElementById(s1);
            var s2 = document.getElementById(s2);
            s2.innerHTML = "";

            axios.get('/data/institutes/' + s1.value)
                .then(function (response) {
                    var optionArray = response.data;

                    for (var option in optionArray) {
                        var pair = optionArray[option].split("|");
                        var newOption = document.createElement("option");
                        newOption.value = pair[0];
                        newOption.innerHTML = pair[1];
                        s2.options.add(newOption);
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
        }

        function populateSubjects(s1, s2) {
            var s1 = document.getElementById(s1);
            var s2 = document.getElementById(s2);
            s2.innerHTML = "";

            axios.get('/data/programs/' + s1.value)
                .then(function (response) {
                    var optionArray = response.data;

                    for (var option in optionArray) {
                        var pair = optionArray[option].split("|");
                        var newOption = document.createElement("option");
                        newOption.value = pair[0];
                        newOption.innerHTML = pair[1];
                        s2.options.add(newOption);
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
        }
    </script>
@endsection
