// 購入手続き画面 purchase.html 用
import { apiClient } from '../../utils/api.js'; 

document.addEventListener('DOMContentLoaded', () => {
    showCart();
    document.getElementById('purchaseForm').addEventListener('submit', handlePurchase);
    document.getElementById('backToCart').addEventListener('click', function(e) {
        e.preventDefault();
        window.location.href = '/ikoa/cart/purchase.html'; // カート画面のパスに合わせて修正
    });
});

const apiBase = 'http://localhost:8000';
let cartItems = [];

// カート内容を表示
async function showCart() {
    const token = localStorage.getItem('token');
    console.log('Token:', token); // デバッグ用
    const res = await apiClient.get(`/cart`, {
        headers: { 'Authorization': 'Bearer ' + token }
    });
    let data = {};
    try {
        data = await res.json();
    } catch (e) {
        document.getElementById('cartSummary').textContent = 'カート情報の取得に失敗しました';
        return;
    }
    const summary = document.getElementById('cartSummary');
    cartItems = data.items || [];
    if (cartItems.length > 0) {
        let html = '<ul>';
        let total = 0;
        cartItems.forEach(item => {
            html += `<li>${item.product ? item.product.name : ''} × ${item.quantity}：${item.amount_price}円</li>`;
            total += Number(item.amount_price);
        });
        html += `</ul><strong>合計：${total}円</strong>`;
        summary.innerHTML = html;
        document.getElementById('orderTotal').textContent = total + '円';
    } else {
        summary.innerHTML = 'カートに商品がありません。';
        document.getElementById('orderTotal').textContent = '0円';
    }
}

// 購入確定処理
async function handlePurchase(e) {
    e.preventDefault();
    // 配送先情報
    const address = document.getElementById('address').value;
    const postal = document.getElementById('postal').value;
    const recipient = document.getElementById('recipient').value;
    const phone = document.getElementById('phone').value;
    // カード情報
    const cardNumber = document.getElementById('cardNumber').value;
    const cardExp = document.getElementById('cardExp').value;
    const cardCvc = document.getElementById('cardCvc').value;
    const note = document.getElementById('note').value;
    const token = localStorage.getItem('token');
    // バリデーション例（必要に応じて追加）
    if (!cardNumber || !cardExp || !cardCvc) {
        document.getElementById('result').textContent = 'カード情報を入力してください';
        return;
    }
    const res = await fetch(`${apiBase}/api/cart/purchase`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + token
        },
        body: JSON.stringify({
            shipping_address: address,
            shipping_postal_code: postal,
            recipient_name: recipient,
            recipient_phone: phone,
            payment_method: 'クレジットカード',
            card_number: cardNumber,
            card_exp: cardExp,
            card_cvc: cardCvc,
            note
        })
    });
    let data = {};
    try {
        data = await res.json();
    } catch (e) {
        document.getElementById('result').textContent = 'サーバーエラーまたはレスポンス不正';
        return;
    }
    if (res.ok) {
        document.getElementById('result').textContent = '購入が完了しました。';
        setTimeout(() => { window.location.href = 'complete.html'; }, 1500);
    } else {
        document.getElementById('result').textContent = data.message || 'エラーが発生しました';
    }
}
