<div x-data="chatTyping('{{ $currentUser }}')" class="px-4 py-2 text-gray-600">
    <template x-if="isTyping">
        <p class="text-gray-600 text-sm">
            <span x-text="typingUsersText"></span> está digitando...
        </p>
    </template>
</div>