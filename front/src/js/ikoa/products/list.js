document.addEventListener('DOMContentLoaded', async () => {
    const productList = document.getElementById('product-list');
    const categoryTitle = document.getElementById('category-title');

    const urlParams = new URLSearchParams(window.location.search);
    const categoryId = urlParams.get('category_id');

    if (!categoryId) {
        categoryTitle.textContent = 'カテゴリが指定されていません';
        productList.innerHTML = '<p>カテゴリIDがありません。</p>';
        return;
    }

    try {
        // Laravelの list() は全カテゴリ＋商品を返すのでそのまま取得
        const response = await fetch('http://localhost:8000/api/user/products/list');
        if (!response.ok) {
            throw new Error('データの取得に失敗しました');
        }

        const json = await response.json();
        const categories = json.data || json; // APIレスポンスの形に合わせて調整

        // 指定カテゴリを探す
        const category = categories.find(cat => String(cat.id) === categoryId);

        if (!category) {
            categoryTitle.textContent = '該当するカテゴリがありません';
            productList.innerHTML = '<p>カテゴリが見つかりません。</p>';
            return;
        }

        categoryTitle.textContent = `${category.name} の商品一覧`;

        if (!category.products || category.products.length === 0) {
            productList.innerHTML = '<p>該当する商品はありません。</p>';
            return;
        }

        const ul = document.createElement('ul');
        category.products.forEach(product => {
            const li = document.createElement('li');
            li.innerHTML = `
                <strong>${product.name}</strong><br>
                価格: ${product.price} 円<br>
                <a href="/ikoa/products/show.html?id=${product.id}">詳細を見る</a>
            `;
            ul.appendChild(li);
        });
        productList.appendChild(ul);

    } catch (error) {
        categoryTitle.textContent = '商品一覧の取得に失敗しました';
        productList.innerHTML = `<p>エラー：${error.message}</p>`;
        console.error('商品一覧取得エラー:', error);
    }
});


