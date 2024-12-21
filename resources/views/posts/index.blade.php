<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('All Posts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @foreach ($posts as $post)
                        <h3>{{ $post->title }}</h3>
                        <p>{{ $post->body }}</p>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
