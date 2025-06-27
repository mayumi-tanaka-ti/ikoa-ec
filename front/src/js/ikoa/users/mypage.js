import { apiClient } from '../../utils/api.js';

document.addEventListener('DOMContentLoaded', async () => {
    await loadCurrentUser();
});

async function loadCurrentUser() {
    const container = document.getElementById('user-info');

    try {
        const response = await apiClient.get('/user', {
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('token')
            }
        });

        const user = response.data;

        container.innerHTML = `
            <div class="user-profile">
                <p><strong>名前：</strong> ${user.name}</p>
                <p><strong>メールアドレス：</strong> ${user.email}</p>
                <p><strong>電話番号：</strong> ${user.phone_number ?? '未登録'}</p>
                <p><strong>登録日：</strong> ${formatDate(user.created_at)}</p>
                <button onclick="location.href='mypage_edit.html'" class="btn btn-outline">
                    プロフィール編集
                </button>

            </div>
        `;

    } catch (error) {
        console.error('ユーザー情報の取得に失敗:', error);

        if (error.response?.status === 401) {
            container.innerHTML = `<p style="color: red;">認証エラー：ログインが必要です</p>`;
        } else {
            container.innerHTML = `<p style="color: red;">ユーザー情報の取得に失敗しました</p>`;
        }
    }
}

function formatDate(dateStr) {
    const date = new Date(dateStr);
    return date.toLocaleDateString('ja-JP', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
}
