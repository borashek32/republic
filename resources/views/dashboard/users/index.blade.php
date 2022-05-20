@extends('layouts.dashboard')
@section('title')Blog | Users @endsection('title')
@section('content')
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Manage users
            </h2>
        </div>
    </header>
<div class="py-4">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @include('includes.messages')
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
            @if($users)
                <table class="table-fixed w-full">
                <thead>
                <tr class="bg-gray-100">
                    {{-- <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 tracking-wider">№</th> --}}
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 tracking-wider">Date</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 tracking-wider">Name</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 tracking-wider">Email</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 tracking-wider">Photo</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 tracking-wider">Update photo</th>
                </tr>
                </thead>
                <tbody>  
                @foreach($users as $user)
                    <tr class="trix-content">
                        {{-- <td class="px-6 py-4 border-b border-gray-300 text-sm leading-5">{{ $loop->iteration }}</td> --}}
                        <td class="px-6 py-4 border-b border-gray-300 text-sm leading-5">{{ Date::parse($user->created_at)->format('j F Y') }}</td>
                        <td class="px-6 py-4 border-b border-gray-300 text-sm leading-5">{{ $user->name }}</td>
                        <td class="px-6 py-4 border-b border-gray-300 text-sm leading-5">{{ $user->email }}</td>
                        <td class="px-6 py-4 border-b border-gray-300 text-sm leading-5">
                            <img src="{{ asset('storage/' . $user->profile_photo_path) }}"
                                alt="Profile photo"
                                width="100px"
                                class="rounded-md"
                                >
                        </td>        
                        <td class="px-6 py-4 border-b border-gray-300 text-sm leading-5">
                            <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <x-jet-input type="file" placeholder="Photo" name="photo" />

                                <x-jet-secondary-button class="mt-2" type="submit">Update</x-jet-secondary-button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @else
                <p>There is no user here:(</p>
            @endif
        </div>
    </div>
</div>
@endsection
