import { defineStore } from 'pinia'
import { ref } from 'vue'
import * as productServices from '@/api/services/product'

interface Category {
  id: number;
  name: string;
}

interface ProductInfo {
  id: number;
  title: string;
  description: string;
  category_id: number;
  product_photos: string[];
  category: Category;
}

interface Meta {
  current_page: number;
  from: number;
  last_page: number;
  per_page: number;
  to: number;
  total: number;
}

interface State {
  productList: ProductInfo[];
  meta: Meta | null;
}
const useProductStore = defineStore('product', () => {
  const productList = ref([] as State['productList'])
  const meta = ref<Meta | null>(null);
  const selectedProduct = ref(null)

  async function _loadProducts() {
    try {
      const { data: response } = await productServices.getProduct()
      productList.value = response.data.items;
      meta.value = response.data.meta;
    } catch (err) {
      alert('Error. Please reload.')
      console.error('Axios error:', err)
    }
  }

  async function _selectProduct(id: number) {
    try {
      return await productServices.getProductDetail(id)
    } catch (err: any ) {
      alert('Error: ' + (err?.message || 'Something went wrong.'));
      console.error('Axios error:', err)
    }
  }

  async function _createProduct(form: FormData) {
    try {
      const data = await productServices.createProduct(form)
      // productList.value.unshift(data)
      return data
    } catch (err: any) {
      if (err?.status === 422) {
        alert('Validation Error: ' + (err?.response?.data?.message || 'Invalid input.'));
      } else {
        alert('Error: ' + (err?.message || 'Something went wrong.'));
      }
      return err;
    }
  }

//   async function _updateProduct(id: number, form: Object) {
//     try {
//       const { data } = await productServices.updateProduct(id, form)
//       let currIndex = productList.value.findIndex((item) => item.id === data.id)
//       productList.value[currIndex] = data
//     } catch (err) {
//       alert('Error. Please reload.')
//       console.error('Axios error:', err)
//     }
//   }

  async function _deleteProduct(id: number) {
    try {
      const response = await productServices.deleteProduct(id)
      if(response.status === 200){
        let currIndex = productList.value.findIndex((item) => item.id === id)
      console.log(currIndex, productList.value)
        if (currIndex !== -1) {
          productList.value.splice(currIndex, 1)
        }
      }
    } catch (err: any) {
      if (err?.status === 422) {
        alert('Validation Error: ' + (err?.response?.data?.message || 'Invalid input.'));
      } else {
        alert('Error: ' + (err?.message || 'Something went wrong.'));
      }
      return err;
    }
  }

  return {
    _loadProducts,
    meta,
    _selectProduct,
    _createProduct,
    // _updateProduct,
    _deleteProduct,
    productList,
    selectedProduct,
  }
})

export default useProductStore