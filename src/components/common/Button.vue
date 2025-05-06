<script setup>
const props = defineProps({
  leftIcon: Function,
})
</script>

<template>
  <button
    class="h-[36px] justify-center rounded-md px-4 py-1.5 items-center inline-flex hover:not-focus:bg-indigo-700"
  >
    <component :is="props?.leftIcon" class="mr-1 size-5" />
    <span class="text-sm font-semibold">
      <slot />
    </span>
  </button>
</template>
