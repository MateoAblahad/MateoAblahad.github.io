//einde spel message opties.

const params = new URLSearchParams(window.location.search); 
let message;
if (params.has("computer")) {
    if (params.has("winner")) {
        message = "Game over! The computer won the game with 10 points." +  " Game Finished! Redirecting to the Start page...";
    } else {
        message = "Congratulations! The computer lost the game with -10 points. You win!" +  " Game Finished! Redirecting to the Start page...";
    }
} else {
    if (params.has("winner")) {
        message = "Congratulations! You won the game with 10 points!" +  " Game Finished! Redirecting to the Start page...";
    } else {
        message = "Game over! You lost the game with -10 points." + " Game Finished! Redirecting to the Start page...";
    }
}

document.querySelector("[data-message]").textContent = message;

setTimeout(function () {
    window.location.href = "index.html";
}, 10000);