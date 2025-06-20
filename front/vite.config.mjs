import { defineConfig } from 'vite'
import { resolve } from 'node:path'

export default defineConfig({
  build: {
    rollupOptions: {
      input: {
        main:  resolve(__dirname, 'index.html'),
        // Products RESTful ページ
        productsIndex: resolve(__dirname, 'products/index.html'),
        productsCreate: resolve(__dirname, 'products/create.html'),
        
        // login:  resolve(__dirname, 'login.html'),  
      },
    },
  },
})
