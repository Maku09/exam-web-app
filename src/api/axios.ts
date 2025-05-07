import Axios from 'axios'

const axios = Axios.create({
  baseURL: 'https://fakestoreapi.com/',
  // baseURL: import.meta.env.VITE_API_URL,
  headers: {
    Accept: 'application/json',
  },
})

export default axios
