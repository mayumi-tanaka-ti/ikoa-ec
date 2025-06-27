import {apiClient} from '../../utils/api.js'

document.addEventListener('DOMContentLoaded', async() =>{
    await loadUser()
})

async function loadUser(){
    try{
    const response = await apiClient.get("/admin/users")
    console.log('User names:', response.data.map(users => users.name));//デバック用

    const users = response.data

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
        console.log('商品の取得に失敗：', error)
    }
}