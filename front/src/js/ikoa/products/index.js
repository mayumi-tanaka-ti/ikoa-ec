document.addEventListener('DOMContentLoaded', async () => {
  const container = document.getElementById('category-buttons');
  const searchInput = document.getElementById('searchInput');
  const sortSelect = document.getElementById('sortSelect');

  let categories = []; // 全カテゴリを保持

  // 表示関数
  function renderCategories(data) {
    container.innerHTML = ''; // クリア

    if (!data || data.length === 0) {
      container.textContent = 'カテゴリがありません。';
      return;
    }

    data.forEach(category => {
      const btn = document.createElement('button');
      btn.textContent = category.name;
      btn.addEventListener('click', () => {
        window.location.href = `/ikoa/products/list.html?category_id=${category.id}`;
      });
      container.appendChild(btn);
    });
  }

  // フィルタ＆ソート適用
  function filterAndSort() {
    let filtered = [...categories];

    const keyword = searchInput.value.trim().toLowerCase();
    const sortOrder = sortSelect.value;

    if (keyword) {
      filtered = filtered.filter(cat => cat.name.toLowerCase().includes(keyword));
    }

    filtered.sort((a, b) => {
      const nameA = a.name.toLowerCase();
      const nameB = b.name.toLowerCase();
      return sortOrder === 'asc'
        ? nameA.localeCompare(nameB)
        : nameB.localeCompare(nameA);
    });

    renderCategories(filtered);
  }

  try {
    const response = await fetch('http://localhost:8000/api/user/products');
    if (!response.ok) throw new Error('カテゴリの取得に失敗しました');

    const json = await response.json();
    categories = json.data || json;

    filterAndSort(); // 初期表示
  } catch (error) {
    container.textContent = `エラー: ${error.message}`;
    console.error(error);
  }

  // イベントリスナー
  searchInput.addEventListener('input', filterAndSort);
  sortSelect.addEventListener('change', filterAndSort);
});
