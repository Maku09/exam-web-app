<script setup>
import { getProductDetail } from '@/api/services/product'
import Button from '@/components/common/Button.vue'
import { ArrowLeftIcon } from '@heroicons/vue/20/solid'
import { onMounted, ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'

const route = useRoute()
const router = useRouter()

const productDetail = ref()
const isLoading = ref(true)

onMounted(async () => {
  const { data } = await getProductDetail(route?.params?.id)
  if (data) {
    isLoading.value = false
    productDetail.value = data
  }
})

const categoryColor = {
  jewelery: 'text-white bg-pink-400',
  "men's clothing": 'text-gray-700 bg-cyan-400',
  "women's clothing": 'text-white bg-indigo-400',
  electronics: 'text-white bg-red-400',
}

const getCategoryColor = (category) => {
  return categoryColor[category]
}
</script>

<template>
  <div class="relative">
    <div v-if="isLoading" class="absolute z-10 bg-black/20 h-screen w-full flex">
      <svg
        class="size-10 animate-spin flex-1 place-self-center text-white"
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
      >
        <circle
          class="opacity-25"
          cx="12"
          cy="12"
          r="10"
          stroke="currentColor"
          stroke-width="4"
        ></circle>
        <path
          class="opacity-75"
          fill="currentColor"
          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
        ></path>
      </svg>
    </div>

    <div v-else class="flex flex-col px-10">
      <div class="shrink-0 flex flex-row mt-10 justify-between px-3 py-2">
        <Button
          class="bg-indigo-600 text-white"
          :leftIcon="ArrowLeftIcon"
          @click="router.push({ name: 'ProductList' })"
          >Back</Button
        >
        <div>Udpate</div>
      </div>

      <div class="flex-1 px-3 mt-10 flex bg-white rounded-full">
        <div class="mx-auto flex items-center px-3 py-7 rounded space-x-5">
          <img
            class="h-96 w-80 object-contain ..."
            :alt="productDetail?.title"
            :src="productDetail?.image"
          />
          <div class="flex flex-col space-y-3 pl-20 w-[780px]">
            <span class="font-bold text-3xl text-gray-800">{{ productDetail?.title }}</span>

            <div>
              <span
                class="mt-2 rounded px-2 py-1 uppercase font-semibold text-sm"
                :class="getCategoryColor(productDetail?.category)"
              >
                {{ productDetail?.category }}
              </span>
            </div>

            <div class="text-gray-700 w-[600px]">{{ productDetail?.description }}</div>
            <div class="text-red-400 font-bold mt-2 px-0.5">${{ productDetail?.price }}</div>
            <div>Rating: {{ productDetail?.rating?.rate }}</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
