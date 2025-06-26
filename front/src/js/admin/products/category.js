import { apiClient } from "../../utils/api.js";

document.addEventListener("DOMContentLoaded", () => {
    // カテゴリと商品をAPIから取得して表示
    async function fetchCategoriesWithProducts() {
        // カテゴリ一覧を取得
        const res = await apiClient.get('/admin/products/category');
        const categories = res.data || res;

        // 表示用のコンテナを取得
        const container = document.getElementById('category-list');
        container.innerHTML = '';

        for (const category of categories.data || categories) {
            const catDiv = document.createElement('div');
            catDiv.className = 'category';
            catDiv.innerHTML = `<div class="category-title">${category.name} <a href="/admin/products/category_edit.html?id=${category.id}" class="edit-category-link">編集</a></div>`;
            // 商品一覧取得（カテゴリIDで絞り込み）
            const prodRes = await apiClient.get(`/admin/products?category_id=${category.id}`);
            const products = prodRes.data || prodRes;
            const ul = document.createElement('ul');
            ul.className = 'product-list';
            for (const product of products.data || products) {
                // 商品名をリストアイテムとして追加
                const li = document.createElement('li');
                li.textContent = product.name;
                ul.appendChild(li);
            }
            catDiv.appendChild(ul);
            container.appendChild(catDiv);
        }
    }
    //ページ読込時に実行
    fetchCategoriesWithProducts();
});
