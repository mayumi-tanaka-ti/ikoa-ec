document.addEventListener('DOMContentLoaded', async () => {
  const container = document.getElementById('category-buttons');

  try {
    // カテゴリ一覧をAPIから取得
    const response = await fetch('http://localhost:8000/api/user/products');
    if (!response.ok) throw new Error('カテゴリの取得に失敗しました');

    const json = await response.json();
    const categories = json.data || json; // APIレスポンスの形に合わせて調整

    if (!categories || categories.length === 0) {
      container.textContent = 'カテゴリがありません。';
      return;
    }

    // カテゴリごとにボタンを作成
    categories.forEach(category => {
      const btn = document.createElement('button');
      btn.textContent = category.name;
      btn.addEventListener('click', () => {
        // list.htmlにcategory_idを付けて遷移
        window.location.href = `/ikoa/products/list.html?category_id=${category.id}`;
      });
      container.appendChild(btn);
    });
  } catch (error) {
    container.textContent = `エラー: ${error.message}`;
    console.error(error);
  }
});