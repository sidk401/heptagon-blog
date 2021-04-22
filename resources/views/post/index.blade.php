@extends('layouts.app')
 
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Blog') }}</div>

                <div class="card-body">


    <div class="row">
        <div class="col-lg-12 margin-tb">
            
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('posts.create') }}"> Create New Blog</a> 
            </div>
        </div>
    </div>
   
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
   
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Title</th>
            <th>Description </th>
        </tr>

        @if(isset($posts) && count($posts)) 

        @foreach ($posts as $index => $post)
        <tr>
            <td>{{ $index + $posts->firstItem() }}</td>
            <td>{{ $post->title }}</td>
            <td>{{ $post->description }}</td>
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan='3'> No Blog </td>
        </tr>
        
        @endif
    </table>

    
    {!! $posts->links() !!}


		  </div>
            </div>
        </div>
    </div>
</div>      
@endsection


