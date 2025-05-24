import type { AxiosResponse } from "axios";
import axios from "@/api/axios.ts";

// export async function login(credentials: object): Promise<AxiosResponse> {
//   return await axios.post(`api/v1/login`, credentials);
// }

export async function getProduct(): Promise<AxiosResponse> {
  return await axios.get(`api/v1/products/`);
}

export async function getProductDetail(id: number): Promise<AxiosResponse> {
  return await axios.get(`api/v1/products/${id}`);
}

export async function createProduct(formData: FormData): Promise<AxiosResponse> {
  return await axios.post(`api/v1/products/`, formData);
}

export async function updateProduct(formData: FormData, id: number): Promise<AxiosResponse> {
  return await axios.put(`api/v1/products/${id}`, formData);
}

export async function deleteProduct(id: number): Promise<AxiosResponse> {
  return await axios.delete(`api/v1/products/${id}`);
}
