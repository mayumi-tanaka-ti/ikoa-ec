// カテゴリ登録フォーム送信
if (document.getElementById('category-form')) {
    document.getElementById('category-form').addEventListener('submit', async function(e) {
        // フォーム送信時の処理
        e.preventDefault();
        const form = e.target;
        const formData = new FormData(form);
        const btn = form.querySelector('button[type="submit"]');
        btn.disabled = true;
        document.getElementById('result').textContent = '登録中...';
        // カテゴリ登録リクエスト
        try {
            const res = await fetch('/api/admin/categories', {
                method: 'POST',
                body: formData,
                headers: { 'Authorization': localStorage.getItem('token') ? 'Bearer ' + localStorage.getItem('token') : undefined }
            });
            const result = await res.json();
            document.getElementById('result').textContent = res.ok ? '登録成功' : '登録失敗: ' + (result.message || JSON.stringify(result.errors) || '');
        } catch (err) {
            document.getElementById('result').textContent = '通信エラー';
        }
        btn.disabled = false;
    });
}
