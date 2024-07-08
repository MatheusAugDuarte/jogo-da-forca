document.getElementById('startGameButton').addEventListener('click', startGame);

function startGame() {
    fetch('php/start_game.php')
        .then(response => response.json())
        .then(data => {
            const word = data.word.toUpperCase();
            const wordArray = word.split('');
            let guessedWord = Array(word.length).fill('_');
            let mistakes = 0;
            const maxMistakes = 6;

            document.getElementById('game').innerHTML = `
                <p id="guessedWord">${guessedWord.join(' ')}</p>
                <input type="text" id="letterInput" maxlength="1">
                <button id="guessButton">Guess</button>
                <div id="hangman"></div>
            `;

            document.getElementById('guessButton').addEventListener('click', guessLetter);
            document.getElementById('letterInput').addEventListener('keyup', function (event) {
                if (event.key === "Enter") {
                    guessLetter();
                }
            });

            function guessLetter() {
                const letter = document.getElementById('letterInput').value.toUpperCase();
                document.getElementById('letterInput').value = '';

                if (wordArray.includes(letter)) {
                    wordArray.forEach((char, index) => {
                        if (char === letter) {
                            guessedWord[index] = letter;
                        }
                    });
                } else {
                    mistakes++;
                    drawHangman(mistakes);
                }

                document.getElementById('guessedWord').textContent = guessedWord.join(' ');

                if (guessedWord.join('') === word) {
                    alert('Congratulations! You won!');
                    saveResult(word, 'won');
                } else if (mistakes >= maxMistakes) {
                    alert(`Game over! The word was ${word}`);
                    saveResult(word, 'lost');
                }
            }

            function drawHangman(mistakes) {
                const hangman = document.getElementById('hangman');
                const parts = [
                    ' O ',
                    ' O <br>/',
                    ' O <br>/|',
                    ' O <br>/|\\',
                    ' O <br>/|\\<br>/',
                    ' O <br>/|\\<br>/ \\'
                ];
                hangman.innerHTML = parts[mistakes - 1];
            }

            function saveResult(word, result) {
                fetch('php/save_result.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ word, result })
                });
            }
        });
}
