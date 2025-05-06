<script setup>
import Button from '@/components/common/Button.vue'
import Input from '@/components/common/Input.vue'
import Select from '@/components/common/Select.vue'
import TextArea from '@/components/common/TextArea.vue'
import { ArrowLeftIcon } from '@heroicons/vue/20/solid'
import { onMounted, ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import useVuelidate from '@vuelidate/core'
import { minLength, numeric, required, url } from '@vuelidate/validators'
import useProductStore from '@/stores/product'

const route = useRoute()
const router = useRouter()

const productStore = useProductStore()

const form = ref({})
const isLoading = ref(true)

onMounted(async () => {
  const { data } = await productStore._selectProduct(route?.params?.id)
  if (data) {
    console.log(data)
    isLoading.value = false
    form.value = data
  }
})

const initialData = {
  id: 0,
  title: '',
  price: 0,
  description: '',
  category: '',
  image: '',
}

const rules = {
  title: { required, minLength: minLength(4) },
  category: { required },
  price: { required, numeric },
  image: { required, url },
  description: { required, minLength: minLength(4) },
}

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

const formValidate = useVuelidate(rules, form)

const handleSubmit = async () => {
  const isValid = await formValidate.value.$validate()
  if (isValid) {
    await productStore._updateProduct(form.value.id, form.value)
    alert('Product update successfully.')

    form.value = initialData
    router.push({ name: 'ProductList' })
  }
}
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

    <div v-else class="flex flex-col px-10">
      <div class="shrink-0 flex flex-row mt-10 justify-between px-3 py-2">
        <div>
          <Button
            class="bg-indigo-600 text-white"
            :leftIcon="ArrowLeftIcon"
            @click="router.push({ name: 'ProductList' })"
            >Back</Button
          >
        </div>
      </div>

      <div class="flex flex-col px-10">
        <!--  -->
        <div class="flex-1 px-3 mt-5 flex rounded-full flex-col">
          <div class="font-semibold text-gray-700 text-2xl mb-8">Edit Product:</div>
          <form class="h-full flex flex-col space-y-7" @submit.prevent="handleSubmit">
            <div>
              <Input
                label="Product Title"
                required
                type="text"
                v-model="form.title"
                :errors="formValidate.title.$errors"
              />
            </div>
            <div>
              <Select
                label="Select Category"
                :items="categoryItem"
                required
                v-model="form.category"
                :errors="formValidate.category.$errors"
              />
            </div>
            <div>
              <TextArea
                label="Description"
                required
                v-model="form.description"
                :errors="formValidate.description.$errors"
              />
            </div>
            <div>
              <Input
                label="Product Title"
                required
                type="number"
                step="any"
                v-model="form.price"
                :errors="formValidate.price.$errors"
              />
            </div>
            <div>
              <Input
                label="Image"
                required
                type="text"
                v-model="form.image"
                :errors="formValidate.image.$errors"
              />
            </div>

            <Button class="mt-5 bg-blue-600 text-white">Submit</Button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
