<script setup>
  import { v4 as uuid } from "uuid";
  const modelValue = defineModel("modelValue");
  const props = defineProps({
    label: String,
    type: String,
    errors: Array | null,
    required: Boolean,
  });

  const id = uuid();
</script>

<template>
  <label
    :for="id"
    class="block mb-2 font-medium text-gray-900"
  >
    {{ props.label }}
    <span class="text-red-600">{{ required ? "*" : "" }}</span>
  </label>
  <textarea
    :id="id"
    class="bg-gray-50 border rounded-sm border-gray-300 text-gray-900 focus:ring-primary focus:border-primary block w-full p-2.5"
    v-model="modelValue"
    :type="props.type"
  ></textarea>

  <!-- v-model="form.name" -->
  <div class="p-2 h-2 text-red-500">
    <span class="text-sm px-2">
      {{ props.errors?.length ? props.errors?.[0].$message : "" }}
    </span>
  </div>
</template>
