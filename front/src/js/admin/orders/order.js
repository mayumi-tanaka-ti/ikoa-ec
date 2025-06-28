import { apiClient } from '../../utils/api.js'

document.addEventListener('DOMContentLoaded', async () => {
  const token = localStorage.getItem('token');
  if (!token) {
    document.getElementById('message').textContent = 'ログインが必要です';
    return;
  }

  try {
    await loadSales('/admin/orders/monthly', 'monthly-sales', 'month');
    await loadSales('/admin/orders/daily', 'daily-sales', 'date');
  } catch (error) {
    console.error('売上データの取得エラー:', error);
    document.getElementById('message').textContent = '売上データの取得に失敗しました。';
  }
});

async function loadSales(endpoint, elementId, keyName) {
  const container = document.getElementById(elementId);
  try {
    const { data } = await apiClient.get(endpoint);
    if (!Array.isArray(data)) {
      container.innerHTML = `<p style="color:red;">データ形式が不正です</p>`;
      return;
    }

    const html = data.map(item => 
      `<div>${item[keyName]}：¥${Number(item.total).toLocaleString()}</div>`
    ).join('');
    
    container.innerHTML = html;

  } catch (error) {
    console.error(`${keyName}売上取得失敗:`, error);
    if (error.status === 401) {
      container.innerHTML = `<p style="color:red;">認証エラー：ログインが必要です</p>`;
    } else if (error.status === 403) {
      container.innerHTML = `<p style="color:red;">権限エラー：管理者権限が必要です</p>`;
    } else {
      container.innerHTML = `<p style="color:red;">売上の取得に失敗しました</p>`;
    }
  }
}

