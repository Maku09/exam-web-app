<script setup>
  import { PhotoIcon, XMarkIcon } from "@heroicons/vue/20/solid";
  import { computed, ref } from "vue";

  const modelValue = defineModel("modelValue");
  const props = defineProps({
    errors: Object,
  });

  const dragging = ref(false);
  const attachment = ref([]);

  const onDroppedFiles = $event => {
    let files = [...$event.dataTransfer.items].map(item => item.getAsFile());

    loadFile(files);
  };

  function onSelectFile($event) {
    let files = [...$event.target.files];
    loadFile(files);
    attachment.value = null;
  }

  let fileName = computed(() => {
    const allName = modelValue.value?.map(file =>
      "file_name" in file ? file.file_name : file.name
    );
    return allName;
  });

  const fileRules = computed(() => {
    let rules = {
      word: [
        "application/msword",
        "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
      ],
      pdf: ["application/pdf"],
      img: ["image/png", "image/jpg", "image/jpeg"],
    };

    let selectedRule = ["img"].reduce((accu, curr) => {
      let rule = rules[curr];
      return [...accu, ...rule];
    }, []);

    return selectedRule;
  });

  function loadFile(dataFile) {
    let collectFiles = dataFile.filter(
      item => fileRules.value.includes(item.type) && !fileName.value.includes(item.name)
    );

    if (collectFiles.length !== dataFile.length) {
      alert("Only image file allowed to add and not allowed to add same file name");
    }

    const fr = new FileReader();

    collectFiles.forEach(item => {
      fr.readAsDataURL(item);
      fr.addEventListener("load", () => {
        const url = fr.result;
        modelValue.value.push({ file_name: item.name, url });
      });
    });
  }

  function removeFile(index) {
    modelValue.value.splice(index, 1);
  }
</script>
<template>
  <div class="flex flex-col p-2 mb-2 h-full w-full">
    <div class="w-full max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div
        @drop.prevent="onDroppedFiles"
        @dragover.prevent="dragging = true"
        @dragleave.prevent="dragging = false"
        :class="[
          dragging ? 'border-indigo-500' : 'border-gray-400',
          'flex flex-col border-2 items-center py-12 px-6 border-dashed ',
          errors.length && '!border-red-500',
        ]"
      >
        <PhotoIcon class="w-12 h-12 text-gray-500" />
        <p class="text-xl text-gray-800">Drop files to upload</p>
        <p class="mb-2">or</p>
        <label
          class="bg-white px-4 h-9 inline-flex items-center rounded border border-gray-300 text-sm shadow-sm text-gray-700 focus-within:ring-2 focus-within:ring-indigo-500"
        >
          Select files
          <input
            type="file"
            name="file"
            ref="attachment"
            @input="onSelectFile"
            accept="image/png,image/jpeg"
            multiple
            class="sr-only"
          />
        </label>
        <p class="text-xs text-gray-700 mt-4">Maximum upload file size: 512MB.</p>
        <div class="p-2 h-2 text-red-500">
          <span class="text-sm px-2">{{ errors.length ? errors[0].$message : "" }}</span>
        </div>
      </div>
      <div
        v-if="modelValue.length"
        class="mt-10"
      >
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg max-h-[230px] overflow-y-auto">
          <table class="w-full text-sm text-left rtl:text-right text-gray-500">
            <thead class="text-gray-700 uppercase bg-gray-50">
              <tr>
                <th
                  scope="col"
                  class="px-3 py-3"
                ></th>
                <th
                  scope="col"
                  class="px-6 py-3 text-ellipsis"
                >
                  Product file name
                </th>
                <th
                  scope="col"
                  class="px-6 py-3"
                >
                  Photo
                </th>
                <th
                  scope="col"
                  class="px-6 py-3"
                ></th>
              </tr>
            </thead>
            <tbody>
              <tr
                class="bg-white hover:bg-gray-50"
                v-for="(file, index) in modelValue"
              >
                <template v-if="Object.keys(file).length === 2">
                  <th
                    scope="row"
                    class="px-3 py-4"
                  >
                    {{ index + 1 }}
                  </th>
                  <td class="px-6 py-4">{{ file.file_name }}</td>
                  <td>
                    <img
                      width="100"
                      height="100"
                      :src="file.url"
                      :alt="file.file_name"
                    />
                  </td>
                  <td class="text-center w-1">
                    <div
                      class="inline-flex p-1 rounded-full hover:bg-gray-200"
                      @click="removeFile(index)"
                    >
                      <XMarkIcon class="w-7 h-7" />
                    </div>
                  </td>
                </template>
                <template v-else>
                  <th
                    scope="row"
                    class="px-3 py-4"
                  >
                    {{ index + 1 }}
                  </th>
                  <td class="px-6 py-4">{{ file.image_name }}</td>
                  <td>
                    <img
                      width="100"
                      height="100"
                      :src="file?.photo_url"
                      :alt="file?.image_name"
                    />
                  </td>
                  <td class="text-center w-1">
                    <div
                      class="inline-flex p-1 rounded-full hover:bg-gray-200"
                      @click="removeFile(index)"
                    >
                      <XMarkIcon class="w-7 h-7" />
                    </div>
                  </td>
                </template>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>
