<!-- resources/views/components/chat/user-list.blade.php -->

<div>
    <h2 class="text-xl font-bold mb-4">Usuários</h2>
    <ul>
        @foreach ($users as $user)
            <li wire:click="selectUser({{ $user->id }})"
                class="p-2 mb-1 rounded cursor-pointer transition duration-200 
                    {{ $selectedUser && $selectedUser->id === $user->id ? 'bg-blue-200' : 'hover:bg-gray-300' }}">
                {{ $user->name }}
            </li>
        @endforeach
    </ul>
</div>
