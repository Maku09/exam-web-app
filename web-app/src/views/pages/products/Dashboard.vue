<script setup>
  import Button from "@/components/common/Button.vue";
  import Loading from "@/components/Loading.vue";
  import Card from "@/components/product/Card.vue";
  import Dialog from "@/components/product/Dialog.vue";
  import router from "@/router";
  import useProductStore from "@/stores/product";
  import { PlusIcon } from "@heroicons/vue/20/solid";
  import { onMounted, ref } from "vue";

  const productStore = useProductStore();

  const productData = ref([]);
  const isLoading = ref(true);

  onMounted(async () => {
    if (!productStore?.productList?.length) {
      if (!productStore?.productList?.length) {
        await productStore._loadProducts();
      }
    }
    isLoading.value = false;
  });
</script>
<template>
  <Loading v-if="isLoading" />
  <div
    v-else
    class="flex flex-col p-5 h-full"
  >
    <!-- tool -->
    <div class="text-2xl font-semibold text-gray-500 uppercase">Product List</div>
    <div class="flex justify-between items-center">
      <div class="mt-5">
        <Button
          @click="router.push({ name: 'ProductCreate' })"
          class="bg-indigo-700 text-white"
          :left-icon="PlusIcon"
          >Create</Button
        >
      </div>
    </div>

    <!-- PRODUCT LIST -->
    <div
      class="flex-1 h-200 mt-5 grid lg:grid-cols-5 xl:grid-cols-6 md:grid-cols-4 sm:grid-cols-2 space-x-3 space-y-5 overflow-auto"
    >
      <template v-for="item in productStore?.productList">
        <Card :product="item" />
      </template>
    </div>
  </div>
  <Dialog />
</template>
