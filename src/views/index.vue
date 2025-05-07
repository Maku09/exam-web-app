<script setup>
import { getProduct } from '@/api/services/product'
import { computed, onMounted, ref, watch } from 'vue'
import Card from '@/components/Card.vue'
import Button from '@/components/common/Button.vue'
import Dialog from '@/components/Dialog.vue'
import { PlusIcon } from '@heroicons/vue/20/solid'
import { useRouter } from 'vue-router'
import useProductStore from '@/stores/product'

const router = useRouter()

const productStore = useProductStore()
const isLoading = ref(true)

const searchValue = ref('')
const selectedCategory = ref('')

const productData = ref([])

let timeout = 200
const searchItem = (search, selectItem) => {
  clearTimeout(timeout)
  timeout = setTimeout(() => {
    productData.value = productStore?.productList.filter((item) => {
      if (search.length && selectItem.length) {
        return item.title.toLowerCase().includes(search) && item.category === selectItem
      } else if (search.length) {
        return item.title.includes(search)
      } else if (selectItem.length) {
        return item.category === selectItem
      } else {
        return true
      }
    })
  }, 300)
}

productStore.$subscribe((state) => {
  const id = state?.events?.oldValue?.id
  if (id) {
    let currIndex = productData.value.findIndex((item) => item.id === id)
    if (currIndex !== -1) {
      productData.value.splice(currIndex, 1)
    }
  }
})

watch([searchValue, selectedCategory], ([newSearch, newSelect], [oldSearch, oldSelect]) => {
  searchItem(newSearch, newSelect)
})

const categoryItem = computed(() => {
  if (!productData?.value?.length || !productStore?.productList?.length) {
    return []
  }

  const seen = new Set()
  return productStore.productList.reduce((acc, curr) => {
    const category = curr.category
    if (!seen.has(category)) {
      seen.add(category)
      const active = productData.value.some((item) => item.category === category)
      acc.push({ category, active })
    }
    return acc
  }, [])
})

const handleChange = (event) => {
  selectedCategory.value = event.target.value.trim()
}

onMounted(async () => {
  if (
    (!productStore?.productList?.length || !productData.value.length) &&
    !searchValue.length &&
    !selectedCategory.length
  ) {
    if (!productStore?.productList?.length) {
      await productStore._loadProducts()
    }
    isLoading.value = false
    productData.value = [...productStore?.productList]
  }
})
</script>
<template>
  <div class="h-full">
    <div v-if="isLoading" class="bg-black/20 w-full h-full flex items-center justify-center">
      <svg
        class="size-10 animate-spin text-white"
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
          <div>
            <input
              v-model="searchValue"
              class="rounded-full text-sm pl-4 placeholder:text-sm placeholder:text-gray-400"
              placeholder="Search for products"
            />
          </div>
          <div>
            <select
              class="bg-gray-50 border text-sm text-gray-700 capitalize font-semibold rounded-full pl-5 selected"
              @change="handleChange($event)"
            >
              <option value="" class="text-gray-400" selected>Select Category</option>

              <div v-if="categoryItem.length">
                <template v-for="item in categoryItem">
                  <option
                    :disabled="!item.active"
                    :class="[
                      !item.active && 'bg-gray-500/10',
                      item.active && 'bg-white font-semibold',
                    ]"
                    :value="item.category"
                  >
                    {{ item.category }}
                  </option>
                </template>
              </div>
            </select>
          </div>
        </div>
      </div>

      <div
        class="flex-1 h-200 mt-5 grid lg:grid-cols-5 xl:grid-cols-6 md:grid-cols-4 sm:grid-cols-2 space-x-3 space-y-5 overflow-auto"
      >
        <template v-for="item in productData">
          <Card :product="item" />
        </template>
      </div>
    </div>
  </div>
  <Dialog />
</template>
