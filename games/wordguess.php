<style>
    .word-container {
        display: flex;
        gap: 10px;
        justify-content: center;
        margin: 20px 0;
    }

    .letter-box {
        width: 40px;
        height: 40px;
        border: 2px solid var(--primary-color);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5em;
        color: var(--text-color);
        text-transform: uppercase;
    }

    .keyboard {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(40px, 1fr));
        gap: 5px;
        max-width: 500px;
        margin: 20px auto;
    }

    .key {
        padding: 10px;
        background: var(--bg-secondary);
        border: 1px solid var(--border-color);
        border-radius: 4px;
        cursor: pointer;
        color: var(--text-color);
    }

    .key.used {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .hangman {
        text-align: center;
        font-size: 2em;
        margin: 20px 0;
        color: var(--text-color);
    }
</style>

<h2 class="game-title">Word Guess</h2>

<div class="hangman">❤️ Lives: <span id="lives">6</span></div>

<div id="wordContainer" class="word-container"></div>

<div id="keyboard" class="keyboard"></div>

<div class="game-controls">
    <button class="btn-game" onclick="startGame()">New Game</button>
</div>

<script>
    const words = ['JAVASCRIPT', 'PYTHON', 'PROGRAMMING', 'COMPUTER', 'DEVELOPER', 'CODING'];
    let currentWord = '';
    let guessedLetters = new Set();
    let lives = 6;

    function startGame() {
        currentWord = words[Math.floor(Math.random() * words.length)];
        guessedLetters.clear();
        lives = 6;
        document.getElementById('lives').textContent = lives;
        createWordDisplay();
        createKeyboard();
    }

    function createWordDisplay() {
        const container = document.getElementById('wordContainer');
        container.innerHTML = '';
        
        for(let letter of currentWord) {
            const box = document.createElement('div');
            box.className = 'letter-box';
            box.textContent = guessedLetters.has(letter) ? letter : '';
            container.appendChild(box);
        }
    }

    function createKeyboard() {
        const keyboard = document.getElementById('keyboard');
        keyboard.innerHTML = '';
        
        for(let i = 65; i <= 90; i++) {
            const letter = String.fromCharCode(i);
            const key = document.createElement('button');
            key.className = 'key';
            key.textContent = letter;
            key.disabled = guessedLetters.has(letter);
            key.onclick = () => guessLetter(letter);
            keyboard.appendChild(key);
        }
    }

    function guessLetter(letter) {
        if (guessedLetters.has(letter)) return;
        
        guessedLetters.add(letter);
        
        if (!currentWord.includes(letter)) {
            lives--;
            document.getElementById('lives').textContent = lives;
            
            if (lives === 0) {
                alert('Game Over! The word was: ' + currentWord);
                startGame();
                return;
            }
        }
        
        createWordDisplay();
        createKeyboard();
        
        // Check win
        if ([...currentWord].every(letter => guessedLetters.has(letter))) {
            alert('Congratulations! You won!');
            startGame();
        }
    }

    // Start game initially
    startGame();
</script> 