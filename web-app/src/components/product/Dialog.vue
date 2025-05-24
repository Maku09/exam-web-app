<script setup>
  import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle,
  } from "@headlessui/vue";
  import useStore from "@/stores/";
  import Button from "@/components/common/Button.vue";
  import useProductStore from "@/stores/product";

  const store = useStore();
  const productStore = useProductStore();
  const handleDelete = async () => {
    await productStore._deleteProduct(store.selectedDeleteItem);
    alert("Product delete successfully.");
    store.toggleDeleteDialog();
  };
</script>

<template>
  <TransitionRoot
    appear
    :show="store.deleteDialog"
    as="template"
  >
    <Dialog
      as="div"
      @close="store.toggleDeleteDialog()"
      class="relative z-10"
    >
      <TransitionChild
        as="template"
        enter="duration-300 ease-out"
        enter-from="opacity-0"
        enter-to="opacity-100"
        leave="duration-200 ease-in"
        leave-from="opacity-100"
        leave-to="opacity-0"
      >
        <div class="fixed inset-0 bg-black/25" />
      </TransitionChild>

      <div class="fixed inset-0 overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4 text-center">
          <TransitionChild
            as="template"
            enter="duration-300 ease-out"
            enter-from="opacity-0 scale-95"
            enter-to="opacity-100 scale-100"
            leave="duration-200 ease-in"
            leave-from="opacity-100 scale-100"
            leave-to="opacity-0 scale-95"
          >
            <DialogPanel
              class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all"
            >
              <DialogTitle
                as="h3"
                class="text-lg font-medium leading-6 text-gray-900"
              >
                Confirm the action
              </DialogTitle>
              <div class="mt-2">
                <p class="text-sm text-gray-500">
                  Are you sure you want to delete the selected item?
                </p>
              </div>

              <div class="mt-4">
                <Button
                  class="hover:!bg-gray-100"
                  @click="handleDelete"
                >
                  Confirm
                </Button>
                <Button
                  class="ml-2 bg-red-300 hover:!bg-red-200"
                  @click="store.toggleDeleteDialog()"
                >
                  Cancel
                </Button>
              </div>
            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>
