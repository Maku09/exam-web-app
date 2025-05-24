<script setup>
  import { EllipsisVerticalIcon, PencilIcon, TrashIcon } from "@heroicons/vue/20/solid";
  import { Menu, MenuButton, MenuItems, MenuItem } from "@headlessui/vue";
  import { useRouter } from "vue-router";
  import { useAuthStore } from "@/stores/auth";
  import { computed } from "vue";
  import useStore from "@/stores";

  const store = useStore();
  const authStore = useAuthStore();
  const router = useRouter();
  const props = defineProps({
    product: Object,
  });

  // interface Product {
  //   id: number;
  //   name: string;
  //   created_by: number;
  // }

  // const props = defineProps<{
  //   product: Product;
  // }>();

  const isAllowed = computed(() => {
    return props?.product?.created_by === authStore.user.id || authStore.user.is_admin;
  });
</script>
<template>
  <Menu as="div">
    <MenuButton
      class="absolute right-0 invisible rounded-full size-6 group-hover:visible bg-gray-900/10 flex items-center justify-center"
    >
      <EllipsisVerticalIcon class="w-5 h-5 text-gray-600" />
    </MenuButton>

    <transition
      enter-active-class="transition duration-100 ease-out"
      enter-from-class="transform scale-95 opacity-0"
      enter-to-class="transform scale-100 opacity-100"
      leave-active-class="transition duration-75 ease-in"
      leave-from-class="transform scale-100 opacity-100"
      leave-to-class="transform scale-95 opacity-0"
    >
      <MenuItems
        class="absolute right-0 mt-2 w-35 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none"
      >
        <div class="p-1">
          <MenuItem v-slot="{ active }">
            <button
              :class="[
                active ? 'bg-blue-500 text-white' : 'text-gray-900',
                'group flex w-full items-center !text-sm rounded-md p-3 ',
                !isAllowed && 'opacity-50',
              ]"
              @click="router.push({ name: 'ProductEdit', params: { id: props?.product?.id } })"
              :disabled="!isAllowed"
            >
              <PencilIcon
                :active="active"
                class="mr-2 h-5 w-5 text-blue-400"
                aria-hidden="true"
              />
              Edit
            </button>
          </MenuItem>
          <MenuItem v-slot="{ active }">
            <button
              :class="[
                active ? 'bg-red-500 text-white' : 'text-gray-900',
                'group flex w-full items-center !text-sm rounded-md p-3',
                !isAllowed && 'opacity-50',
              ]"
              @click="store.toggleDeleteDialog(props?.product?.id)"
              :disabled="!isAllowed"
            >
              <TrashIcon
                :active="active"
                class="mr-2 h-5 w-5 text-red-400"
                aria-hidden="true"
              />
              Delete
            </button>
          </MenuItem>
        </div>
      </MenuItems>
    </transition>
  </Menu>
</template>
