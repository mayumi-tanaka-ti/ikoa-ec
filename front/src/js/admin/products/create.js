import { apiClient } from "../../utils/api.js";

document.addEventListener("DOMContentLoaded", () => {
    // カテゴリ一覧を取得してセレクトボックスにセット
    async function loadCategories() {
        try {
            const res = await apiClient.get('/admin/categories');
            const data = res.data || res;
            const select = document.getElementById('category-select');
            (data.data || data).forEach(cat => {
                const opt = document.createElement('option');
                opt.value = cat.id;
                opt.textContent = cat.name;
                select.appendChild(opt);
            });
        } catch (e) {
            document.getElementById('result').textContent = 'カテゴリ取得失敗';
        }
    }

    // 商品登録フォーム送信
    const form = document.getElementById('product-form');
    if (form) {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            const formData = new FormData(form);
            const btn = form.querySelector('button[type="submit"]');
            btn.disabled = true;
            document.getElementById('result').textContent = '登録中...';
            try {
                const res = await apiClient.post('/admin/products', formData, {
                    headers: { 'Authorization': localStorage.getItem('token') ? 'Bearer ' + localStorage.getItem('token') : undefined }
                });
                // ステータスコードが200台なら成功とみなす
                console.log(res.status); // レスポンス全体を確認
                const isSuccess = res.status >= 200 && res.status < 300;
                document.getElementById('result').textContent = isSuccess ? '登録成功' : '登録失敗: ' + (res.data?.message || JSON.stringify(res.data?.errors) || '');
                if (isSuccess) form.reset();
            } catch (err) {
                console.log('登録エラー詳細:', err);
                if (err && err.data && err.data.errors) {
                    document.getElementById('result').textContent = '登録失敗: ' + JSON.stringify(err.data.errors);
                } else if (err && err.errors) {
                    document.getElementById('result').textContent = '登録失敗: ' + JSON.stringify(err.errors);
                } else if (typeof err === 'object') {
                    document.getElementById('result').textContent = '登録失敗: ' + JSON.stringify(err);
                } else {
                    document.getElementById('result').textContent = '通信エラー';
                }
            }
            btn.disabled = false;
        });
    }

    // ページ読み込み時にカテゴリをロード
    loadCategories();
});
