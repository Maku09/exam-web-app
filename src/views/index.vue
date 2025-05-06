<script setup>
import { getProduct } from '@/api/services/product'
import { onMounted, ref } from 'vue'
import Card from '@/components/Card.vue'
import Button from '@/components/common/Button.vue'
import { PlusIcon } from '@heroicons/vue/20/solid'
import { useRouter } from 'vue-router'
import useProductStore from '@/stores/'

const router = useRouter()

const productStore = useProductStore()

onMounted(async () => {
  if (!productStore?.productList?.length) {
    productStore._load()
  }
})
</script>
<template>
  <div class="flex flex-col px-10">
    <div class="shrink-0 flex flex-row mt-10 justify-between px-3 py-2">
      <div>
        <Button
          class="bg-indigo-600 text-white"
          :leftIcon="PlusIcon"
          @click="router.push({ name: 'ProductCreate' })"
          >Create</Button
        >
      </div>
      <div class="flex flex-row space-x-5">
        <div>search</div>
        <div>filter</div>
      </div>
    </div>

    <div
      class="flex-1 h-200 mt-5 grid lg:grid-cols-5 xl:grid-cols-6 md:grid-cols-4 sm:grid-cols-2 space-x-3 space-y-5 overflow-auto"
    >
      <template v-for="item in productStore.productList">
        <Card :product="item" />
      </template>
    </div>
    <div class="shrink-0">pagination</div>
  </div>
</template>
