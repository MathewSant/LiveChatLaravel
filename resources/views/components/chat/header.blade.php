<div class="p-4 bg-blue-500 text-white flex items-center justify-between">
    <div>
        @if(isset($selectedUser))
            <div class="flex items-center">
                @if($selectedUser->profile_image)
                    <img src="{{ asset('storage/' . $selectedUser->profile_image) }}" alt="{{ $selectedUser->name }}" class="h-8 w-8 rounded-full object-cover mr-2">
                @else
                    @svg('fas-user', 'h-8 w-8 text-gray-200 mr-2')
                @endif
                <span class="text-lg font-bold">{{ $selectedUser->name }}</span>
            </div>
        @else
            <h1 class="text-lg font-bold">Chat Público</h1>
        @endif
    </div>
    <!-- Outras opções, se necessário -->
</div>
