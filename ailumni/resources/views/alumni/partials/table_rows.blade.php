@foreach ($alumni as $alum)
    <tr>
        <td class="px-6 py-4 text-sm text-gray-900">
            <div class="flex items-center">
                <img src="{{ $alum->profile_photo_url }}" alt="Profile Photo" class="w-10 h-10 rounded-full mr-4">
                <span>{{ $alum->name }}</span>
            </div>
        </td>
        <td class="px-6 py-4 text-sm text-gray-900">{{ $alum->email }}</td>
        <td class="px-6 py-4 text-sm text-gray-900">{{ $alum->contact_info }}</td>
        <td class="px-6 py-4 text-sm text-gray-900">{{ $alum->jobs }}</td>
        <td class="px-6 py-4 text-sm text-gray-900">
            <div class="max-h-32 overflow-y-auto">
                @foreach(explode("\n", $alum->achievements) as $achievement)
                    <div class="text-blue-800 px-2 py-1 rounded mb-2" style="background-color: #7dc7f0;">
                        {{ $achievement }}
                    </div>
                @endforeach
            </div>
        </td>                                                                            
        <td class="px-6 py-4 text-sm text-gray-900">
            <div class="max-h-32 overflow-y-auto">
                {{ $alum->bio }}
            </div>
        </td>
        <td class="px-6 py-4 text-sm font-medium">
            @if(auth()->user() && in_array(auth()->user()->role, ['student', 'alumni', 'admin']))
                <a href="{{ route('alumni.profile.view', $alum->name) }}" class="text-indigo-600 hover:text-indigo-900 mb-2 mr-2">View</a>
            @endif
        </td>
    </tr>
@endforeach