import { apiClient } from "../../utils/api.js";

document.addEventListener("DOMContentLoaded", () => {
    // URLからカテゴリIDを取得
    function getCategoryIdFromQuery() {
        const params = new URLSearchParams(window.location.search);
        return params.get('id');
    }

    // カテゴリ情報を取得してフォームにセット
    async function loadCategory() {
        const id = getCategoryIdFromQuery();
        if (!id) return;
        try {
            const res = await apiClient.get(`/admin/categories/${id}`);
            const data = res.data || res;
            document.getElementById('category-name').value = data.name;
        } catch (e) {
            document.getElementById('result').textContent = 'カテゴリ情報取得失敗';
        }
    }

    // フォーム送信
    const form = document.getElementById('category-edit-form');
    if (form) {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            const id = getCategoryIdFromQuery();
            if (!id) return;
            const formData = new FormData(form);
            const btn = form.querySelector('button[type="submit"]');
            btn.disabled = true;
            document.getElementById('result').textContent = '更新中...';
            try {
                const res = await apiClient.patch(`/admin/categories/${id}`, formData, {
                    headers: { 'Authorization': localStorage.getItem('token') ? 'Bearer ' + localStorage.getItem('token') : undefined }
                });
                document.getElementById('result').textContent = res.status === 200 ? '更新成功' : '更新失敗: ' + (res.data?.message || JSON.stringify(res.data?.errors) || '');
            } catch (err) {
                document.getElementById('result').textContent = '通信エラー';
            }
            btn.disabled = false;
        });
    }

    // 削除ボタンの処理
    const deleteBtn = document.getElementById('delete-category-btn');
    if (deleteBtn) {
        deleteBtn.addEventListener('click', async function() {
            if (!confirm('本当に削除しますか？')) return;
            const id = getCategoryIdFromQuery();
            if (!id) return;
            deleteBtn.disabled = true;
            document.getElementById('result').textContent = '削除中...';
            try {
                const res = await apiClient.delete(`/admin/categories/${id}`, {
                    headers: { 'Authorization': localStorage.getItem('token') ? 'Bearer ' + localStorage.getItem('token') : undefined }
                });
                if (res.status === 200) {
                    document.getElementById('result').textContent = '削除成功';
                    setTimeout(() => { window.location.href = '/admin/products/category.html'; }, 1000);
                } else {
                    document.getElementById('result').textContent = '削除失敗: ' + (res.data?.message || JSON.stringify(res.data?.errors) || '');
                }
            } catch (err) {
                document.getElementById('result').textContent = '通信エラー';
            }
            deleteBtn.disabled = false;
        });
    }

    loadCategory();
});
