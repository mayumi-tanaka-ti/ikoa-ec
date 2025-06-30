import { apiClient } from "../../utils/api.js";

document.addEventListener("DOMContentLoaded", async () => {

    // トークンの確認
    const token = localStorage.getItem('token');
    if (!token) {
        document.getElementById('message').textContent = 'ログインが必要です';
        return;
    }

    // カテゴリと全商品を最初にまとめて取得
    const [catRes, prodRes] = await Promise.all([
        apiClient.get('/admin/categories'),
        apiClient.get('/admin/products')
    ]);
    const categories = catRes.data || catRes;
    const allProducts = prodRes.data || prodRes;

    // 表示用のコンテナを取得
    const container = document.getElementById('category-list');
    container.innerHTML = '';

    for (const category of categories.data || categories) {
        const catDiv = document.createElement('div');
        catDiv.className = 'category';
        catDiv.innerHTML = `<div class="category-title">${category.name} <a href="/admin/products/category_edit.html?id=${category.id}" class="edit-category-link">編集</a></div>`;
        // 事前に取得した全商品からカテゴリIDで絞り込み
        const products = (allProducts.data || allProducts).filter(p => String(p.category_id) === String(category.id));
        const ul = document.createElement('ul');
        ul.className = 'product-list';
        for (const product of products) {
            const li = document.createElement('li');
            li.innerHTML = `<a href="/admin/products/show.html?id=${product.id}">${product.name}</a>`;
            // 表示/非表示ボタン
            const toggleBtn = document.createElement('button');
            toggleBtn.textContent = product.is_visible ? '非表示にする' : '表示にする';
            toggleBtn.className = 'toggle-visible-btn';
            toggleBtn.addEventListener('click', async () => {
                toggleBtn.disabled = true;
                try {
                    // PATCHでis_visibleをトグル
                    const newVisible = product.is_visible ? 0 : 1;
                    const res = await apiClient.patch(`/admin/products/${product.id}`, { is_visible: newVisible });
                    if (res.status >= 200 && res.status < 300) {
                        product.is_visible = newVisible;
                        toggleBtn.textContent = newVisible ? '非表示にする' : '表示にする';
                    } else {
                        alert('更新失敗: ' + (res.data?.message || ''));
                    }
                } catch (err) {
                    alert('通信エラー: ' + (err.response?.data?.message || err.message));
                }
                toggleBtn.disabled = false;
            });
            li.appendChild(toggleBtn);
            ul.appendChild(li);
        }
        catDiv.appendChild(ul);
        container.appendChild(catDiv);
    }
});
