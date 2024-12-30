<style>
    .snake-game {
        width: 400px;
        height: 400px;
        margin: 20px auto;
        background: var(--bg-color);
        border: 2px solid var(--primary-color);
        position: relative;
    }

    .snake-cell {
        position: absolute;
        width: 20px;
        height: 20px;
        background: var(--primary-color);
        border-radius: 4px;
    }

    .food {
        position: absolute;
        width: 20px;
        height: 20px;
        background: #ff4444;
        border-radius: 50%;
    }

    .game-score {
        text-align: center;
        font-size: 1.2em;
        margin: 10px 0;
        color: var(--text-color);
    }
</style>

<h2 class="game-title">Snake Game</h2>

<div class="game-score">Score: <span id="score">0</span></div>

<div class="snake-game" id="gameArea"></div>

<div class="game-controls">
    <button class="btn-game" onclick="startGame()">New Game</button>
</div>

<script>
    const gameArea = document.getElementById('gameArea');
    let snake = [{x: 10, y: 10}];
    let food = {x: 15, y: 15};
    let dx = 1;
    let dy = 0;
    let score = 0;
    let gameLoop;

    function drawGame() {
        gameArea.innerHTML = '';
        
        // Draw snake
        snake.forEach(segment => {
            const snakeCell = document.createElement('div');
            snakeCell.className = 'snake-cell';
            snakeCell.style.left = segment.x * 20 + 'px';
            snakeCell.style.top = segment.y * 20 + 'px';
            gameArea.appendChild(snakeCell);
        });
        
        // Draw food
        const foodElement = document.createElement('div');
        foodElement.className = 'food';
        foodElement.style.left = food.x * 20 + 'px';
        foodElement.style.top = food.y * 20 + 'px';
        gameArea.appendChild(foodElement);
    }

    function moveSnake() {
        const head = {
            x: snake[0].x + dx,
            y: snake[0].y + dy
        };

        // Check wall collision
        if (head.x < 0 || head.x >= 20 || head.y < 0 || head.y >= 20) {
            gameOver();
            return;
        }

        // Check self collision
        if (snake.some(segment => segment.x === head.x && segment.y === head.y)) {
            gameOver();
            return;
        }

        snake.unshift(head);

        // Check food collision
        if (head.x === food.x && head.y === food.y) {
            score += 10;
            document.getElementById('score').textContent = score;
            generateFood();
        } else {
            snake.pop();
        }

        drawGame();
    }

    function generateFood() {
        food = {
            x: Math.floor(Math.random() * 20),
            y: Math.floor(Math.random() * 20)
        };
        // Make sure food doesn't appear on snake
        while (snake.some(segment => segment.x === food.x && segment.y === food.y)) {
            food = {
                x: Math.floor(Math.random() * 20),
                y: Math.floor(Math.random() * 20)
            };
        }
    }

    function gameOver() {
        clearInterval(gameLoop);
        alert(`Game Over! Score: ${score}`);
    }

    function startGame() {
        snake = [{x: 10, y: 10}];
        dx = 1;
        dy = 0;
        score = 0;
        document.getElementById('score').textContent = score;
        generateFood();
        clearInterval(gameLoop);
        gameLoop = setInterval(moveSnake, 100);
    }

    document.addEventListener('keydown', (e) => {
        switch(e.key) {
            case 'ArrowUp':
                if (dy !== 1) { dx = 0; dy = -1; }
                break;
            case 'ArrowDown':
                if (dy !== -1) { dx = 0; dy = 1; }
                break;
            case 'ArrowLeft':
                if (dx !== 1) { dx = -1; dy = 0; }
                break;
            case 'ArrowRight':
                if (dx !== -1) { dx = 1; dy = 0; }
                break;
        }
    });

    // Start game initially
    startGame();
</script> 