import { defineStore } from 'pinia'
import { ref } from 'vue'
import * as productServices from '@/api/services/product'

interface ProductInfo {
  category: string
  description: string
  id: number
  image: string
  price: string
  title: string
}

interface State {
  productList: ProductInfo[]
}

const useProductStore = defineStore('product', () => {
  const productList = ref([] as State['productList'])
  async function _load(page: number = 1, search: string = '', filter: number | null = null) {
    try {
      const { data } = await productServices.getProduct()
      productList.value = data
    } catch (err) {
      console.log(err)
    }
  }

  async function _create(form: Object) {
    try {
      const { data } = await productServices.createProduct(form)
      productList.value.unshift(data)
    } catch (err) {
      console.log(err)
    }
  }

  return {
    _load,
    _create,
    productList,
  }
})

export default useProductStore
