// カテゴリと商品をAPIから取得して表示
async function fetchCategoriesWithProducts() {
    const res = await fetch('/api/admin/categories');
    const categories = await res.json();
    const container = document.getElementById('category-list');
    container.innerHTML = '';
    for (const category of categories.data || categories) {
        const catDiv = document.createElement('div');
        catDiv.className = 'category';
        catDiv.innerHTML = `<div class="category-title">${category.name}</div>`;
        // 商品一覧取得（カテゴリIDで絞り込み）
        const prodRes = await fetch(`/api/admin/products?category_id=${category.id}`);
        const products = await prodRes.json();
        const ul = document.createElement('ul');
        ul.className = 'product-list';
        for (const product of products.data || products) {
            const li = document.createElement('li');
            li.textContent = product.name;
            ul.appendChild(li);
        }
        catDiv.appendChild(ul);
        container.appendChild(catDiv);
    }
}
fetchCategoriesWithProducts();
