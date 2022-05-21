@extends('layouts.dashboard')
@section('title')Blog | {{ $post->title }} @endsection('title')
@section('content')
@if(Auth::user()->hasRole('user') || Auth::user()->hasRole('admin'))
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Show post
            </h2>
        </div>
    </header>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <div class="mb-4">
                    <div class="ml-4 text-lg leading-7 font-semibold">
                        @if ($post->visability == 1)
                            <p class="text-sm">*Public post</p>
                        @else
                            <p class="text-sm">*Post only for logged in users</p>
                        @endif

                        <p class="text-xl text-gray-800">
                            {{ $post->title }}
                        </p>
                        <p class="text-sm">{{ Date::parse($post->created_at)->format('j F Y') }}</p>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="" class="block text-gray-700 text-sm font-bold mb-2">
                        {{ $post->description }}
                    </label>
                </div>
            </div>
        </div>
    </div>
@endif    
@endsection
