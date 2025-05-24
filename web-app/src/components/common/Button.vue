<script setup>
  const props = defineProps({
    leftIcon: Function,
  });
</script>
<template>
  <button
    class="inline-flex px-4 py-2 h-[40px] rounded-sm justify-center items-center font-semibold hover:opacity-90 active:scale-98"
  >
    <component
      :is="props?.leftIcon"
      class="w-5 h-5 mr-1"
    />
    <slot />
  </button>
</template>
