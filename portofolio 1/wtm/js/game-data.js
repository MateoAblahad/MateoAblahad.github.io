const cursor = document.querySelector('.cursor'); //hamer
const scoreEl = document.querySelector('.score span'); //score aantoning
const sound = new Audio('sounds/hammer-smash.mp3'); //hamer raak geluid
const audioContext = new (window.AudioContext || window.webkitAudioContext)(); //webkit is voor dat de audio werkt voor saffari 
let MODE = getmode(); // roept game niveau aan 
let holes = [...document.querySelectorAll('.hole')]; //hole array die alle hollen in een keer oproept 
let score = 0;
let lives = 5;
let speed = getSpeed(); //standard snelheid
let conditionX = true; //holes conditie 1
let conditionY = true; //holes conditie 2
let conditionZ = true; //holes conditie 3

function getmode() {
    const urlParams = new URLSearchParams(window.location.search); // haalt de query parameter op uit de url. Bijvoorbeeld ?mode=baby of ?mode=pro
    const gameMode = urlParams.get('mode');

    if (gameMode === "baby") {
        document.title = 'Wack The Mole Game (baby-mode)';
        return 0;
    } else if (gameMode === "normal") {
        document.title = 'Wack The Mole Game (normal-mode)';
        return 1;
    } else {
        document.title = 'Wack The Mole Game (pro-mode)';
        return 2;
    }
}

function getSpeed() { //haalt op basis van keuze van niveau de juiste basis snelheid op.
    if (MODE === 0) {
        return 4000;
    } else if (MODE === 1) {
        return 2500;
    } else {
        return 2000;
    }
}

function getGoldenMoleChance() {  //haalt op basis van keuze van niveau de juiste goude mol % op.
    if (MODE === 0) {
        return 0.25;
    } else if (MODE === 1) {
        return 0.15;
    } else {
        return 0.05;
    }
}

function getEndPage() { //haalt op basis van keuze van niveau de juiste end bestand op.
    if (MODE === 0) {
        return "end.html?mode=baby";
    } else if (MODE === 1) {
        return "end.html?mode=normal";
    } else {
        return "end.html?mode=pro";
    }
}

function updateSpeedAndHoles() {
    if (MODE === 0) {
        if (score >= 7500) {
            speed = 2000;

            if (conditionZ) {
                increaseHoles(4);  // van 12  naar 16 holes
                conditionZ = false;
            }
        } else if (score >= 5000) {
            speed = 2500;

            if (conditionY == true) {
                increaseHoles(3);  //van 9 naar 12 holes
                conditionY = false;
            }
        } else if (score >= 2500) {
            speed = 3000;
            if (conditionX == true) {
                increaseHoles(5);  // van 4  naar 9 holes
                conditionX = false;
            }
        }
    } else if (MODE === 1) {
        if (score >= 7500) {
            speed = 1000;

            if (conditionZ) {
                increaseHoles(4);  // van 12  naar 16 holes
                conditionZ = false;
            }
        } else if (score >= 5000) {
            speed = 1500;

            if (conditionY == true) {
                increaseHoles(3);  //van 9 naar 12 holes
                conditionY = false;
            }
        } else if (score >= 2500) {
            speed = 2000;
            if (conditionX == true) {
                increaseHoles(5);  // van 4  naar 9 holes
                conditionX = false;
            }
        }
    } else {
        if (score >= 7500) {
            speed = 750;

            if (conditionZ) {
                increaseHoles(4);  // van 12  naar 16 holes
                conditionZ = false;
            }
        } else if (score >= 5000) {
            speed = 1000;

            if (conditionY == true) {
                increaseHoles(3);  //van 9 naar 12 holes
                conditionY = false;
            }
        } else if (score >= 2500) {
            speed = 1500;
            if (conditionX == true) {
                increaseHoles(5);  // van 4  naar 9 holes
                conditionX = false;
            }
        }
    }
}

