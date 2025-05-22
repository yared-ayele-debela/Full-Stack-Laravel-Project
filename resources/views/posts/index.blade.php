@extends('layouts.app')

@section('content')
<h2 class="text-center">Laravel AJAX CRUD</h2>
    <form id="postForm">
        <input type="hidden" id="postId">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" id="title" class="form-control" placeholder="Enter title">
        </div>
        <div class="form-group">
            <label for="content">Content</label>
            <textarea id="content" class="form-control" placeholder="Enter content"></textarea>
        </div>
        <button type="submit" class="btn btn-primary" id="saveBtn">Save</button>
    </form>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Content</th>
            </tr>
        </thead>
        <tbody id="postTable">

        </tbody>
    </table>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function(){
            fetchPosts();
            function fetchPosts(){
                $.ajax({
                    url:'/posts/fetch',
                    method:'GET',
                    success:function(response){
                        let rows='';
                        response.posts.forEach(post=>{
                            rows += `
                        <tr>
                            <td>${post.id}</td>
                            <td>${post.title}</td>
                            <td>${post.content}</td>
                            <td>
                            <button class="btn btn-primary editBtn" data-id="{$post.id}">Edit<button>
                            <button class="btn btn-danger deleteBtn" data-id="{$post.id}">Delete<button>
                            </td>
                        </tr>
                        `;
                        });
                        $('#postTable').html(rows);

             }
        });
    }
    });

    </script>
@endsection
