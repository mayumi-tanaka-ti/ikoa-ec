// レビュー編集画面用 edit.js

document.addEventListener('DOMContentLoaded', () => {
    const params = new URLSearchParams(window.location.search);
    const reviewId = params.get('id');
    if (!reviewId) {
        document.getElementById('error').textContent = 'レビューIDが指定されていません';
        return;
    }
    fetchReview(reviewId);
    document.getElementById('editReviewForm').addEventListener('submit', (e) => handleEdit(e, reviewId));
});

const apiBase = 'http://localhost:8000';

// 既存レビュー取得
async function fetchReview(reviewId) {
    const token = localStorage.getItem('token');
    try {
        const res = await fetch(`${apiBase}/api/reviews/${reviewId}`, {
            headers: { 'Authorization': 'Bearer ' + token }
        });
        if (!res.ok) throw new Error('取得失敗');
        const data = await res.json();
        document.getElementById('rating').value = data.rating;
        document.getElementById('comment').value = data.comment;
    } catch (e) {
        document.getElementById('error').textContent = 'レビュー情報の取得に失敗しました';
    }
}

// レビュー編集送信
async function handleEdit(e, reviewId) {
    e.preventDefault();
    document.getElementById('result').textContent = '';
    document.getElementById('error').textContent = '';
    const rating = document.getElementById('rating').value;
    const comment = document.getElementById('comment').value;
    const token = localStorage.getItem('token');
    if (!rating || !comment) {
        document.getElementById('error').textContent = '全て入力してください';
        return;
    }
    try {
        const res = await fetch(`${apiBase}/api/reviews/update/${reviewId}`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + token
            },
            body: JSON.stringify({ rating, comment })
        });
        const data = await res.json();
        if (res.ok) {
            document.getElementById('result').textContent = data.message || 'レビューを更新しました';
            setTimeout(() => {
                window.location.href = '/ikoa/users/mypage.html';
            }, 1500);
        } else {
            document.getElementById('error').textContent = data.message || '更新に失敗しました';
        }
    } catch (e) {
        document.getElementById('error').textContent = '通信エラー';
    }
}
