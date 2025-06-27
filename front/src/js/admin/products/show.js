import { apiClient } from "../../utils/api.js";

document.addEventListener('DOMContentLoaded', () => {
    // URLから商品IDを取得
    function getProductIdFromQuery() {
        const params = new URLSearchParams(window.location.search);
        return params.get('id');
    }

    async function loadProduct() {
        const id = getProductIdFromQuery();
        if (!id) return;
        try {
            const res = await apiClient.get(`/admin/products/${id}`);
            const data = res.data || res;
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

    loadProduct();
    // 商品IDを取得して編集画面へのリンクをセット
    const id = getProductIdFromQuery();
    if (id && document.getElementById('edit-product-btn')) {
        document.getElementById('edit-product-btn').href = `/admin/products/edit.html?id=${id}`;
    }
});
