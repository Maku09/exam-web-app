<script setup>
import { getProduct } from '@/api/services/product'
import { onMounted, ref, watch } from 'vue'
import Card from '@/components/Card.vue'
import Button from '@/components/common/Button.vue'
import Dialog from '@/components/Dialog.vue'
import { PlusIcon } from '@heroicons/vue/20/solid'
import { useRouter } from 'vue-router'
import useProductStore from '@/stores/product'

const router = useRouter()

const productStore = useProductStore()

const searchValue = ref('')
const selectedCategory = ref('')

const productData = ref()

let timeout = 200
const searchItem = (search, selectItem) => {
  console.log(search, selectItem)
  clearTimeout(timeout)
  timeout = setTimeout(() => {
    productData.value = productStore?.productList.filter((item) => {
      if (search.length && selectItem.length) {
        return item.title.includes(search) && item.category === selectItem
      } else if (search.length) {
        return item.title.includes(search)
      } else if (selectItem.length) {
        return item.category === selectItem
      } else {
        return true
      }
      // search.length
      //   ? item.title.includes(search)
      //   : false || selectItem.length
      //     ? item.category === selectItem
      //     : true,
    })
  }, 300)
}

watch([searchValue, selectedCategory], ([newSearch, newSelect], [oldSearch, oldSelect]) => {
  searchItem(newSearch, newSelect)
})

const categoryItem = [
  {
    key: 'jewelery',
    value: 'jewelery',
  },
  {
    key: "men's clothing",
    value: "men's clothing",
  },
  {
    key: "women's clothing",
    value: "women's clothing",
  },
  {
    key: 'electronics',
    value: 'electronics',
  },
]

const handleChange = (event) => {
  selectedCategory.value = event.target.value.trim()
}

onMounted(async () => {
  if (!productStore?.productList?.length && !searchValue.length) {
    await productStore._loadProducts()
    productData.value = productStore?.productList
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
        <div>
          <input
            v-model="searchValue"
            class="rounded-full text-sm pl-4 placeholder:text-sm placeholder:text-gray-400"
            placeholder="Search for products"
          />
        </div>
        <div>
          <select
            class="bg-gray-50 border text-sm text-gray-400 font-semibold rounded-full pl-5 selected"
            @change="handleChange($event)"
          >
            <option value="" class="text-gray-300" selected>Select Category</option>

            <div v-if="categoryItem.length">
              <template v-for="item in categoryItem">
                <option :value="item.key">{{ item.value }}</option>
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
  <Dialog />
</template>
