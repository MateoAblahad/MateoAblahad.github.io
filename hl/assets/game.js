let isGameStarted = false;
let playerName = "Player";
let computerName = "Computer";
let showAlerts = false; //haalt extra alarts weg voor mooier spel.

//params gebruikt voor speler naam.
const params = new URLSearchParams(window.location.search);
if (params.has("name") && params.get("name") !== "") playerName = params.get("name");
if (params.has("alert")) showAlerts = true;

//ronde begin.
const game = {
    player: { dice: [0, 0], points: 0, guess: null },
    computer: { dice: [0, 0], points: 0, guess: null },
    round: 1
};

//rolldice mathfloor math random.
function rollDice() {
    return Math.floor(Math.random() * 6) + 1;
}

//start game + restart spel.
function startGame(element, gameElms) {
    gameElms.forEach(function (elm) {
        elm.disabled = false;
    });
    element.textContent = "Restart Game";
    game.player.points = 0;
    game.computer.points = 0;
    game.round = 1;
    isGameStarted = true;
    updateScore();
    updateMessage("Round " + game.round + ": Computer is rolling...");
    computerRoll();
}

//roll functie computer
function computerRoll() {
    game.computer.dice = [rollDice(), rollDice()];
    updateDiceImages('computer', game.computer.dice);
    const computerScore = game.computer.dice.reduce(function (a, b) {
        return a + b;
    }, 0);
    if (showAlerts) alert("Computer rolled a total of " + computerScore + ".");
    computerGuess();
    updateMessage("Round " + game.round + ": Make your guess!");
}

//raad opties.
function computerGuess() {
    // Computer  random raad.
    const guesses = ["higher", "lower"];
    game.computer.guess = guesses[Math.floor(Math.random() * guesses.length)];
    document.querySelector("[data-computer-guess]").textContent = "Guessing: " + game.computer.guess.toUpperCase();
}

function updateDiceImages(playerType, diceValues) {
    document.querySelectorAll("[data-dice='" + playerType + "']").forEach(function (element, index) {
        element.src = "assets/img/dice/" + diceValues[index] + ".jpg";
    });
}
//raad functie voor speler met secondes progameering voor betere beurt snelheid tussen cppmputer en speler met messages.
function playerChoice(guess) {
    if (!isGameStarted) return;

    document.querySelectorAll("[data-game]").forEach(function (elm) {
        elm.disabled = true;
    });

    game.player.guess = guess;
    updateMessage("You guessed " + guess.toUpperCase() + ". Rolling your dice...");
    setTimeout(function () {
        playerRoll();
        const playerScore = game.player.dice.reduce(function (a, b) {
            return a + b;
        }, 0);
        if (showAlerts) alert("You rolled a total of " + playerScore + ".");
        evaluateRound();
        setTimeout(function () {
            updateScore();
            checkGameEnd();
            if (isGameStarted) {
                game.round++;
                updateMessage("Round " + game.round + ": Computer is rolling...");
                setTimeout(computerRoll, 1000);
                setTimeout(() => {
                    document.querySelectorAll("[data-game]").forEach(elm => elm.disabled = false);
                }, 1500);
            }
        }, 2500);
    }, 1000);
}

//dubbelstenen verandering.
function playerRoll() {
    game.player.dice = [rollDice(), rollDice()];
    updateDiceImages('player', game.player.dice);
}

//ronde verandering.
function evaluateRound() {
    const playerScore = game.player.dice.reduce((a, b) => a + b, 0);
    const computerScore = game.computer.dice.reduce((a, b) => a + b, 0);
    let resultMessage = "";

    // speler raad  messages.
    if (playerScore === computerScore) {
        resultMessage += "It's a tie! Both scored " + playerScore + ". No points awarded.";
    } else if (
        (game.player.guess === 'higher' && playerScore > computerScore) ||
        (game.player.guess === 'lower' && playerScore < computerScore)
    ) {
        game.player.points++;
        resultMessage += "You were correct! Your score: " + playerScore + ", Computer's score: " + computerScore + ".";
    } else {
        game.player.points--;
        resultMessage += "You were incorrect. Your score: " + playerScore + ", Computer's score: " + computerScore + ".";
    }

    // raad messages.
    if (computerScore === playerScore) {
        resultMessage += " It's a tie for computer! No points awarded.";
    } else if (
        (game.computer.guess === 'higher' && computerScore > playerScore) ||
        (game.computer.guess === 'lower' && computerScore < playerScore)
    ) {
        game.computer.points++;
        resultMessage += " Computer was correct in guessing " + game.computer.guess.toUpperCase() + ".";
    } else {
        game.computer.points--;
        resultMessage += " Computer was incorrect in guessing " + game.computer.guess.toUpperCase() + ".";
    }

    if (showAlerts) alert(resultMessage);
    updateMessage(resultMessage);
}

//update score message.
function updateMessage(message) {
    document.querySelector('[data-message]').textContent = message;
}

//update de score van speler en computer.
function updateScore() {
    document.querySelector('[data-scoreboard]').textContent = playerName + ": " + game.player.points + " points | " + computerName + ": " + game.computer.points + " points";
}

//punten telling speler en computer met de messages als ze juist of fout scoren.
function checkGameEnd() {
    var result;

    if (game.player.points >= 10) {
        alert("Congratulations! You won the game with " + game.player.points + " points!");
        result = "winner=" + encodeURIComponent(playerName);
    } else if (game.computer.points >= 10) {
        alert("Game over! The computer won the game with " + game.computer.points + " points.");
        result = "computer&winner=" + encodeURIComponent(computerName);
    } else if (game.player.points <= -10) {
        alert("Game over! You lost the game with " + game.player.points + " points.");
        result = "loser=" + encodeURIComponent(playerName);
    } else if (game.computer.points <= -10) {
        alert("Congratulations! The computer lost the game with " + game.computer.points + " points. You win!");
        result = "computer&loser=" + encodeURIComponent(computerName);
    }

    if (result) {
        endGame();
        setTimeout(function () {
            window.location.href = "./end.html?" + result;
        }, 100);
    }
}


//heb het zo gedaan dat het echt lijkt dat de computer een persoon is met "waiting..." ook is hierdoor de start knopje niet meer aanwezig.
//nadat je er op clickt als het spel begint.
function endGame() {
    isGameStarted = false;
    document.querySelectorAll("[data-game]").forEach(elm => elm.disabled = true);
    document.querySelector("[data-game='start']").disabled = false;
    document.querySelector("[data-computer-guess]").textContent = "Waiting...";
}

//heb om het leuk te maken meerdere namen van de computer ingesteld. 
const computerNames = [
    "Gpt", "Mateo", "Software",
    "Mbo", "VsCode", "JavaScript",
    "Html", "Css", "Error",
    "Glitch"
];
computerName = computerNames[Math.floor(Math.random() * computerNames.length)];

document.querySelector("[data-name='player']").textContent = playerName;
document.querySelector("[data-name='computer']").textContent = computerName;


//start, hoger en lager knoppen. 
const gameElms = document.querySelectorAll("[data-game]");
gameElms.forEach(element => {
    const action = element.getAttribute("data-game");
    if (action === "start") {
        element.addEventListener("click", () => startGame(element, gameElms));
    } else if (action === "H") {
        element.addEventListener("click", () => playerChoice("higher"));
    } else if (action === "L") {
        element.addEventListener("click", () => playerChoice("lower"));
    }
});

