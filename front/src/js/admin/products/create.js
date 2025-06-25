// カテゴリ一覧を取得してセレクトボックスにセット
async function loadCategories() {
    try {
        const res = await fetch('/api/admin/categories');
        const data = await res.json();
        const select = document.getElementById('category-select');
        (data.data || data).forEach(cat => {
            const opt = document.createElement('option');
            opt.value = cat.id;
            opt.textContent = cat.name;
            select.appendChild(opt);
        });
    } catch (e) {
        document.getElementById('result').textContent = 'カテゴリ取得失敗';
    }
}

//トークン取得
function getToken() {
    const token = localStorage.getItem('token');
    return token ? 'Bearer ' + token : '';
}

// 商品登録フォームの送信処理
if (document.getElementById('product-form')) {
    document.getElementById('product-form').addEventListener('submit', async function(e) {
        e.preventDefault();
        const form = e.target;
        const formData = new FormData(form);
        const btn = form.querySelector('button[type=\"submit\"]');
        btn.disabled = true;
        document.getElementById('result').textContent = '登録中...';
        try {
            const res = await fetch('/api/admin/products', {
                method: 'POST',
                body: formData,
                headers: { 'Authorization': getToken() }
            });
            const result = await res.json();
            document.getElementById('result').textContent = res.ok ? '登録成功' : '登録失敗: ' + (result.message || JSON.stringify(result.errors) || '');
        } catch (err) {
            document.getElementById('result').textContent = '通信エラー';
        }
        btn.disabled = false;
    });
}

// ページ読み込み時にカテゴリをロード
loadCategories();
