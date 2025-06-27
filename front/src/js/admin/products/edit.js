import { apiClient } from "../../utils/api.js";

document.addEventListener("DOMContentLoaded", () => {
    // URLから商品IDを取得
    function getProductIdFromQuery() {
        const params = new URLSearchParams(window.location.search);
        return params.get('id');
    }

    // カテゴリ一覧を取得してセレクトボックスにセット
    async function loadCategories(selectedId) {
        const res = await apiClient.get('/admin/categories');
        const data = res.data || res;
        const select = document.getElementById('category-select');
        select.innerHTML = '';
        (data.data || data).forEach(cat => {
            const opt = document.createElement('option');
            opt.value = cat.id;
            opt.textContent = cat.name;
            if (selectedId && String(cat.id) === String(selectedId)) opt.selected = true;
            select.appendChild(opt);
        });
    }

    // 商品情報を取得してフォームにセット
    async function loadProduct() {
        const id = getProductIdFromQuery();
        if (!id) return;
        try {
            const res = await apiClient.get(`/admin/products/${id}`);
            const data = res.data || res;
            document.getElementById('product-name').value = data.name;
            document.getElementById('product-price').value = data.price;
            document.getElementById('product-description').value = data.description || '';
            document.getElementById('product-stock').value = data.stock;
            await loadCategories(data.category_id);
            if (data.image_path) {
                document.getElementById('current-image').innerHTML = `<img src="/storage/${data.image_path}" alt="${data.name}" style="max-width:120px;">`;
            }
            // 詳細画面への戻るリンクもセット
            document.getElementById('back-to-show').href = `/admin/products/show.html?id=${id}`;
        } catch (e) {
            document.getElementById('result').textContent = '商品情報取得失敗';
        }
    }

    // フォーム送信
    const form = document.getElementById('product-edit-form');
    if (form) {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            const id = getProductIdFromQuery();
            if (!id) return;
            const formData = new FormData(form);
            const btn = form.querySelector('button[type="submit"]');
            btn.disabled = true;
            document.getElementById('result').textContent = '更新中...';
            try {
                const res = await apiClient.post(`/admin/products/${id}`, formData, {
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
    const deleteBtn = document.getElementById('delete-product-btn');
    if (deleteBtn) {
        deleteBtn.addEventListener('click', async function() {
            if (!confirm('本当に削除しますか？')) return;
            const id = getProductIdFromQuery();
            if (!id) return;
            deleteBtn.disabled = true;
            document.getElementById('result').textContent = '削除中...';
            try {
                const res = await apiClient.delete(`/admin/products/${id}`, {
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

    loadProduct();
});
