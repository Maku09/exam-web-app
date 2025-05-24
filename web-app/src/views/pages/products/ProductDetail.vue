<script setup>
  import Button from "@/components/common/Button.vue";
  import useProductStore from "@/stores/product";
  import { ArrowLeftIcon } from "@heroicons/vue/20/solid";
  import { onMounted, ref } from "vue";
  import { useRoute, useRouter } from "vue-router";

  const route = useRoute();
  const router = useRouter();

  const productDetail = ref();
  const isLoading = ref(true);

  const productStore = useProductStore();

  onMounted(async () => {
    const { data: response } = await productStore._selectProduct(route?.params?.id);
    if (response) {
      isLoading.value = false;
      productDetail.value = response.data;
    }
  });

  const categoryColor = {
    Book: "text-white bg-pink-400",
    Clothes: "text-gray-700 bg-cyan-400",
    Shoes: "text-white bg-green-400",
  };

  const getCategoryColor = category => {
    return categoryColor[category];
  };
</script>

<template>
  <div class="h-full">
    <div
      v-if="isLoading"
      class="bg-black/20 w-full h-full flex items-center justify-center"
    >
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

    <div class="flex flex-col p-5">
      <!-- tool -->
      <div class="text-2xl font-semibold text-gray-500 uppercase">View Product</div>
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

      <div class="flex-1 px-3 mt-10 flex bg-white rounded-full">
        <div class="mx-auto flex items-center px-3 py-7 rounded space-x-5">
          <img
            class="h-96 w-80 object-contain ..."
            :alt="productDetail?.title"
            :src="productDetail?.product_photos[0]?.photo_url"
          />
          <div class="flex flex-col space-y-3 pl-20 w-[780px]">
            <span class="font-bold text-3xl text-gray-800">{{ productDetail?.title }}</span>

            <div>
              <span
                class="mt-2 rounded px-2 py-1 uppercase font-semibold text-sm"
                :class="getCategoryColor(productDetail?.category?.name)"
              >
                {{ productDetail?.category?.name }}
              </span>
            </div>

            <div class="text-gray-700 w-[600px]">{{ productDetail?.description }}</div>
            <div class="text-red-400 font-bold mt-2 px-0.5">${{ productDetail?.price }}</div>
            <!-- <div>Rating: {{ productDetail?.rating?.rate }}</div> -->
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
