// カテゴリと商品をAPIから取得して表示
async function fetchCategoriesWithProducts() {

    // カテゴリ一覧を取得
    const res = await fetch('/api/admin/categories');
    const categories = await res.json();

    // 表示用のコンテナを取得
    const container = document.getElementById('category-list');
    container.innerHTML = '';

    for (const category of categories.data || categories) {
        //カテゴリ名表示
        const catDiv = document.createElement('div');
        catDiv.className = 'category';
        catDiv.innerHTML = `<div class="category-title">${category.name}</div>`;
        // 商品一覧取得（カテゴリIDで絞り込み）
        const prodRes = await fetch(`/api/admin/products?category_id=${category.id}`);
        const products = await prodRes.json();

        // 商品リストを作成
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
//ページ読込時に実行
fetchCategoriesWithProducts();
