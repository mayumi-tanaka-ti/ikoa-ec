import {apiClient} from '../../utils/api.js'

document.addEventListener('DOMContentLoaded', async() =>{
    await loadUser()
})

async function loadUser(){
    try{
    const response = await apiClient.get("/admin/users")
    console.log('User names:', response.data.data.map(users => users.name));//デバック用

    const users = response.data.data

    const listElement = document.getElementById('user_name')
    listElement.innerHTML = users.map(user =>
        `<div style="margin-bottom: 1em;">
        名前：${user.name}<br>
        電話番号：${user.phone_number}<br>
        <button onclick="location.href='../users/show.html?id=${user.id}'">詳細</button>
        </div>
        <br>`
    ).join('')
    }catch(error){
        console.log('ユーザーの取得に失敗：', error)
        console.log('エラーステータス:', error.status)
        console.log('エラーデータ:', error.data)
        
        // エラーメッセージを画面に表示
        const listElement = document.getElementById('user_name')
        if (error.status === 401) {
            listElement.innerHTML = '<p style="color: red;">認証エラー：ログインが必要です</p>'
        } else if (error.status === 403) {
            listElement.innerHTML = '<p style="color: red;">権限エラー：管理者権限が必要です</p>'
        } else {
            listElement.innerHTML = '<p style="color: red;">データの取得に失敗しました</p>'
        }
    }
}