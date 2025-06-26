import {apiClient} from "../../utils/api.js"

document.addEventListener("DOMContentLoaded", async() => {
    const urlParams = new URLSearchParams(window.location.search)
    const userId = urlParams.get('id')

    if(!userId){
        document.getElementById('error-message').textContent = "ユーザIDが指定されていません"
        document.getElementById("error-message").style.display = "block"
        return
    }

    try{
        const response = await apiClient.get(`/user/${userId}`)
        const user = response.data || response

        console.log('ユーザ情報詳細：', user)

        document.getElementById("user-details").innerHTML = `
        <div class="user-info">
        <div class="info-row"><label>ID:</label><span>${user.id}</span></div>
        <div class="info-row"><label>名前：</label><span>${user.name}</span></div>
        <div class="info-row"><label>性別：</label><span>${user.gender}</span></div>
        <div class="info-row"><label>電話番号:</label><span>${user.pshone_number}</span></div>
        <div class="info-row"><label>郵便番号:</label><span>${user.post_code}</span></div>
        <div class="info-row"><label>住所:</label><span>${user.address}</span></div>
        <div class="info-row"><label>メール:</label><span>${user.email}</span></div>
        <div class="info-row"><label>パスワード:</label><span>${user.password}</span></div>
        <div class="info-row"><label>登録日時:</label><span>${new Date(user.created_at).toLocaleString('ja-JP')}</span></div>
        <div class="info-row"><label>更新日時:</label><span>${new Date(user.updated_at).toLocaleString('ja-JP')}</span></div>
        </div>
        <br>
        <div class="action-buttons">
        <button onclick="location.href='../../../admin/users/user.html'">一覧に戻る</button>
        </div>
        `
    } catch (error) {
           console.error('詳細の取得に失敗:', error)
        
            document.getElementById('loading-message').style.display = 'none'
            const errorDiv = document.getElementById('error-message')
            errorDiv.textContent = error.status === 404 ? '情報が見つかりません' : '詳細の取得に失敗しました'
            errorDiv.style.display = 'block'
    }
})

// 
// <a href="../../../admin/users/edit.html?id=${userId}" class="btn btn-primary">編集</a>
// <button type="button" id="delete-btn" class="btn btn-danger">削除</button>