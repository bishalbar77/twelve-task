@extends('admin.layouts.dashboard')

@section('content')

<h1>Update Transaction</h1>

@if ($errors->any())
    <div class="alert alert-danger" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li> 
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="/transactions/{{ $post->id }}" enctype="multipart/form-data">
    @method('PATCH')
    @csrf()
    
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" name="title" class="form-control" id="title" placeholder="Title..." value="{{ $post->title }}">
    </div>
    <div class="form-group">
        <label for="title">Amount</label>
        <input type="text" name="amount" class="form-control" id="amount" placeholder="Amount" value="{{ $post->amount }}">
    </div>
    <div class="form-group">
        <label for="title">Date</label>
        <input type="date" name="date" class="form-control" id="date" placeholder="Amount" value="{{ $post->date }}">
    </div>

    <div class="form-group pt-2">
        <input class="btn btn-primary" type="submit" value="Submit">
    </div>
</form>

@section('js_post_page')

    <script>
        
        CKEDITOR.replace( 'post_content' );

        $(function() {

            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    
                    reader.onload = function (e) {
                        $('#profile-img-tag').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
            
            $("#profile-img").change(function(){
                readURL(this);
            });

        });

        $(document).ready(function(){    
            $('#publish-post').on('click', function(event) {
                // event.preventDefault();

                if ($("#publish-post").is(":checked")){
                    var checked = 1;
                }else{
                    var checked = 0;
                }
                $.ajax({
                    url: "/posts/{{$post->id}}",
                    method: 'get',
                    dataType: 'json',
                    data: {
                        task: {
                            id: "{{$post->id}}",
                            checked: checked
                        }
                    }
                }).done(function(data) {
                    console.log(data);
                });
            });
            
        });


    </script>
    
@endsection

@endsection