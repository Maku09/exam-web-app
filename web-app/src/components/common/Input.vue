<script setup>
  import { v4 as uuid } from "uuid";
  const modelValue = defineModel("modelValue");
  // const emit = defineEmits(["update:modelValue"]);
  const props = defineProps({
    label: String,
    errors: Array | null,
    required: Boolean,
    type: String,
    step: String | null,
    placeholder: String,
  });

  const id = uuid();
</script>

<template>
  <label
    :for="id"
    class="mb-2 font-semibold text-gray-700"
    >{{ props.label }} <span class="text-red-500">{{ props.required ? "*" : "" }}</span>
  </label>
  <input
    :id="id"
    class="rounded mb-1"
    v-model="modelValue"
    :type="props.type"
    :placeholder="props.placeholder"
    :step="props.step"
  />

  <div class="text-red-500">
    <span class="text-sm px-2">
      {{ props.errors?.$error ? props.errors?.$errors[0].$message : "" }}
    </span>
  </div>
</template>
