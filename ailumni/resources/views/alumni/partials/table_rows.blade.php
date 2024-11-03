@foreach ($alumni as $alum)
    <tr>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
            <img src="{{ $alum->profile_photo_url }}" alt="Profile Photo" class="w-10 h-10 rounded-full mr-4">
            {{ $alum->name }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $alum->email }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $alum->contact_info }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $alum->jobs }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
            @foreach(explode("\n", $alum->achievements) as $achievement)
                <div class="text-blue-800 px-2 py-1 rounded mb-2" style="background-color: #7dc7f0;">
                    {{ $achievement }}
                </div>
            @endforeach
        </td>                                                                            
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $alum->bio }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
            <a href="{{ route('alumni.profile.view', $alum->name) }}" class="text-indigo-600 hover:text-indigo-900 mb-2 mr-2">View</a>
        </td>
    </tr>
@endforeach
