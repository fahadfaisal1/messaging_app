<style>
    .tictactoe-board {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
        max-width: 300px;
        margin: 20px auto;
    }

    .cell {
        aspect-ratio: 1;
        background: var(--bg-color);
        border: 2px solid var(--primary-color);
        border-radius: 8px;
        font-size: 2em;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: var(--text-color);
    }

    .cell:hover {
        background: var(--hover-color);
    }

    .game-status {
        text-align: center;
        margin: 20px 0;
        font-size: 1.2em;
        color: var(--text-color);
    }
</style>

<h2 class="game-title">Tic Tac Toe</h2>

<div class="game-status" id="status">Player X's turn</div>

<div class="tictactoe-board" id="board"></div>

<div class="game-controls">
    <button class="btn-game" onclick="resetGame()">New Game</button>
</div>

<script>
    let currentPlayer = 'X';
    let gameBoard = ['', '', '', '', '', '', '', '', ''];
    let gameActive = true;

    function createBoard() {
        const board = document.getElementById('board');
        board.innerHTML = '';
        gameBoard.forEach((cell, index) => {
            const cellElement = document.createElement('div');
            cellElement.className = 'cell';
            cellElement.addEventListener('click', () => makeMove(index));
            board.appendChild(cellElement);
        });
    }

    function makeMove(index) {
        if (gameBoard[index] === '' && gameActive) {
            gameBoard[index] = currentPlayer;
            document.getElementsByClassName('cell')[index].textContent = currentPlayer;
            
            if (checkWin()) {
                document.getElementById('status').textContent = `Player ${currentPlayer} wins!`;
                gameActive = false;
                return;
            }
            
            if (gameBoard.every(cell => cell !== '')) {
                document.getElementById('status').textContent = "It's a draw!";
                gameActive = false;
                return;
            }
            
            currentPlayer = currentPlayer === 'X' ? 'O' : 'X';
            document.getElementById('status').textContent = `Player ${currentPlayer}'s turn`;
        }
    }

    function checkWin() {
        const winPatterns = [
            [0, 1, 2], [3, 4, 5], [6, 7, 8], // Rows
            [0, 3, 6], [1, 4, 7], [2, 5, 8], // Columns
            [0, 4, 8], [2, 4, 6] // Diagonals
        ];

        return winPatterns.some(pattern => {
            const [a, b, c] = pattern;
            return gameBoard[a] !== '' && 
                   gameBoard[a] === gameBoard[b] && 
                   gameBoard[b] === gameBoard[c];
        });
    }

    function resetGame() {
        currentPlayer = 'X';
        gameBoard = ['', '', '', '', '', '', '', '', ''];
        gameActive = true;
        document.getElementById('status').textContent = "Player X's turn";
        createBoard();
    }

    // Initialize game
    createBoard();
</script> 