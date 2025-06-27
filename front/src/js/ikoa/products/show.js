document.addEventListener('DOMContentLoaded', async () => {
    const detailContainer = document.getElementById('product-show');
    const params = new URLSearchParams(window.location.search);
    const id = params.get('id');

    if (!id) {
        detailContainer.innerHTML = '<p>商品が指定されていません</p>';
        return;
    }

    try {
        const response = await fetch(`http://localhost:8000/api/user/products/${id}`);
        if (!response.ok) {
            throw new Error('商品が見つかりませんでした');
        }

        const result = await response.json();   // ← JSONレスポンスを取得
        const product = result.data;            // ← dataから product を取り出す

        detailContainer.innerHTML = `
            <p><strong>商品名：</strong>${product.name}</p>
            <p><strong>価格：</strong>${product.price}</p>
            <p><strong>説明：</strong>${product.description}</p>
        `;

        // レビュー
        if (product.reviews && product.reviews.length > 0) {
            detailContainer.innerHTML += '<h3>レビュー:</h3><ul>';
            product.reviews.forEach(review => {
                detailContainer.innerHTML += `
                    <li>
                        <strong>${review.user_name}</strong> (${review.review_date})<br>
                        評価: ${review.rating}<br>
                        コメント: ${review.comment}
                    </li>
                `;
            });
            detailContainer.innerHTML += '</ul>';
        } else {
            detailContainer.innerHTML += `<p>レビューはまだありません。</p>`;
        }

        detailContainer.innerHTML += `
            <div style="margin-top: 20px;">
                <button id="write-review">レビューを書く</button>
            </div>
        `;

        document.getElementById('write-review').addEventListener('click', () => {
            window.location.href = `/ikoa/products/review.html?id=${product.id}`;
        });

    } catch (error) {
        detailContainer.innerHTML = `<p>エラー：${error.message}</p>`;
    }
});
