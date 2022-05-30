@extends('layouts.dashboard')
@section('title')Dashboard | Posts @endsection('title')
@section('content')
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                @if (Auth::user()->hasRole('user'))
                    Manage your posts
                @else
                    Manage all posts
                @endif
            </h2>
        </div>
    </header>
<div class="py-4">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @include('includes.messages')
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
            @if (Auth::user()->hasRole('user'))
                <div class="flex justify-between">
                    <div class="text-left">
                        <a href="{{ route('posts.create') }}">
                            <button class="bg-blue-500 mb-6 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                New post
                            </button>
                        </a>
                    </div>
                </div>
            @endif
            @if(Auth::user()->hasRole('user') || Auth::user()->hasRole('admin'))
                @if($posts)
                    <table class="table-fixed w-full">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 tracking-wider">№</th>
                                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 tracking-wider">Date</th>
                                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 tracking-wider">Title</th>
                                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 tracking-wider">Category</th>
                                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 tracking-wider">Subcategory</th>
                                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 tracking-wider">Description</th>
                                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 tracking-wider">Public post</th>
                                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 tracking-wider">Actions</th>
                            </tr>
                        </thead>
                    <tbody>
                        @foreach($posts as $post)
                            <tr class="trix-content">
                                <td class="px-6 py-4 border-b border-gray-300 text-sm leading-5">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 border-b border-gray-300 text-sm leading-5">{{ Date::parse($post->created_at)->format('j F Y') }}</td>
                                <td class="px-6 py-4 border-b border-gray-300 text-sm leading-5">
                                    <a href="{{ route('posts.show', $post->id) }}" class="underline">{{ $post->title }}</a>
                                </td>
                                <td class="px-6 py-4 border-b border-gray-300 text-sm leading-5">{{ str_replace("App\\Models\\", "", $post->postable_type) }}</td>
                                <td class="px-6 py-4 border-b border-gray-300 text-sm leading-5">{{ $post->postable->name }}</td>
                                <td class="px-6 py-4 border-b border-gray-300 text-sm leading-5">{{ substr($post->description, 0, 100) }}...</td>
                                <td class="px-6 py-4 border-b border-gray-300 text-sm leading-5">
                                    <input
                                        name="visability"
                                        class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer"
                                        type="checkbox"
                                        data-toggle="toggle"
                                        id="flexCheckDefault"
                                        value="{{ $post->id }}"
                                        {{ $post->visability == '1' ? 'checked' : '' }}
                                        >
                                </td>
                                <td class="px-6 py-4 border-b border-gray-300 text-sm leading-5">
                                    @if (Auth::user()->hasRole('user'))
                                        <button class="mb-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                            <a href="{{ route('posts.edit', $post->id) }}">
                                                Edit
                                            </a>
                                        </button>
                                    @endif

                                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="submit" value="Delete" class="bg-red-500 hover:bg-red-700
                                            text-white font-bold py-2 px-4 rounded cursor-pointer">
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $posts->links() }}
                </div>
                @else
                    <p>There is no post here:(</p>
                @endif
            @endif
        </div>
    </div>
</div>

<script>
    $('input[name=visability]').change(function () {
        var mode=$(this).prop('checked');
        var id=$(this).val();
        $.ajax({
            url: "{{ route('posts.visability') }}",
            type: "POST",
            data: {
                _token: '{{ csrf_token() }}',
                mode: mode,
                id: id
            },
            success: function (response) {
                if(response.status == 200) {
                    Swal.fire({
                    icon: 'success',
                    title: 'Ok',
                    text: 'Post visability successfully saved!'
                    })
                }
                else {
                    Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!'
                    })
                }
            }
        })
    });
</script>

@endsection
