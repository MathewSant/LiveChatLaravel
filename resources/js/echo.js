import Echo from 'laravel-echo';

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_REVERB_APP_KEY, // ou a chave que estiver utilizando
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER || 'mt1', // defina um valor padrão se não estiver configurado
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT,
    forceTLS: false,
    disableStats: true,
});

console.log(window.Echo);