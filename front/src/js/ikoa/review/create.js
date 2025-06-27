// レビュー作成画面 create.html 用

document.addEventListener('DOMContentLoaded', () => {
    // URLパラメータからproduct_idを取得し、フォームにセット
    const urlParams = new URLSearchParams(window.location.search);
    const productId = urlParams.get('product_id');
    if (productId) {
        document.getElementById('product_id').value = productId;
    }
    document.getElementById('reviewForm').addEventListener('submit', handleReviewSubmit);
});

const apiBase = 'http://localhost:8000';

async function handleReviewSubmit(e) {
    e.preventDefault();
    const product_id = document.getElementById('product_id').value;
    const rating = document.getElementById('rating').value;
    const comment = document.getElementById('comment').value;
    const token = localStorage.getItem('token');
    const res = await fetch(`${apiBase}/api/reviews/store/${product_id}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + token
        },
        body: JSON.stringify({ rating, comment })
    });
    let data = {};
    try {
        data = await res.json();
    } catch (e) {
        document.getElementById('result').textContent = 'サーバーエラーまたはレスポンス不正';
        return;
    }
    if (res.ok) {
        document.getElementById('result').textContent = 'レビューが投稿されました';
        document.getElementById('reviewForm').reset();
    } else {
        document.getElementById('result').textContent = data.message || 'エラーが発生しました';
    }
}
