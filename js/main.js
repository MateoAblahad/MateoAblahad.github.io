const canvas = document.querySelector("#binaryCanvas");
const ctx = canvas.getContext("2d");

canvas.width = window.innerWidth;
canvas.height = window.innerHeight;

const fontSize = 16;
const columns = Math.floor(canvas.width / fontSize);
const drops = Array(columns).fill(0);

// Convert "HELLO WORLD" to binary size (8-bit ASCII)
const message = "HELLO WORLD";
const binaryMessage = message.split("")
    .map(char => char.charCodeAt(0).toString(2).padStart(8, "0")) // Convert each letter to binary size (8-bit)
    .join(""); // Remove spaces for a repeating binary stream

const binaryChars = binaryMessage.split(""); // Create an array of binary digits

function draw() {
    // Maintains the fading effect 
    ctx.fillStyle = "rgba(181, 181, 181, 0.05)"; // Light gray fade effect
    ctx.fillRect(0, 0, canvas.width, canvas.height);

    //color and font code
    ctx.fillStyle = "rgb(144, 238, 144)";
    ctx.font = `${fontSize}px 'MADE Gentle', monospace`;

    for (let i = 0; i < columns; i++) {
        // binary message  repeat pattern code
        const char = binaryChars[i % binaryChars.length];

        ctx.fillText(char, i * fontSize, drops[i] * fontSize);

        // Reset column drop when binary effect  reaches the bottom of the screen
        if (drops[i] * fontSize > canvas.height && Math.random() > 0.975) {
            drops[i] = 0;
        }

        drops[i]++;
    }
}

// Repeat animation every 20ms
setInterval(draw, 20);

// Update canvas size for all version
window.addEventListener("resize", () => {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
});