@extends('admin.layouts.dashboard')

@section('content')

<h1>Add New Transaction</h1>

@if ($errors->any())
    <div class="alert alert-danger" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li> 
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="/transactions" enctype="multipart/form-data">
    {{ csrf_field() }}
    
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" name="title" class="form-control" id="title" placeholder="Title..." value="{{ old('title') }}">
    </div>
    <div class="form-group">
        <label for="title">Amount</label>
        <input type="text" name="amount" class="form-control" id="amount" placeholder="Amount" value="{{ old('title') }}">
    </div>
    <div class="form-group">
        <label for="title">Date</label>
        <input type="date" name="date" class="form-control" id="date" placeholder="Amount" value="{{ old('title') }}">
    </div>

    <div class="form-group pt-2">
        <input class="btn btn-primary" type="submit" value="Submit">
    </div>
</form>

<script>
    CKEDITOR.replace( 'post_content' );
</script>

@endsection