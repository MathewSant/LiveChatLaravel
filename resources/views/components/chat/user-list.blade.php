<div>
    <h2 class="text-xl font-bold mb-4">Usuários</h2>
    <ul>
        @foreach ($users as $user)
            <li wire:click="selectUser({{ $user->id }})"
                class="flex items-center p-2 mb-1 rounded cursor-pointer transition duration-200 
                    {{ $selectedUser && $selectedUser->id === $user->id ? 'bg-blue-200' : 'hover:bg-gray-300' }}">
                @if ($user->profile_image)
                    <img src="{{ asset('storage/' . $user->profile_image) }}" alt="{{ $user->name }}" class="h-8 w-8 rounded-full mr-2 object-cover">
                @else
                    @svg('fas-user', 'h-8 w-8 text-gray-400 mr-2')
                @endif
                <span>{{ $user->name }}</span>
            </li>
        @endforeach
    </ul>
</div>
