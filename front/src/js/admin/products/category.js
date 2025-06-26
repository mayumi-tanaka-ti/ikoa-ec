import { apiClient } from "../../utils/api.js";

document.addEventListener("DOMContentLoaded", async () => {
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
            li.textContent = product.name;
            ul.appendChild(li);
        }
        catDiv.appendChild(ul);
        container.appendChild(catDiv);
    }
});
