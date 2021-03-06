@extends('layouts.site')
@section('title')Blog | Posts @endsection('title')
@section('content')
@foreach ($posts as $post)
    <div class="mt-8 bg-white overflow-hidden shadow sm:rounded-lg">
        <div class="">
            <div class="p-6">
                <div class="flex items-center">
                    <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-500"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>

                    <div class="ml-4 text-lg leading-7 font-semibold">
                        @if ($post->visability == 1)
                            <p class="text-sm">*Public post</p>
                        @else
                            <p class="text-sm">*Post only for logged in users</p>
                        @endif

                        {{ $loop->iteration }}.
                        <a href="{{ route('onePost', $post) }}" class="underline text-gray-800">
                            {{ $post->title }}
                        </a>
                        , {{ Date::parse($post->created_at)->format('j F Y') }}
                    </div>
                </div>

                <div class="ml-12">
                    <div class="mt-2 text-gray-900 text-sm">
                        {{ Str::substr($post->description, 0, 100) }}...
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
<div class="bg-grey-100 mt-4 px-4 py-3 flex items-center justify-center border-t border-grey-200 sm:px-6">
    <div class="flex-1 mt-2 text-md flex justify-between sm:hidden bd-grey-100">
      {{ $posts->links() }}
    </div>
</div>
@endsection
