@extends('layouts.dashboard')
@section('title')Dashboard | Posts @endsection('title')
@section('content')
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                @if (Auth::user()->hasRole('user'))
                    Manage your categories
                @else
                    Manage all categories
                @endif
            </h2>
        </div>
    </header>
<div class="py-4">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @include('includes.messages')
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
            @if(Auth::user()->hasRole('user') || Auth::user()->hasRole('admin'))
                <table class="table-fixed w-full">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 tracking-wider">№</th>
                            <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 tracking-wider">Title</th>
                            <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 tracking-wider">Subcategories</th>
                            <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="">
                            <td class="px-6 py-4 border-b border-gray-300 text-sm leading-5">1</td>
                            <td class="px-6 py-4 border-b border-gray-300 text-sm leading-5">
                                Flowers
                            </td>

                            <td class="px-6 py-4 border-b border-gray-300 text-sm leading-5">
                                @foreach(Auth::user()->flowers as $flower)
                                    <table>
                                        <tr>
                                            <td>{{ $flower->name }}</td>

                                            <td>
                                                <form action="{{ route('flowers.edit', $flower->id) }}" class="ml-2 cursor-pointer" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <i class="fas fa-edit"></i>
                                                </form>
                                            </td>
                                            <td>
                                                <form action="{{ route('flowers.destroy', $flower->id) }}" class="cursor-pointer" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <i class="fas fa-backspace"></i>
                                                </form>
                                            </td>
                                        </tr>
                                    </table>
                                    <br>

                                    @if(Post::whereHasMorph('postable_type', Flower::class))
                                        <p class="ml-2 text-xs text-gray-400" style="margin-top:-20px;">
                                            Posts:
                                        </p>
                                    @endif

                                    <p class="ml-6">
                                        @foreach($flower->posts as $post)
                                            <a href="{{ route('posts.show', $post->id) }}">
                                                {{ $post->title }}<br>
                                            </a>
                                        @endforeach
                                    </p>
                                @endforeach
                            </td>

                            <td class="px-6 py-4 border-b border-gray-300 text-sm leading-5">
                                @if (Auth::user()->hasRole('user'))
                                    <button class="mb-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        <a href="{{ route('flowers.create') }}">
                                            Add subcategory
                                        </a>
                                    </button>
                                @endif
                            </td>
                        </tr>

                        <tr class="">
                            <td class="px-6 py-4 border-b border-gray-300 text-sm leading-5">2</td>
                            <td class="px-6 py-4 border-b border-gray-300 text-sm leading-5">
                                Trees
                            </td>

                            <td class="px-6 py-4 border-b border-gray-300 text-sm leading-5">
                                @foreach(Auth::user()->trees as $tree)
                                    <table>
                                        <tr>
                                            <td>{{ $tree->name }}</td>

                                            <td>
                                                <form action="{{ route('flowers.edit', $tree->id) }}" class="ml-2 cursor-pointer" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <i class="fas fa-edit"></i>
                                                </form>
                                            </td>
                                            <td>
                                                <form action="{{ route('flowers.destroy', $tree->id) }}" class="cursor-pointer" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <i class="fas fa-backspace"></i>
                                                </form>
                                            </td>
                                        </tr>
                                    </table>
                                    <br>

                                    @if($tree->posts)
                                        <p class="ml-2 text-xs text-gray-400" style="margin-top:-20px;">
                                            Posts:
                                        </p>
                                    @endif

                                    <p class="ml-6">
                                        @foreach($tree->posts as $post)
                                            <a href="{{ route('posts.show', $post->id) }}">
                                                {{ $post->title }}<br>
                                            </a>
                                        @endforeach
                                    </p>
                                @endforeach
                            </td>

                            <td class="px-6 py-4 border-b border-gray-300 text-sm leading-5">
                                @if (Auth::user()->hasRole('user'))
                                    <button class="mb-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        <a href="{{ route('trees.create') }}">
                                            Add subcategory
                                        </a>
                                    </button>
                                @endif
                            </td>
                        </tr>

                        <tr class="">
                            <td class="px-6 py-4 border-b border-gray-300 text-sm leading-5">3</td>
                            <td class="px-6 py-4 border-b border-gray-300 text-sm leading-5">
                                Grasses
                            </td>

                            <td class="px-6 py-4 border-b border-gray-300 text-sm leading-5">
                                @foreach(Auth::user()->grasses as $grass)
                                    <table>
                                        <tr>
                                            <td>{{ $grass->name }}</td>

                                            <td>
                                                <form action="{{ route('grasses.edit', $grass->id) }}" class="ml-2 cursor-pointer" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <i class="fas fa-edit"></i>
                                                </form>
                                            </td>
                                            <td>
                                                <form action="{{ route('grasses.destroy', $grass->id) }}" class="cursor-pointer" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <i class="fas fa-backspace"></i>
                                                </form>
                                            </td>
                                        </tr>
                                    </table>
                                    <br>

                                    @if($grass->posts)
                                        <p class="ml-2 text-xs text-gray-400" style="margin-top:-20px;">
                                            Posts:
                                        </p>
                                    @endif

                                    <p class="ml-6">
                                        @foreach($grass->posts as $post)
                                            <a href="{{ route('posts.show', $post->id) }}">
                                                {{ $post->title }}<br>
                                            </a>
                                        @endforeach
                                    </p>
                                @endforeach
                            </td>

                            <td class="px-6 py-4 border-b border-gray-300 text-sm leading-5">
                                @if (Auth::user()->hasRole('user'))
                                    <button class="mb-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        <a href="{{ route('grasses.create') }}">
                                            Add subcategory
                                        </a>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection
