@extends('layouts.master')
@section('content')
    <form action="/subjects" method="post">
        <h3 style="margin-top: 0px;">
            Tạo môn học mới:
        </h3>

        {{csrf_field()}}

        <div class="form-group">
            <label for="sel1" style="margin-bottom: 10px;">Chọn Viện:</label>
            <select class="form-control" id="institute" name="institute" onchange="populate('institute', 'program')">
                <option></option>
                @foreach($institutes as $institute)
                    <option value="{{$institute->id}}">{{$institute->name}}</option>
                @endforeach
            </select>

            <label for="sel2" style="margin-bottom: 10px; margin-top: 10px;">Chọn Chương trình đào tạo:</label>
            <select class="form-control" id="program" name="program">

            </select>

        </div>

        <div class="form-group">
            <label for="title">Tên môn học: </label>
            <input style="height: 40px;" class="form-control" type="text" name="name">
        </div>

        <button type="submit" class="btn btn-info">Create</button>

    </form>

    <script>
        function populate(s1, s2) {
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
    </script>
@endsection