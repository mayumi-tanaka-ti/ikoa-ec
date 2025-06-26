// URLから商品IDを取得
function getProductIdFromQuery() {
    const params = new URLSearchParams(window.location.search);
    return params.get('id');
}

async function loadProduct() {
    const id = getProductIdFromQuery();
    if (!id) return;
    try {
        const res = await fetch(`/api/admin/products/${id}`);
        const data = await res.json();
        const container = document.getElementById('product-detail');
        if (!data || data.message) {
            container.textContent = '商品が見つかりません';
            return;
        }
        container.innerHTML = `
            <div class="product-show-box">
                <h2>${data.name}</h2>
                ${data.image_path ? `<img src="/storage/${data.image_path}" alt="${data.name}" style="max-width:200px;">` : ''}
                <p>価格: <strong>￥${data.price.toLocaleString()}</strong></p>
                <p>説明: ${data.description || '-'}</p>
                <p>在庫: ${data.stock}</p>
                <p>カテゴリID: ${data.category_id}</p>
            </div>
        `;
    } catch (e) {
        document.getElementById('product-detail').textContent = '商品情報取得失敗';
    }
}

window.addEventListener('DOMContentLoaded', () => {
    loadProduct();
    // 商品IDを取得して編集画面へのリンクをセット
    const params = new URLSearchParams(window.location.search);
    const id = params.get('id');
    if (id && document.getElementById('edit-product-btn')) {
        document.getElementById('edit-product-btn').href = `/admin/products/edit.html?id=${id}`;
    }
});
