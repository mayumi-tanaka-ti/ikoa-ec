// 管理者ログイン画面用JS
import { apiClient } from '../../utils/api.js';

function showMessage(message, isError = false) {
  const messageDiv = document.getElementById('message');
  messageDiv.textContent = message;
  messageDiv.style.color = isError ? 'red' : 'green';
}

function showLoggedInState() {
  document.getElementById('loginForm').style.display = 'none';
  document.getElementById('logoutSection').style.display = 'block';
  document.getElementById('message').textContent = '';
}

document.getElementById('loginForm').addEventListener('submit', async (e) => {
  e.preventDefault();
  const formData = new FormData(e.target);
  const loginData = {
    email: formData.get('email'),
    password: formData.get('password')
  };
  try {
    const response = await apiClient.post('/admin_login', loginData);
    // token を保存
    localStorage.setItem('token', response.data.token);
    if (response.data.user) {
      localStorage.setItem('user', JSON.stringify(response.data.user));
    }
    showMessage('ログイン成功！', false);
    setTimeout(() => {
      showLoggedInState();
    }, 500);
  } catch (error) {
    console.error('ログインエラー:', error);
    showMessage(error.message || 'ログインに失敗しました', true);
  }
});

document.getElementById('logoutBtn').addEventListener('click', async () => {
  try {
    await apiClient.post('/logout', {});
  } catch (error) {
    console.error('ログアウトAPIエラー:', error);
  } finally {
    localStorage.removeItem('token');
    localStorage.removeItem('user');
    document.getElementById('loginForm').style.display = 'block';
    document.getElementById('logoutSection').style.display = 'none';
    document.getElementById('loginForm').reset();
    showMessage('ログアウトしました', false);
  }
});

window.addEventListener('load', () => {
  const token = localStorage.getItem('token');
  if (token) {
    showLoggedInState();
  }
});
