import { apiClient } from "../../utils/api.js";


// script.js
let currentUserId = null;

document.addEventListener('DOMContentLoaded', async () => {
    const detailContainer = document.getElementById('product-show');
    const params = new URLSearchParams(window.location.search);
    const id = params.get('id') || params.get('product_id');

    // カート数の初期化
    updateCartCount();

    if (!id) {
        showError('商品が指定されていません');
        return;
    }

    // ログインユーザーID取得
    try {
        const token = localStorage.getItem('token');
        if (token) {
            const userRes = await apiClient.get('/user', {
                headers: { 'Authorization': 'Bearer ' + token }
            });
            currentUserId = userRes.data.id;
        }
    } catch (e) {
        currentUserId = null;
    }

    try {
        await loadProductDetail(id);
    } catch (error) {
        showError(`エラー：${error.message}`);
    }
});

async function loadProductDetail(id) {
    const detailContainer = document.getElementById('product-show');
    
    try {
        const response = await fetch(`http://localhost:8000/api/user/products/${id}`);
        if (!response.ok) {
            throw new Error('商品が見つかりませんでした');
        }

        const result = await response.json();
        const product = result.data;

        renderProductDetail(product);
        setupEventListeners(product);

    } catch (error) {
        throw error;
    }
}

function renderProductDetail(product) {
    const detailContainer = document.getElementById('product-show');
    
    const productHTML = `
        <div class="product-header">
            <div class="product-image">
                <img src="http://localhost:8000/storage/${product.image_path || '/images/no-image.png'}" alt="${product.name}">
            </div>
            <div class="product-info">
                <h1 class="product-title">${escapeHtml(product.name)}</h1>
                <div class="product-price">¥${Number(product.price).toLocaleString()}</div>
                <div class="product-description">
                    <h3>商品説明</h3>
                    <p>${escapeHtml(product.description)}</p>
                </div>
                <div class="product-actions">
                    <div class="quantity-selector">
                        <label for="quantity">数量:</label>
                        <select id="quantity" class="quantity-select">
                            ${Array.from({length: 10}, (_, i) => `<option value="${i + 1}">${i + 1}</option>`).join('')}
                        </select>
                    </div>
                    <button id="add-to-cart" class="btn btn-primary" data-product-id="${product.id}">
                        <span class="btn-icon">🛒</span>
                        カートに追加
                    </button>
                </div>
            </div>
        </div>
        
        <div class="reviews-section">
            <h2>レビュー</h2>
            ${renderReviews(product.reviews)}
            <div class="review-actions">
                <button id="write-review" class="btn btn-outline" data-product-id="${product.id}">
                    レビューを書く
                </button>
            </div>
        </div>
    `;

    detailContainer.innerHTML = productHTML;
}

function renderReviews(reviews) {
    if (!reviews || reviews.length === 0) {
        return '<div class="no-reviews"><p>レビューはまだありません。</p></div>';
    }
    const reviewsHTML = reviews.map(review => `
        <div class="review-item" data-review-id="${review.id}">
            <div class="review-header">
                <div class="reviewer-info">
                    <strong class="reviewer-name">${escapeHtml(review.user_name)}</strong>
                    <span class="review-date">${formatDate(review.review_date)}</span>
                </div>
                <div class="rating">
                    ${renderStars(review.rating)}
                </div>
            </div>
            <div class="review-content">
                <p>${escapeHtml(review.comment)}</p>
            </div>
            ${currentUserId && review.user_id === currentUserId ? `
                <div class="review-actions">
                    <button class="btn-edit-review" data-review-id="${review.id}">編集</button>
                    <button class="btn-delete-review" data-review-id="${review.id}">削除</button>
                </div>
            ` : ''}
        </div>
    `).join('');
    return `<div class="reviews-list">${reviewsHTML}</div>`;
}

function renderStars(rating) {
    const stars = [];
    for (let i = 1; i <= 5; i++) {
        stars.push(i <= rating ? '★' : '☆');
    }
    return `<span class="stars">${stars.join('')}</span>`;
}

