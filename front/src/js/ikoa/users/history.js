async function fetchHistory() {
    const token = localStorage.getItem('token');
    const res = await fetch('/api/history', {
        headers: { 'Authorization': 'Bearer ' + token }
    });
    const data = await res.json();
    const tbody = document.getElementById('historyBody');
    tbody.innerHTML = '';
    if (Array.isArray(data) && data.length > 0) {
        data.forEach(order => {
            order.order_products.forEach(op => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${order.id}</td>
                    <td>${order.created_at ? order.created_at.substring(0, 10) : ''}</td>
                    <td>${op.product ? op.product.name : ''}</td>
                    <td>${op.quantity || ''}</td>
                    <td>${op.price || ''}</td>
                    <td><a class='review-link' href="create.html?product_id=${op.product ? op.product.id : ''}">レビューを書く</a></td>
                `;
                tbody.appendChild(tr);
            });
        });
    } else {
        const tr = document.createElement('tr');
        tr.innerHTML = '<td colspan="6">購入履歴がありません</td>';
        tbody.appendChild(tr);
    }
}

document.addEventListener('DOMContentLoaded', fetchHistory);