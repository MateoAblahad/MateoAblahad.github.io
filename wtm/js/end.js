document.addEventListener('DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);
    const score = parseInt(urlParams.get('score'), 10);
    const lives = parseInt(urlParams.get('lives'), 10);
    const mode = urlParams.get('mode');
    const h1 = document.querySelector('h1');
    const endPage = document.querySelector('.end-page'); // Target the correct element
    console.log(mode);

    function addGradientAndShadowAnimation(element, colors) {
        const style = document.createElement('style');
        style.textContent = `
            @keyframes borderAndShadowAnimation {
                0% { 
                    border-color: ${colors[0]}; 
                    box-shadow: 0px 0px 10px ${colors[0]};
                }
                50% { 
                    border-color: ${colors[1]}; 
                    box-shadow: 0px 0px 20px ${colors[1]};
                }
                100% { 
                    border-color: ${colors[0]}; 
                    box-shadow: 0px 0px 10px ${colors[0]};
                }
            }

            .end-page {
                border: 4px solid ${colors[0]}; /* Default border */
                animation: borderAndShadowAnimation 2s infinite; /* Animate border and shadow */
            }
        `;
        document.head.appendChild(style);
    }

    if (mode === 'baby') {
        addGradientAndShadowAnimation(endPage, ['rgb(121, 235, 255)', 'rgb(255, 192, 203)']);
        if (score >= 10000) {
            h1.textContent = `Congratulations! You won the game with ${score} points and ${lives} lives!`;
        } else if (lives < 1) {
            h1.textContent = `HOW DID YOU EVEN LOSE IN THIS MODE DID YOU HIT YOUR HEAD OR SOMETHING? You lost the game with ${score} points`;
        } else {
            h1.textContent = 'THIS IS ILLEGAL';
        }

    } else if (mode === 'normal') {
        addGradientAndShadowAnimation(endPage, ['rgb(1, 51, 10)', 'rgb(101, 67, 33)']);
        if (score >= 10000) {
            h1.textContent = `Congratulations! You won the game with ${score} points and ${lives} lives!`;
        } else if (lives < 1) {
            h1.textContent = `Game Over! You lost the game with ${score} points`;
        } else {
            h1.textContent = 'THIS IS ILLEGAL';
        }

    } else {
        addGradientAndShadowAnimation(endPage, ['rgb(255, 1, 1)', 'rgb(0, 0, 0)']);
        if (score >= 10000) {
            h1.textContent = `WOW! You actually won the game with ${score} points and ${lives} lives!`;
        } else if (lives < 1) {
            h1.textContent = `Game Over! You tried but still lost  the game with ${score} points (I'm proud of you!)`;
        } else {
            h1.textContent = 'THIS IS ILLEGAL';
        }
    }

    setTimeout(function () {
        window.location.href = "start.html";
    }, 10000);
});