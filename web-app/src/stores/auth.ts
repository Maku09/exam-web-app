import axios from "@/api/axios";
import { defineStore } from "pinia";
import useLocalStorage from "@/composables/useLocalStorage.ts";
import * as authServices from '@/api/services/auth.ts' 


type User = {
  id: number;
  name: string;
  email: string;
};

type Credentials = {
  email: string;
  password: string;
};

export const useAuthStore = defineStore("auth", () => {
  const user = useLocalStorage<User | null>("auth.user");
  const token = useLocalStorage<string | null>("token");

  let isSessionVerified = false;

  async function login(credentials: Credentials) {
    try {
      const { data: response } = await authServices.login(credentials);
      token.value = response.data.access_token
      await loadUser();
    } catch (err) {
      console.log(err);
    }
  }

  async function loadUser() {
    isSessionVerified = true;
    const { data: response } = await authServices.getUser();
    user.value = response.data;
  }

  async function logout() {
    await authServices.logout();
    user.value = null;
    token.value = null;
  }

  async function verifySession() {
    //check api/user & initialpageload
    if (user.value && !isSessionVerified) {
      try {
        await loadUser();
      } catch (error) {
        user.value = null;
        token.value = null;
      }
    }
  }

  return {
    verifySession,
    login,
    logout,
    user,
  };
});