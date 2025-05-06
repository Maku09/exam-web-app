<script setup>
import Button from '@/components/common/Button.vue'
import Input from '@/components/common/Input.vue'
import Select from '@/components/common/Select.vue'
import TextArea from '@/components/common/TextArea.vue'
import { ArrowLeftIcon } from '@heroicons/vue/20/solid'
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import useVuelidate from '@vuelidate/core'
import { minLength, numeric, required, url } from '@vuelidate/validators'
import useProductStore from '@/stores'

const router = useRouter()

const productStore = useProductStore()

const initialData = {
  id: 0,
  title: '',
  price: 0,
  description: '',
  category: '',
  //   category: 'jewelery',
  image: '',
}

const form = ref({ ...initialData })

const rules = {
  title: { required, minLength: minLength(4) },
  category: { required },
  price: { required, numeric },
  image: { required, url },
  description: { required, minLength: minLength(4) },
  //   photos: { required },
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
    await productStore._createProduct(form.value)
    alert('Product created successfully.')

    form.value = initialData
    router.push({ name: 'ProductList' })
  }
}
</script>

<template>
  <div class="flex flex-col px-10">
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

    <div class="flex-1 px-3 mt-5 flex rounded-full flex-col">
      <div class="font-semibold text-gray-700 text-2xl mb-8">Create new products:</div>
      <!-- :errors="formValidate" -->
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
      <!-- <Input label="Name" required type="text" v-model="form.name" />
      <Input label="Name" required type="text" v-model="form.name" /> -->
      <!-- <div class="mx-auto flex items-center px-3 py-7 rounded space-x-5">
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
      </div> -->
    </div>
  </div>
</template>
