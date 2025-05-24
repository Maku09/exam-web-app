import { defineStore } from 'pinia'
import { ref } from 'vue'

const useStore = defineStore('store', () => {
  const deleteDialog = ref(false)
  const selectedDeleteItem = ref()

  const toggleDeleteDialog = (id: number | null) => {
    selectedDeleteItem.value = id
    deleteDialog.value = !deleteDialog.value
  }

  return {
    toggleDeleteDialog,

    deleteDialog,
    selectedDeleteItem,
  }
})

export default useStore