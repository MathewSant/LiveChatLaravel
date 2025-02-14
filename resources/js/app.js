import './bootstrap';

import Alpine from 'alpinejs';
import './emojiPicker';
import './components/chat'; // Adicione esta linha
import { chatTyping } from './components/chat-typing';

window.Alpine = Alpine;
window.chatTyping = chatTyping;

Alpine.start();
