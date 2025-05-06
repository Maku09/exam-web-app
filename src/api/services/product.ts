import type { AxiosResponse } from 'axios'
import axios from '@/api/axios.ts'

export async function getProduct(page: number = 1, search: string = ''): Promise<AxiosResponse> {
  //   return await axios.get(`products/retrieve?page=${page}&search=${search}`)
  return await axios.get(`products`)
}

export async function getProductDetail(id: number): Promise<AxiosResponse> {
  return await axios.get(`products/${id}`)
}

export async function createProduct(form: Object): Promise<AxiosResponse> {
  return await axios.post(`products`, form)
}

export async function updateProduct(id: number, form: Object): Promise<AxiosResponse> {
  return await axios.put(`products/${id}`, form)
}

export async function deleteProduct(id: number): Promise<AxiosResponse> {
  return await axios.delete(`products/${id}`)
}
