export function chatTyping(currentUser) {
    return {
        typingUsers: {},
        cleanupInterval: null,

        init() {
            window.Echo.channel('chat')
                .listen('.UserTyping', (e) => {
                    if (e.name !== currentUser) {
                        this.typingUsers[e.name] = Date.now();
                    }
                })

                .listen('.UserStoppedTyping', (e) => {
                    if (e.name !== currentUser) {
                        delete this.typingUsers[e.name];
                    }
                });

            this.cleanupInterval = setInterval(() => {
                let now = Date.now();
                for (let user in this.typingUsers) {
                    if (now - this.typingUsers[user] > 2000) {
                        delete this.typingUsers[user];
                    }
                }
            }, 500);
        },

        destroy() {
            clearInterval(this.cleanupInterval);
        },

        get isTyping() {
            return Object.keys(this.typingUsers).length > 0;
        },
        get typingUsersText() {
            return Object.keys(this.typingUsers).join(', ');
        }
    }
}