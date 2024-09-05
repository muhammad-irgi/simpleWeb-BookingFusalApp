const nickname = document.getElementById('overlay_nickname');
const noTelp = document.getElementById('overlay_noTelp');

function popupNickname() {
    nickname.classList.add('show1');
}

function popupNoTelp() {
    noTelp.classList.add('show2');
}


function closePopup() {
    nickname.classList.remove('show1');
    noTelp.classList.remove('show2');
}
