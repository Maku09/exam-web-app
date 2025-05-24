<script setup>
  import CardMenu from "@/components/product/CardMenu.vue";

  const props = defineProps({
    product: Object,
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
  <div class="px-2 py-3 shadow bg-white rounded-lg hover:shadow-xl">
    <div class="relative group">
      <CardMenu :product="props.product" />
      <img
        class="h-60 w-full object-contain ..."
        :alt="props.product.title"
        loading="lazy"
        :src="props?.product?.product_photos[0]?.photo_url"
      />
      <div
        :class="[props?.product?.id > 20 && '!invisible']"
        class="invisible group-hover:visible absolute bottom-0 bg-indigo-500/50 h-8 w-full content-center text-center text-indigo-900 font-bold hover:underline"
      >
        <RouterLink :to="{ name: 'ProductDetail', params: { id: props.product.id } }"
          >View</RouterLink
        >
      </div>

      <!-- <div class="invisible group-hover:visible">testing</div> -->
    </div>
    <div class="mt-2 px-1.5">
      <div class="line-clamp-2 h-13.5 px-0.5">{{ props.product.title }}</div>
      <span
        class="mt-2 rounded px-2 py-1 uppercase font-semibold text-sm"
        :class="getCategoryColor(props.product.category.name)"
      >
        {{ props.product.category.name }}
      </span>

      <div class="text-red-400 font-bold mt-2 px-0.5">${{ props.product.price }}</div>
    </div>
  </div>
</template>
