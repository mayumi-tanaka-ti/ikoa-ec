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
                // apiClientでPOST
                const res = await apiClient.post('/admin/categories', formData, {
                    headers: { 'Authorization': localStorage.getItem('token') ? 'Bearer ' + localStorage.getItem('token') : undefined }
                });
                document.getElementById('result').textContent = res.status === 200 || res.status === 201 ? '登録成功' : '登録失敗: ' + (res.data?.message || JSON.stringify(res.data?.errors) || '');
            } catch (err) {
                document.getElementById('result').textContent = '通信エラー';
            }
            btn.disabled = false;
        });
    }
});
