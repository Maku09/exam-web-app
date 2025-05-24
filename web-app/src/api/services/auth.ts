import type { AxiosResponse } from "axios";
import axios from "@/api/axios.ts";

export async function getAPIHealth(): Promise<AxiosResponse> {
  return await axios.get(`api/v1/health`);
}

export async function login(credentials: object): Promise<AxiosResponse> {
  return await axios.post(`api/v1/login`, credentials);
}

export async function getUser(): Promise<AxiosResponse> {
  return await axios.get(`api/v1/user/me`);
}

export async function logout(): Promise<AxiosResponse> {
  return await axios.post(`api/v1/logout`);
}
