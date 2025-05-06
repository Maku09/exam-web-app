<script setup>
import { EllipsisVerticalIcon, PencilIcon, TrashIcon } from '@heroicons/vue/20/solid'
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const props = defineProps({
  id: Number,
})
</script>
<template>
  <Menu as="div">
    <MenuButton
      class="absolute right-0 invisible rounded-full size-6 group-hover:visible bg-gray-900/10 flex items-center justify-center"
    >
      <component :is="EllipsisVerticalIcon"></component>
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
        class="absolute right-0 mt-2 w-25 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none"
      >
        <div class="pa-1">
          <MenuItem v-slot="{ active }">
            <button
              :class="[
                active ? 'bg-blue-500 text-white' : 'text-gray-900',
                'group flex w-full items-center rounded-md px-2 py-2 text-xs',
              ]"
              @click="router.push({ name: 'ProductEdit', params: { id: props.id } })"
            >
              <PencilIcon :active="active" class="mr-2 h-4 w-4 text-blue-400" aria-hidden="true" />
              Edit
            </button>
          </MenuItem>
          <MenuItem v-slot="{ active }">
            <button
              :class="[
                active ? 'bg-red-500 text-white' : 'text-gray-900',
                'group flex w-full items-center rounded-md px-2 py-2 text-xs',
              ]"
            >
              <TrashIcon :active="active" class="mr-2 h-4 w-4 text-red-400" aria-hidden="true" />
              Delete
            </button>
          </MenuItem>
        </div>
      </MenuItems>
    </transition>
  </Menu>
</template>
