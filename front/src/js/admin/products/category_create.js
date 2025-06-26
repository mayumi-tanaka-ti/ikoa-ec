import { apiClient } from "../../utils/api.js";

// DOMContentLoadedイベントで初期化
document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById('category-form');
    if (form) {
        form.addEventListener('submit', async function(e) {
            // フォーム送信時の処理
            e.preventDefault();
            const formData = new FormData(form);
            const btn = form.querySelector('button[type="submit"]');
            btn.disabled = true;
            document.getElementById('result').textContent = '登録中...';
            // カテゴリ登録リクエスト
            try {
                // Authorizationヘッダーを動的にセット
                const headers = {};
                const token = localStorage.getItem('token');
                if (token) headers['Authorization'] = 'Bearer ' + token;

                const res = await apiClient.post('/admin/categories', formData, { headers });
                console.log(res.status); // ← レスポンス全体を確認
                // ステータスコードが200台なら成功とみなす
                const isSuccess = res.status >= 200 && res.status < 300;
                document.getElementById('result').textContent = isSuccess
                    ? '登録成功'
                    : '登録失敗: ' + (res.data?.message || JSON.stringify(res.data?.errors) || '');
                if (isSuccess) form.reset();
            } catch (err) {
                document.getElementById('result').textContent = '通信エラー';
            }
            btn.disabled = false;
        });
    }
});
