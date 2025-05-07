<script setup></script>
<template>
  <div class="flex flex-col bg-gray-50 h-screen">
    <div class="h-[56px] bg-white w-full shadow-sm flex justify-start px-3 py-2 items-center">
      <p class="font-bold text-gray-800 text-2xl uppercase">Exam-web-app</p>
    </div>
    <main class="h-screen overflow-auto">
      <RouterView></RouterView>
    </main>
    <footer class="bg-gray-50 text-center px-5 py-4">
      <p>&copy; 2025 Exam Project by Jay Mark Jamon. All rights reserved.</p>
    </footer>
  </div>
</template>
