import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'

// https://vite.dev/config/
export default defineConfig({
  plugins: [react()],
  // This tells Vite to use "relative paths" so Hostinger can find the files 
  // regardless of which folder they are placed in.
  base: './', 
})