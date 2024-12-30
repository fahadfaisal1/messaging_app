<h2 class="game-title">Memory Match</h2>

<div class="game-stats">
    <p>Moves: <span id="moves">0</span> | Pairs Found: <span id="pairs">0</span></p>
</div>

<div class="game-controls">
    <button class="btn-game" onclick="startNewGame()">New Game</button>
</div>

<div class="memory-game" id="gameBoard"></div>

<script>
    let cards = [];
    let flippedCards = [];
    let matchedPairs = 0;
    let moves = 0;
    const totalPairs = 8;
    const emojis = ['🎮', '🎲', '🎯', '🎪', '🎨', '🎭', '🎪', '🎯'];
    
    function createBoard() {
        const gameBoard = document.getElementById('gameBoard');
        gameBoard.innerHTML = '';
        cards = [];
        flippedCards = [];
        matchedPairs = 0;
        moves = 0;
        updateStats();

        const cardValues = [...emojis, ...emojis];
        cardValues.sort(() => Math.random() - 0.5);

        cardValues.forEach((emoji, index) => {
            const card = document.createElement('div');
            card.className = 'card';
            card.dataset.value = emoji;
            card.dataset.index = index;
            card.onclick = () => flipCard(card);
            cards.push(card);
            gameBoard.appendChild(card);
        });
    }
    
    // Start game when page loads
    createBoard();
</script> 