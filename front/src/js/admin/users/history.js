import { apiClient } from '../../utils/api.js'

document.addEventListener("DOMContentLoaded", async () => {
  const urlParams = new URLSearchParams(window.location.search)
  const userId = urlParams.get('id')

  if (!userId) {
    document.getElementById('error-message').textContent = "ユーザIDが指定されていません"
    document.getElementById("error-message").style.display = "block"
    return
  }

  try {
    const response = await apiClient.get(`/admin/history/${userId}`)
    console.log('API response:', response)

    const { user, orders } = response
    let html = ''

    if (orders.length === 0) {
      html = '<p>注文履歴はありません。</p>'
    } else {
      orders.forEach(order => {
        html += `
        <h3>注文ID：${order.id}</h3>
        <div class="info-row">注文日時：${order.order_date}</div>
        <div class="info-row">合計金額：${order.total_price}円</div>
        <div class="info-row">配送先：${order.shipping_address} (${order.shipping_postal_code})</div>
        <div class="info-row">受取人：${order.recipient_name} (${order.recipient_phone})</div>
        <div class="info-row">支払い方法：${order.payment_method}</div>
        <h4>商品一覧：</h4>
        `

        order.products.forEach(product => {
          html += `
          <div class="product">
            <div>商品名：${product.name}</div>
            <div>価格：${product.pivot.price}円</div>
            <div>数量：${product.pivot.quantity}</div>
            <div><img src="${product.image_path}" width="100" /></div>
          </div>
          <hr>`
        })
      })
    }

    document.getElementById('user-history').innerHTML = html

  } catch (error) {
    console.error('購入履歴取得に失敗:', error)
    const errorDiv = document.getElementById('error-message')
    errorDiv.textContent = 'データ取得に失敗しました'
    errorDiv.style.display = 'block'
  }
})
