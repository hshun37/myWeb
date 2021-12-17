let computerNumber = 0;
let playbutton = document.getElementById("play-button");
let userInput = document.getElementById("user-input");
let resultArea = document.getElementById("result-area");
let resetButton = document.getElementById("reset-button");
let chanceArea = document.getElementById("chance-area");
let chances = 5;
let gameOver = false;
let history = [];


function pickRandomNum() {
    computerNumber = Math.floor(Math.random() * 100) + 1;
    console.log("정답", computerNumber);
}

function paly() {
    let userValue = userInput.value;

    if(userValue < 1 || userValue > 100) {
        resultArea.textContent = "1과 100사이 숫자를 입력해 주세요";
        return;
    }

    if(history.includes(userValue)) {
        resultArea.textContent = "이미 입력한 숫자입니다. 다른 숫자를 입력해주세요.";
        return;
    }

    chances --;
    chanceArea.textContent = `남은 기회 : ${chances}`;
    console.log(chances);

    if(userValue < computerNumber) {
        resultArea.textContent = "Up!!";
    } else if(userValue > computerNumber) {
        resultArea.textContent = "Down!!";
    } else {
        chanceArea.textContent = `정답 : ${computerNumber}`;
        resultArea.textContent = "맞추셨습니다!!";
        playbutton.disabled = true;
    }

    history.push(userValue);
    console.log(history);

    if(chances < 1) {
        gameOver = true;
    }

    if(gameOver == true) {
        playbutton.disabled = true;
    }
}

function reset() {
    // user input창이 깨끗하게 정리
    userInput.value = "";
    // 새로운 번호 생성
    pickRandomNum();
    resultArea.textContent = "결과가 나온다";
    playbutton.disabled = false;
    chances = 5;
    chanceArea.textContent = `남은 기회 : ${chances}`;
    history = [];
}

pickRandomNum();

playbutton.addEventListener("click", paly);
resetButton.addEventListener("click", reset);
userInput.addEventListener("focus", function(){userInput.value=""})
