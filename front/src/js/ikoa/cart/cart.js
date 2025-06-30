document.addEventListener('DOMContentLoaded', async () => {
  const cartItemsDiv = document.getElementById('cart-items');
  const totalPriceSpan = document.getElementById('total-price');
  const purchaseBtn = document.getElementById('purchase-btn');

  // トークン取得関数
  function getToken() {
    const token = localStorage.getItem('token');
    console.log('取得したトークン:', token);
    return token;
  }

  // カート情報を取得して表示
  async function fetchCart() {
    try {
      const token = getToken();
      if (!token) throw new Error('ログインが必要です');

      const res = await fetch('http://localhost:8000/api/cart', {
        method: 'GET',
        headers: {
          'Accept': 'application/json',
          'Authorization': `Bearer ${token}`,
        },
      });

      if (!res.ok) {
        if (res.status === 401) throw new Error('認証エラー：ログインしてください');
        throw new Error('カート情報の取得に失敗しました');
      }

      const data = await res.json();
      console.log(data);

      // カートが空の場合
      if (!data.items || data.items.length === 0) {
        cartItemsDiv.innerHTML = '<p class="cart-empty">カートは空です</p>';
        totalPriceSpan.textContent = '0';
        return;
      }

      // 商品ごとにHTMLを構築
      cartItemsDiv.innerHTML = '';
      data.items.forEach(item => {
        const subtotal = item.quantity * item.price;

        const itemDiv = document.createElement('div');
        itemDiv.classList.add('cart-item');
        itemDiv.innerHTML = `
          <p>
            <strong>${item.product_name}</strong> - ${item.price}円 × 
            <input type="number" min="1" value="${item.quantity}" data-id="${item.product_id}" class="qty-input">
            = ${subtotal}円
            <button data-id="${item.product_id}" class="delete-btn">削除</button>
          </p>
        `;
        cartItemsDiv.appendChild(itemDiv);
      });

      totalPriceSpan.textContent = data.total;

      attachEvents(); // 数量変更・削除ボタンイベント登録

    } catch (error) {
      cartItemsDiv.innerHTML = `<p class="cart-empty">エラー: ${error.message}</p>`;
      console.error('カート取得エラー:', error);
    }
  }

  // 数量変更・削除ボタンにイベント登録
  function attachEvents() {
    const token = getToken();

    // 数量変更
    document.querySelectorAll('.qty-input').forEach(input => {
      input.addEventListener('change', async (e) => {
        const newQty = parseInt(e.target.value, 10);
        const cartProductId = e.target.dataset.id;

        if (newQty < 1) {
          alert('数量は1以上で入力してください');
          e.target.value = 1;
          return;
        }

        try {
          const res = await fetch(`http://localhost:8000/api/cart/${cartProductId}`, {
            method: 'PUT',
            headers: {
              'Content-Type': 'application/json',
              'Accept': 'application/json',
              'Authorization': `Bearer ${token}`,
            },
            body: JSON.stringify({ quantity: newQty }),
          });

          if (!res.ok) throw new Error('数量更新に失敗しました');
          await fetchCart();
        } catch (error) {
          alert(error.message);
        }
      });
    });

    // 削除処理
    document.querySelectorAll('.delete-btn').forEach(button => {
      button.addEventListener('click', async (e) => {
        const cartProductId = e.target.dataset.id;
        if (!confirm('本当に削除しますか？')) return;

        try {
          const res = await fetch(`http://localhost:8000/api/cart/${cartProductId}`, {
            method: 'DELETE',
            headers: {
              'Accept': 'application/json',
              'Authorization': `Bearer ${token}`,
            }
          });

          if (!res.ok) throw new Error('削除に失敗しました');
          await fetchCart();
        } catch (error) {
          alert(error.message);
        }
      });
    });
  }

  // 購入ボタンで遷移
  purchaseBtn.addEventListener('click', () => {
    window.location.href = '/ikoa/cart/purchase.html';
  });

  // 初回読み込み
  await fetchCart();
});
