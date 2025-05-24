<script setup lang="ts">
  import { v4 as uuid } from "uuid";
  const modelValue = defineModel("modelValue");

  interface IDropdownListItem {
    key: any;
    icon: string;
    label: string;
    value: string;
    isBoolean: boolean;
    isCategory?: boolean;
  }

  interface IError {
    $error: boolean;
    $message: string;
  }

  interface Props {
    label?: string;
    items?: Array<IDropdownListItem>;
    // errors: IError[];
    required?: boolean;
  }

  const props = withDefaults(defineProps<Props>(), {
    label: "label",
    items: Array,
  });

  const id = uuid();
</script>

<template>
  <label
    :for="id"
    class="block mb-2 font-medium text-gray-900"
  >
    {{ props.label }}
    <span class="text-red-600">{{ props.required ? "*" : "" }}</span>
  </label>
  <select
    :id="id"
    v-model="modelValue"
    class="bg-gray-50 border font-semibold rounded-sm border-gray-300 text-gray-900 focus:ring-primary focus:border-primary block w-full p-2.5"
  >
    <option
      value=""
      selected
      disabled
      hidden
    >
      Select item
    </option>

    <div v-if="props?.items?.length">
      <template v-for="item in props?.items">
        <option :value="item.key">{{ item.value }}</option>
      </template>
    </div>
  </select>
  <!-- v-model="form.name" -->
  <div class="p-2 h-2 text-red-500">
    <span class="text-sm px-2">
      <!-- {{ props.errors.length ? props.errors?.[0]?.$message : "" }} -->
    </span>
  </div>
</template>
