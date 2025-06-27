document.addEventListener('DOMContentLoaded', async () => {
    const productList = document.getElementById('product-list');
    const categoryTitle = document.getElementById('category-title');
    const searchInput = document.getElementById('searchInput');
    const sortSelect = document.getElementById('sortSelect');

    const urlParams = new URLSearchParams(window.location.search);
    const categoryId = urlParams.get('category_id');

    let currentProducts = [];

    if (!categoryId) {
        categoryTitle.textContent = 'カテゴリが指定されていません';
        productList.innerHTML = '<p>カテゴリIDがありません。</p>';
        return;
    }

    try {
        const response = await fetch('http://localhost:8000/api/user/products/list');
        if (!response.ok) throw new Error('データの取得に失敗しました');

        const json = await response.json();
        const categories = json.data || json;

        const category = categories.find(cat => String(cat.id) === categoryId);
        if (!category) {
            categoryTitle.textContent = '該当するカテゴリがありません';
            productList.innerHTML = '<p>カテゴリが見つかりません。</p>';
            return;
        }

        categoryTitle.textContent = `${category.name} の商品一覧`;
        currentProducts = category.products || [];

        renderProducts(currentProducts);

        // 検索・ソートイベント
        searchInput.addEventListener('input', () => filterAndSort(currentProducts));
        sortSelect.addEventListener('change', () => filterAndSort(currentProducts));

    } catch (error) {
        categoryTitle.textContent = '商品一覧の取得に失敗しました';
        productList.innerHTML = `<p>エラー：${error.message}</p>`;
        console.error('商品一覧取得エラー:', error);
    }

    function filterAndSort(products) {
        const keyword = searchInput.value.trim().toLowerCase();
        const sortOption = sortSelect.value;

        let filtered = products.filter(p =>
            p.name.toLowerCase().includes(keyword)
        );

        filtered.sort((a, b) => {
            switch (sortOption) {
                case 'name_asc':
                    return a.name.localeCompare(b.name);
                case 'name_desc':
                    return b.name.localeCompare(a.name);
                case 'price_asc':
                    return a.price - b.price;
                case 'price_desc':
                    return b.price - a.price;
                default:
                    return 0;
            }
        });

        renderProducts(filtered);
    }

    function renderProducts(products) {
        productList.innerHTML = '';
        if (products.length === 0) {
            productList.innerHTML = '<p>該当する商品はありません。</p>';
            return;
        }

        const ul = document.createElement('ul');
        products.forEach(product => {
            const li = document.createElement('li');
            const imageUrl = `http://localhost:8000/storage/${product.image_path}`;
            li.innerHTML = `
                <img src="${imageUrl}" alt="${product.name}" style="width: 150px; height: auto;"><br>
                <strong>${product.name}</strong><br>
                価格: ${product.price} 円<br>
                <a href="/ikoa/products/show.html?id=${product.id}">詳細を見る</a>
            `;
            ul.appendChild(li);
        });
        productList.appendChild(ul);
    }
});

