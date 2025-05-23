const rulesButton = document.querySelector('.rules-button');
const rulesPanel = document.querySelector('.rules-panel');
const modeButtons = document.querySelectorAll('.mode-button');

rulesButton.addEventListener('click', function () {
    if (rulesPanel.style.display === 'block') {
        rulesPanel.style.display = 'none';
    } else {
        rulesPanel.style.display = 'block';
    }
});

modeButtons.forEach(button => {
    button.addEventListener('click', function () {
        const mode = button.getAttribute('data-mode');
        window.location.href = mode; // stuurt u naar de juiste niveau
    });
});