function increaseHoles(num) {
    const board = document.querySelector('.board');
    for (let x = 0; x < num; x++) {
        let hole = document.createElement('div');
        hole.classList.add('hole'); // voegt "hole" class naar een nieuwe div
        board.appendChild(hole);
    }

    holes = [...document.querySelectorAll('.hole')]; //maakt holes automatisch groter.

    const gridSize = Math.ceil(Math.sqrt(holes.length)); //past grid aan als de holes meer worden.
    board.style.gridTemplateColumns = `repeat(${gridSize}, 1fr)`;
    board.style.gridTemplateRows = `repeat(${gridSize}, 1fr)`;
}

function setBoardBackground() { //haalt juiste board voor juiste niveau op
    const board = document.querySelector('.board');

    if (MODE === 0) { // Baby mode
        board.style.backgroundImage = "url('img/baby-board.avif')";
    } else if (MODE === 1) { // Normal mode
        board.style.backgroundImage = "url('img/normal-board.jpg')";
    } else { // Pro mode
        board.style.backgroundImage = "url('img/hell-board.webp')";
    }

    board.style.backgroundSize = "cover"; //zorgt er samen met board.style.backgroundPosition = "center"; voor dat board img goed er in staat
    board.style.backgroundPosition = "center";
}

setBoardBackground();

let backgroundMusic;
let musicSource;

function playBackgroundMusic() {
    if (!backgroundMusic) { // Checkt of het background muziek aan staat.
        if (MODE === 0) { // Baby mode
            backgroundMusic = new Audio('sounds/baby-background-music.mp3');
        } else if (MODE === 1) { // Normal mode
            backgroundMusic = new Audio('sounds/normal-background-music.mp3');
        } else { // Pro mode
            backgroundMusic = new Audio('sounds/pro-background-music.mp3');
        }
        backgroundMusic.loop = true; // activeerd bgm loop
        musicSource = audioContext.createMediaElementSource(backgroundMusic);
        const gainNode = audioContext.createGain();

        if (MODE === 1) { //maakt normalmode luid.
            gainNode.gain.value = 4; // 4X harder volume
        } else {
            gainNode.gain.value = 1; // baby en promode zijn dan niet veranderd van volume want 1 staat voor standard volume
        }

        musicSource.connect(gainNode);
        gainNode.connect(audioContext.destination);

        musicSource.connect(audioContext.destination);
    }

    backgroundMusic.play().catch((error) => {
        console.error('Error playing background music:', error);
    });
}


// Stopt background music als game eindigt
function stopBackgroundMusic() {
    if (backgroundMusic) {
        backgroundMusic.pause();
        backgroundMusic.currentTime = 0; // Reset music
    }
}

playBackgroundMusic();// roept background muziek functie op

