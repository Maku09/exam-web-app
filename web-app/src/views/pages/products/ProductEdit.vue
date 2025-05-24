<script setup>
  import Button from "@/components/common/Button.vue";
  import Input from "@/components/common/Input.vue";
  import Select from "@/components/common/Select.vue";
  import FileInput from "@/components/common/FileInput.vue";
  import TextArea from "@/components/common/TextArea.vue";
  import Loading from "@/components/Loading.vue";
  import { ArrowLeftIcon } from "@heroicons/vue/20/solid";
  import { onMounted, ref } from "vue";
  import { useRoute, useRouter } from "vue-router";
  import useVuelidate from "@vuelidate/core";
  import { minLength, numeric, required } from "@vuelidate/validators";
  import useProductStore from "@/stores/product";

  const router = useRouter();
  const route = useRoute();

  const productStore = useProductStore();

  const initialData = {
    title: "",
    price: 0,
    description: "",
    category_id: "",
    product_photos: [],
    old_photos: [],
  };
  const form = ref({});

  const isLoading = ref(true);

  onMounted(async () => {
    const { data: response } = await productStore._selectProduct(route?.params?.id);
    if (response.data) {
      isLoading.value = false;
      form.value = {
        ...response.data,
        old_photos: [],
      };
    }
  });

  const rules = {
    title: { required, minLength: minLength(4) },
    category_id: { required },
    price: { required, numeric },
    product_photos: { required },
    description: { required, minLength: minLength(10) },
  };

  const categoryItem = [
    {
      key: 1,
      value: "Book",
    },
    {
      key: 2,
      value: "Clothes",
    },
    {
      key: 3,
      value: "Shoes",
    },
  ];

  const formValidate = useVuelidate(rules, form);

  const handleSubmit = async () => {
    const isValid = await formValidate.value.$validate();
    if (isValid) {
      //remove already insert photo
      form.value.new_photos = form.value.product_photos.filter(photo => !photo.id);

      const { status } = await productStore._updateProduct(form.value, form.value.id);
      if (status === 200) {
        form.value = initialData;
        router.push({ name: "ProductList" });
      }
    }
  };

  const removeFile = file_id => {
    form.value.old_photos.push(file_id);
  };
</script>

<template>
  <Loading v-if="isLoading" />
  <div
    v-else
    class="flex flex-col p-5 h-full"
  >
    <!-- tool -->
    <div class="text-2xl font-semibold text-gray-500 uppercase">Add Product</div>
    <div class="flex justify-between items-center">
      <div class="mt-5">
        <Button
          class="bg-gray-300"
          :leftIcon="ArrowLeftIcon"
          @click="router.push({ name: 'ProductList' })"
          >Back</Button
        >
      </div>
    </div>
    <div class="flex-1 px-3 mt-5 rounded-full">
      <form @submit.prevent="handleSubmit">
        <div class="flex flex-row space-x-10">
          <div class="flex-1 flex flex-col">
            <div class="flex flex-col flex-1 mb-3">
              <Input
                label="Product Title"
                required
                type="text"
                v-model="form.title"
                :errors="formValidate.title"
              />
            </div>
            <div class="mb-7">
              <Select
                label="Select Category"
                :items="categoryItem"
                required
                v-model="form.category_id"
                :errors="formValidate.category_id.$errors"
              />
            </div>
            <div class="flex flex-col flex-1 mb-4">
              <Input
                label="Price"
                required
                type="number"
                step="any"
                v-model="form.price"
                :errors="formValidate.price"
              />
            </div>
            <div class="mb-5">
              <TextArea
                label="Description"
                required
                v-model="form.description"
                :errors="formValidate.description.$errors"
              />
            </div>
          </div>
          <div class="flex-1">
            <FileInput
              @remove-event="removeFile"
              v-model="form.product_photos"
              :errors="formValidate.product_photos.$errors"
            />
          </div>
        </div>
        <Button class="mt-5 bg-indigo-600 text-white">Submit</Button>
      </form>
    </div>
  </div>
</template>