function setupEventListeners(product) {
    // カートに追加ボタン
    const addToCartBtn = document.getElementById('add-to-cart');
    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', () => {
            const quantity = parseInt(document.getElementById('quantity').value);
            addToCart(product, quantity);
        });
    }

    // レビューを書くボタン
    const writeReviewBtn = document.getElementById('write-review');
    if (writeReviewBtn) {
        writeReviewBtn.addEventListener('click', () => {
            window.location.href = `/ikoa/reviews/create.html?product_id=${product.id}`;
        });
    }

    setTimeout(() => {
        document.querySelectorAll('.btn-edit-review').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const reviewId = btn.getAttribute('data-review-id');
                window.location.href = `/ikoa/reviews/edit.html?reviewId=${reviewId}`;
            });
        });
        document.querySelectorAll('.btn-delete-review').forEach(btn => {
            btn.addEventListener('click', async (e) => {
                const reviewId = btn.getAttribute('data-review-id');
                if (!confirm('本当にこのレビューを削除しますか？')) return;
                try {
                    const token = localStorage.getItem('token');
                    const res = await apiClient.delete(`/reviews/delete/${reviewId}`, {
                        headers: { 'Authorization': 'Bearer ' + token }
                    });
                    if (res.status === 200) {
                        showToast('レビューを削除しました');
                        await loadProductDetail(product.id);
                    } else {
                        showToast('削除に失敗しました', 'error');
                    }
                } catch (err) {
                    showToast('削除に失敗しました', 'error');
                }
            });
        });
    }, 0);
}

async function addToCart(product, quantity) {
    try {
        // カートデータの取得
        let cart = JSON.parse(localStorage.getItem('cart') || '[]');
        
        // 既存商品の確認
        const existingItem = cart.find(item => item.id === product.id);
        
        if (existingItem) {
            existingItem.quantity += quantity;
        } else {
            cart.push({
                id: product.id,
                name: product.name,
                price: product.price,
                quantity: quantity,
                image: product.image
            });
        }

        const token = localStorage.getItem('token');

        // ユーザーID取得
        const user = await apiClient.get('/user', {
            headers: { 'Authorization': 'Bearer ' + token }
        });
        const user_id = user.data.id;
         
        // カートの保存
        const res = await apiClient.post('/cart', {
            'user_id': user_id, 'product_id': product.id, 'quantity': quantity
        },{
            headers: { 'Authorization': 'Bearer ' + token }
        });

        // UI更新
        updateCartCount();
        showToast('カートに追加しました');
        
        // ボタンの一時的な状態変更
        const btn = document.getElementById('add-to-cart');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<span class="btn-icon">✓</span>追加完了';
        btn.disabled = true;
        
        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.disabled = false;
        }, 1500);

    } catch (error) {
        console.error('カートへの追加に失敗しました:', error);
        showToast('エラーが発生しました', 'error');
    }
}

function updateCartCount() {
    try {
        const cart = JSON.parse(localStorage.getItem('cart') || '[]');
        const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
        
        const cartCountElement = document.getElementById('cart-count');
        if (cartCountElement) {
            cartCountElement.textContent = totalItems;
            cartCountElement.style.display = totalItems > 0 ? 'inline' : 'none';
        }
    } catch (error) {
        console.error('カート数の更新に失敗しました:', error);
    }
}

function showToast(message, type = 'success') {
    const toast = document.getElementById('toast');
    const toastMessage = toast.querySelector('.toast-message');
    const toastIcon = toast.querySelector('.toast-icon');
    
    toastMessage.textContent = message;
    toastIcon.textContent = type === 'success' ? '✓' : '⚠';
    toast.className = `toast ${type}`;
    
    toast.classList.add('show');
    
    setTimeout(() => {
        toast.classList.remove('show');
    }, 3000);
}

function showError(message) {
    const detailContainer = document.getElementById('product-show');
    detailContainer.innerHTML = `
        <div class="error-message">
            <div class="error-icon">⚠</div>
            <p>${escapeHtml(message)}</p>
        </div>
    `;
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('ja-JP', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
}