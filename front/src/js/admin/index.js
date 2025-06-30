// 管理者画面トップ：ログイン状態に応じて表示を切り替え

document.addEventListener('DOMContentLoaded', () => {
    const token = localStorage.getItem('token');
    const msg = document.createElement('div');
    msg.style.margin = '2em 0';
    msg.style.textAlign = 'center';
    if (token) {
        msg.innerHTML = `
            <p style="color:green;font-weight:bold;">ログイン済みです</p>
        `;
    } else {
        msg.innerHTML = `
            <p style="color:red;font-weight:bold;">管理者ログインが必要です</p>
            <button id="goLogin" style="padding:0.5em 2em;">ログイン画面へ</button>
        `;
    }
    document.body.appendChild(msg);
    document.getElementById('goLogin').addEventListener('click', () => {
        window.location.href = '/admin/login.html';
    });
});
