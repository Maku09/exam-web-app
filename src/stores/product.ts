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
  const selectedProduct = ref(null)

  async function _loadProducts() {
    try {
      const { data } = await productServices.getProduct()
      productList.value = [...data]
    } catch (err) {
      console.log(err)
    }
  }

  async function _selectProduct(id: number) {
    try {
      return await productServices.getProductDetail(id)
      // selectedProduct.value = data
    } catch (err) {
      console.log(err)
    }
  }

  async function _createProduct(form: Object) {
    try {
      const { data } = await productServices.createProduct(form)
      productList.value.unshift(data)
    } catch (err) {
      console.log(err)
    }
  }

  async function _updateProduct(id: number, form: Object) {
    try {
      const { data } = await productServices.updateProduct(id, form)
      let currIndex = productList.value.findIndex((item) => item.id === data.id)
      productList.value[currIndex] = data
    } catch (err) {
      console.log(err)
    }
  }

  async function _deleteProduct(id: number) {
    try {
      const { data } = await productServices.deleteProduct(id)
      let currIndex = productList.value.findIndex((item) => item.id === data.id)
      if (currIndex !== -1) {
        productList.value.splice(currIndex, 1)
      }
    } catch (err) {
      console.log(err)
    }
  }

  return {
    _loadProducts,
    _selectProduct,
    _createProduct,
    _updateProduct,
    _deleteProduct,
    productList,
    selectedProduct,
  }
})

export default useProductStore
