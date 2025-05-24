<script setup lang="ts">
  import Button from "@/components/common/Button.vue";
  import { useAuthStore } from "@/stores/auth";
  import { useRouter } from "vue-router";

  const useAuth = useAuthStore();
  const router = useRouter();

  const handleLogout = async () => {
    await useAuth.logout();
    router.push({ name: "LoginPage" });
  };
</script>

<template>
  <div class="bg-gray-50 flex flex-col h-screen">
    <div class="bg-white shrink-0 px-3 py-2 h-[56px] shadow-sm flex items-center justify-center">
      <span class="text-2xl uppercase font-bold tracking-wide">exam-web-app</span>
    </div>
    <div class="flex h-[calc(100%-56px)]">
      <div class="shrink-0 flex w-[336px] border-gray-300 border-r">
        <div></div>
        <Button
          @click="handleLogout"
          class="text-white bg-indigo-700 w-full mx-3 my-5 self-end"
          >Logout</Button
        >
      </div>
      <div class="flex-1 h-full">
        <main class="h-full">
          <router-view></router-view>
        </main>
      </div>
    </div>
  </div>
</template>
