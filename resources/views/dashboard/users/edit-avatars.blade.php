<td class="px-6 py-4 border-b border-gray-300 text-sm leading-5">
    <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf

        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4">
                <!-- Profile Photo File Input -->
                <div class="mt-10">
                    <input type="file" name="photo" placeholder="Choose photo" id="photo">

                    @error('photo')
                        <div class="mt-6 text-red-900">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        @endif

        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                <input type="submit" value="Update" class="inline-flex justify-center w-full
                rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium
                text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700
                focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5 cursor-pointer">
            </span>
        </div>
    </form>
</td>