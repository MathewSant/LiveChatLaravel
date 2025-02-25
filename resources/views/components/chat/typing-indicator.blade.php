<div x-data="chatTyping('{{ $currentUser }}')" class="px-4 py-2 text-gray-600">
    <template x-if="isTyping">
        <p class="text-gray-600 text-sm flex items-center">
            <span x-text="typingUsersText"></span>
            <span class="typing-dots ml-2">
                <span class="dot"></span>
                <span class="dot"></span>
                <span class="dot"></span>
            </span>
        </p>
    </template>
</div>
<style>
    .typing-dots {
    display: inline-flex;
}

.dot {
    width: 6px;
    height: 6px;
    background-color: currentColor;
    border-radius: 50%;
    margin: 0 2px;
    animation: blink 1.4s infinite both;
}

.dot:nth-child(2) {
    animation-delay: 0.2s;
}

.dot:nth-child(3) {
    animation-delay: 0.4s;
}

@keyframes blink {
    0%, 80%, 100% {
        opacity: 0;
    }
    40% {
        opacity: 1;
    }
}

</style>