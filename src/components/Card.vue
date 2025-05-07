<script setup>
import CardMenu from '@/components/CardMenu.vue'

const props = defineProps({
  product: Object,
})

const categoryColor = {
  jewelery: 'text-white bg-pink-400',
  "men's clothing": 'text-gray-700 bg-cyan-400',
  "women's clothing": 'text-white bg-indigo-400',
  electronics: 'text-white bg-red-400',
}

const getCategoryColor = (category) => {
  return categoryColor[category]
}
</script>
<template>
  <div class="px-2 py-3 shadow bg-white rounded-lg hover:shadow-xl">
    <div class="relative group">
      <CardMenu :id="props.product.id" :class="[props?.product?.id > 20 && 'hidden']" />
      <img
        class="h-60 w-full object-contain ..."
        :alt="props.product.title"
        :src="props.product.image"
      />
      <div
        :class="[props?.product?.id > 20 && '!invisible']"
        class="invisible group-hover:visible absolute bottom-0 bg-emerald-500/50 h-8 w-full content-center text-center text-emerald-900 font-bold hover:underline"
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
        :class="getCategoryColor(props.product.category)"
      >
        {{ props.product.category }}
      </span>

      <div class="text-red-400 font-bold mt-2 px-0.5">${{ props.product.price }}</div>
    </div>
  </div>
</template>
