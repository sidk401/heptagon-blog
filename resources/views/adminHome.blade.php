@extends('layouts.app')
 
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Blog') }}</div>

                <div class="card-body">

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
            <th>Action </th>

        </tr>

        @if(isset($posts) && count($posts)) 

        @foreach ($posts as $index => $post)
        <tr>
            <td>{{ $index + $posts->firstItem() }}</td>
            <td>{{ $post->title }}</td>
            <td>{{ $post->description }}</td>
    
            <td>
             @if($post->is_approved == 0)
             <a class="btn btn-primary" href="{{ route('posts.approve',$post->id) }}">Approve</a>
            @endif
             </td>

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


