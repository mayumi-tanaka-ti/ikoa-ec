const API_BASE_URL = 'http://localhost:8000/api'

export const apiClient = {
    async get(endpoint) {
        const token = localStorage.getItem('token')
        const response = await fetch(`${API_BASE_URL}${endpoint}`, {
            headers: {
                'Authorization': token ? `Bearer ${token}` : '',
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            }
        })
        
        const data = await response.json()
        
        if (!response.ok) {
            const error = {status: response.status, data: data}
            throw error;
        }
        
        return {status: response.status, data: data};
    },
    
    async post(endpoint, data) {
        const token = localStorage.getItem('token')
        
        // FormData かどうかを判定
        const isFormData = data instanceof FormData
        
        const headers = {
            'Authorization': token ? `Bearer ${token}` : '',
            'Accept': 'application/json',
        }
        
        // FormData の場合は Content-Type を設定しない（ブラウザが自動設定）
        if (!isFormData) {
            headers['Content-Type'] = 'application/json'
        }
        
        const response = await fetch(`${API_BASE_URL}${endpoint}`, {
            method: 'POST',
            headers,
            body: isFormData ? data : JSON.stringify(data)
        })
        
        const responseData = await response.json()
        
        if (!response.ok) {
            const error = {status: response.status, data: responseData}
            throw error;
        }
        
        return {
            status: response.status,
            data: responseData
        };
    },
    
    async put(endpoint, data) {
        const token = localStorage.getItem('token')
        
        const isFormData = data instanceof FormData
        
        const headers = {
            'Authorization': token ? `Bearer ${token}` : '',
            'Accept': 'application/json',
        }
        
        if (!isFormData) {
            headers['Content-Type'] = 'application/json'
        }
        
        const response = await fetch(`${API_BASE_URL}${endpoint}`, {
            method: 'PUT',
            headers,
            body: isFormData ? data : JSON.stringify(data)
        })
        
        const responseData = await response.json()
        
        if (!response.ok) {
            const error = {status: response.status, data: responseData}
            throw error;
        }
        
        return {
            status: response.status,
            data: responseData
        };
    },
    
    async delete(endpoint) {
        const token = localStorage.getItem('token')
        const response = await fetch(`${API_BASE_URL}${endpoint}`, {
            method: 'DELETE',
            headers: {
                'Authorization': token ? `Bearer ${token}` : '',
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            }
        })
        
        const responseData = await response.json()
        
        if (!response.ok) {
            const error = {status: response.status, data: responseData}
            throw error;
        }
        
        return {
            status: response.status,
            data: responseData
        };
    }
}