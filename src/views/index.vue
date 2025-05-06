<script setup>
import { getProduct } from '@/api/services/product'
import { onMounted, ref } from 'vue'
import Card from '@/components/Card.vue'

const productList = ref()

onMounted(async () => {
  const { data } = await getProduct()
  productList.value = data
})
</script>
<template>
  <div class="flex flex-col px-10">
    <div class="shrink-0 h-10 flex flex-row mt-2 justify-between px-3 py-2">
      <div>create</div>
      <div class="flex flex-row space-x-5">
        <div>search</div>
        <div>filter</div>
      </div>
    </div>

    <div
      class="flex-1 h-200 px-5 grid lg:grid-cols-5 xl:grid-cols-6 md:grid-cols-4 sm:grid-cols-2 space-x-3 space-y-5 overflow-auto"
    >
      <template v-for="item in productList">
        <Card :product="item" />
      </template>
    </div>
    <div class="shrink-0">pagination</div>
  </div>
</template>
