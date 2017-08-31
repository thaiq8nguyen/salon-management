import axios from 'axios';

export const http = axios.create({
    baseURL:'/api',
    headers:{
        'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        'X-Requested-With': 'XMLHttpRequest'
    }
});