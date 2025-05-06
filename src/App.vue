<script setup></script>
<template>
  <div class="flex flex-col bg-gray-50 h-screen">
    <div class="h-[56px] bg-white w-full shadow-sm">app-bar</div>
    <main class="h-screen overflow-auto">
      <RouterView></RouterView>
    </main>
    <div>footer</div>
  </div>
</template>
