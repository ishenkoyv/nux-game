import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

const toggleButton = document.getElementById('historyToggleButton');
const toggleBlock = document.getElementById('historyToggleBlock');

toggleButton.addEventListener('click', () => {
    toggleBlock.classList.toggle('hidden');
});
