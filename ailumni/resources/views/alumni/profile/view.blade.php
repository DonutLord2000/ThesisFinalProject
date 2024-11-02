@extends('layouts.alumni')

@section('content')
<div class="max-w-7xl mx-auto py-10 ">  
    <div class="bg-white shadow-md rounded-lg p-6 mx-auto" style="width: 40rem;">
        <div class="flex flex-col items-center mb-4">
            <img src="{{ $alumni->profile_photo_url }}" alt="{{ $alumni->name }}" style="width: 200px; height: 200px;" class="rounded-full mb-2"> <!-- Using style instead of class -->
            <h2 class="text-xl font-bold">{{ $alumni->name }}</h2>
            <p class="text-gray-700" style="font-size: 15px; margin-bottom: 25px;"> {{ $alumni->bio }}</p>
        </div>

        <div class="mb-4">
            <h3 class="text-lg font-semibold">Email:</h3>
            <p class="text-gray-700">{{ $alumni->email }}</p>
        </div>

        <div class="mb-4">
            <h3 class="text-lg font-semibold">Contact Info:</h3>
            <p class="text-gray-700">{{ $alumni->contact_info }}</p>
        </div>

        <div class="mb-4">
            <h3 class="text-lg font-semibold">Jobs:</h3>
            <p class="text-gray-700">{{ $alumni->jobs }}</p>
        </div>

        <div class="mb-4">
            <h3 class="text-lg font-semibold">Achievements:</h3>
            <div>
                @foreach (explode("\n", $alumni->achievements) as $achievement)
                    <div class="p-2" style="background-color: #7dc7f0; border-radius: 5px; margin: 5px 0; display: inline-block;">
                        {{ trim($achievement) }}
                    </div>
                @endforeach
            </div>
        </div>
        
    </div>

    <div class="mt-6 text-center">
        <a href="{{ route('alumni.profile.index') }}" class="text-blue-500 hover:underline">Back to Alumni List</a>
    </div>
</div>
@endsection
