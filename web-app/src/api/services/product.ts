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

export async function logout(): Promise<AxiosResponse> {
  return await axios.post(`api/v1/logout`);
}
