<script setup>
  import Button from "@/components/common/Button.vue";
  import Input from "@/components/common/Input.vue";
  import { useAuthStore } from "@/stores/auth";
  import useVuelidate from "@vuelidate/core";
  import { email, minLength, required } from "@vuelidate/validators";
  import { ref } from "vue";
  import { useRouter } from "vue-router";

  const authStore = useAuthStore();
  const router = useRouter();

  const initialValue = {
    email: "user@gmail.com",
    password: "user123",
  };

  const form = ref({ ...initialValue });

  const rules = {
    email: { required, minLength: minLength(4), email },
    password: { required },
  };

  const formValidate = useVuelidate(rules, form);

  const handleSubmit = async () => {
    const isValid = await formValidate.value.$validate();
    if (isValid) {
      await authStore.login(form.value);
      router.push({ name: "ProductList" });
    }
  };
</script>

<template>
  <div class="flex flex-row w-[700px] h-[600px] justify-center shadow-lg rounded-lg">
    <!-- logo -->
    <div class="content-center bg-indigo-700 w-full rounded-s-lg">
      <img
        src="@/assets/product.svg"
        alt="example image"
        class="h-48 w-50 object-contain justify-self-center"
      />
    </div>
    <div class="flex flex-col items-center px-3 py-5">
      <!-- FORM TITLE -->
      <p class="text-4xl font-bold text-gray-900 tracking-wide mt-10">LOGIN PAGE</p>
      <!-- FORM -->
      <form @submit.prevent="handleSubmit">
        <div class="flex flex-col space-y-3 mt-10 w-[400px] px-5">
          <Input
            label="Email"
            v-model="form.email"
            required
            :errors="formValidate.email"
          />
          <Input
            label="Password"
            v-model="form.password"
            required
            type="password"
            :errors="formValidate.password"
          />
          <Button class="mt-4 bg-indigo-700 text-white">Submit</Button>
        </div>
      </form>
    </div>
  </div>
</template>