function run() {
    updateSpeedAndHoles();

    const i = Math.floor(Math.random() * holes.length); //mathrandom-floor voor afronding van holes
    const hole = holes[i];
    let timer = null;

    const img = document.createElement('img');
    img.classList.add('mole');
    img.draggable = false; // anti hammer glitch
    let moleHammered = false;

    // mole img gebasseerd op niveau
    let isGoldenMole = false;
    if (MODE === 0) { // Baby Mode
        if (Math.random() < getGoldenMoleChance()) { // % kans op golden mole
            isGoldenMole = true;
            img.src = 'img/golden-mole.png'; // Gouden mole image
        } else {
            img.src = 'img/mole.png'; // Normal mole img
        }
    } else if (MODE === 1) { // Normal Mode
        if (Math.random() < getGoldenMoleChance()) {  //kans op gouden zombie
            isGoldenMole = true;
            img.src = 'img/golden-zombie.png'; // Gouden zombie img
        } else {
            img.src = 'img/zombie.png'; // Normal zombie img
        }
    } else { // Pro Mode
        if (Math.random() < getGoldenMoleChance()) { // % kans op gouden demon
            isGoldenMole = true;
            img.src = 'img/golden-demon.png'; // gouden demon img
        } else {
            img.src = 'img/demon.png'; // Normal demon img
        }
    }

    // Select hammer gebasseerd op niveau
    if (MODE === 0) { // Baby mode hammer
        cursor.style.backgroundImage = "url('img/hammer.png')";
        cursor.style.width = "100px";
        cursor.style.height = "100px";
    } else if (MODE === 1) { // Normal mode hammer
        cursor.style.backgroundImage = "url('img/mine-hammer.png')";
        cursor.style.width = "100px";
        cursor.style.height = "150px";
    } else { // Pro mode hammer
        cursor.style.backgroundImage = "url('img/holy-smite-hammer.png')";
        cursor.style.width = "100px";
        cursor.style.height = "150px";
    }
    document.body.style.cursor = 'none'; //maakt standard cursor ontzichbaar

    // Select sound gebasseerd op niveau
    let moleHitSound;
    if (MODE === 0) { // Baby mode
        moleHitSound = new Audio('sounds/hammer-smash.mp3');
    } else if (MODE === 1) { // Normal mode
        moleHitSound = new Audio('sounds/ouch-zombie.mp3');
    } else { // Pro mode
        moleHitSound = new Audio('sounds/demon-scream.mp3');
    }

    const muteButton = document.createElement('button');
    muteButton.textContent = '🔊'; // on icon
    muteButton.classList.add('mute-button'); // class for mute button
    document.body.appendChild(muteButton);

    muteButton.addEventListener('click', () => {
        if (backgroundMusic) {
            if (backgroundMusic.muted) {
                backgroundMusic.muted = false;
                muteButton.textContent = '🔊'; // Sound aan
                muteButton.classList.remove('muted'); // Remove muted style
            } else {
                backgroundMusic.muted = true;
                muteButton.textContent = '🔇'; // Sound uit
                muteButton.classList.add('muted'); // voeg muted style
            }
        }
    });


    const soundSource = audioContext.createMediaElementSource(moleHitSound);// volledig control voor audio
    soundSource.connect(audioContext.destination);

    if (lives <= 0 || score >= 10000) {
        return endGame(score, lives); // Win conditie als score gelijk is aan 10000 of meer, anders lose condition
    }

    img.addEventListener('click', () => {
        if (moleHammered)
            return;

        moleHammered = true;

        if (isGoldenMole) { //if else voor gouden varianten van de mollen
            score += 500; //punten optelling
            if (MODE === 0) { // Baby mode
                img.src = 'img/wacked-golden-mole.png';
            } else if (MODE === 1) { // Normal mode
                img.src = 'img/wacked-golden-zombie.png';
            } else { // Pro mode
                img.src = 'img/wacked-golden-demon.png';
            }
        } else {
            score += 100; //punten optelling
            if (MODE === 0) { // Baby mode
                img.src = 'img/wacked-mole.png';
            } else if (MODE === 1) { // Normal mode
                img.src = 'img/wacked-zombie.png';
            } else { // Pro mode
                img.src = 'img/wacked-demon.png';
            }
        }
        moleHitSound.play(); // speelt sla sound gebasseerd op niveau
        scoreEl.textContent = score;
        clearTimeout(timer);
        setTimeout(() => {
            hole.removeChild(img); //haalt mol weg
            run();
        }, 500); //mol verschijn timer. 
    });

    hole.appendChild(img);

    timer = setTimeout(() => {
        hole.removeChild(img);
        removeLive();
        run();
    }, speed);
}

function removeLive() {
    lives--;
    const liveElm = document.querySelector(".lives");

    let tekst = ""; //  lege string
    for (let live = 0; live < lives; live++) {
        tekst += "❤️"; //leven
    }

    liveElm.innerHTML = tekst; //roept levens in innerhtml op
}

function endGame(score, lives) {
    window.location.assign(`${getEndPage()}&score=${score}&lives=${lives}`); //haalt game einde gegevens op en stuurt ze naar eind pagina.
}

run();

window.addEventListener('mousemove', (e) => { //hamer beweegt
    cursor.style.top = e.pageY + 'px';
    cursor.style.left = e.pageX + 'px';
});

window.addEventListener('mousedown', () => { //hamer slaat
    cursor.classList.add('active');
});

window.addEventListener('mouseup', () => {  //hamer gaat weer naar boven
    cursor.classList.remove('active');
});