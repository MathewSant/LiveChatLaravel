import Pusher from 'pusher-js';
window.Pusher = Pusher;

import axios from 'axios';
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Se você já importa o Echo depois, certifique-se de que o window.Pusher já esteja definido.
import './echo';
