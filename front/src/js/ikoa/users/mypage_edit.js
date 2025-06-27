const API_BASE = 'http://localhost:8000/api';

document.addEventListener('DOMContentLoaded', async () => {
  const token = localStorage.getItem('token');
  if (!token) {
    document.getElementById('result').textContent = 'ログインしてください';
    return;
  }

  // ユーザー情報を取得してフォームに反映
  try {
    const res = await fetch(`${API_BASE}/user/mypage`, {
      headers: { 'Authorization': `Bearer ${token}` }
    });
    if (!res.ok) throw new Error('取得に失敗');
    const data = await res.json();
    document.getElementById('name').value = data.name || '';
    document.getElementById('email').value = data.email || '';
    document.getElementById('phone_number').value = data.phone_number || '';
    document.getElementById('address').value = data.name || '';
  } catch (e) {
    document.getElementById('result').textContent = 'ユーザー情報の取得に失敗しました';
    console.error(e);
  }

  // フォーム送信（PUT更新）
  document.getElementById('mypageForm').addEventListener('submit', async function (e) {
    e.preventDefault();
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const phone_number = document.getElementById('phone_number').value;
    const address = document.getElementById('address').value;

    try {
      const res = await fetch(`${API_BASE}/user/mypage`, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': `Bearer ${token}`
        },
        body: JSON.stringify({ name, email, phone_number, address })
      });

      const data = await res.json();

      if (res.ok) {
        document.getElementById('result').textContent = '情報を更新しました';
      } else {
        document.getElementById('result').textContent = data.message || '更新に失敗しました';
      }
    } catch (e) {
      document.getElementById('result').textContent = '通信エラーが発生しました';
      console.error(e);
    }
  });
});