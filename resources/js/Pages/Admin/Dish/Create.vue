<script setup>
import PageTitle from '@/Components/UI/PageTitle.vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';
import FormInputText from '@/Components/form/FormInputText.vue'
import ImagePreview from '@/Components/Image/ImagePreview.vue';
import FormInputImage from '@/Components/form/FormInputImage.vue';
import AppButton from '@/Components/UI/AppButton.vue';
import SwitchButton from '@/Components/UI/SwitchButton.vue';


const form = useForm({
  name: "",
  price: 0,
  image: null,
  ingredients: "",
  active: false
})


const submit = () => {

  form.post(route('admin.dish.store'))
}

const allowedMediaTypes = ["image/jpg", "image/jpeg", "image/png", "image/webp"];

const handleSelectedMedia = (files) => {
  Array.from(files).forEach((file) => {
    if (allowedMediaTypes.includes(file.type)) {
      form.image = file;
    } else {
      alert("Invalid file type");
    }
  });
};



</script>
<template>

  <Head title="Add Dish"></Head>
  <PageTitle>
    Add Dish
  </PageTitle>
  <ImagePreview class="max-w-md m-auto my-10" v-if="form.image" :image="form.image" />
  <form enctype="multipart/form-data" class="max-w-md mx-auto mt-10" @submit.prevent="submit">
    <div class="flex">
      <FormInputText label="Name" v-model="form.name" :error="form.errors.name" />
      <FormInputText step=".01" label="Price" v-model="form.price" :error="form.errors.price" type="number" />
    </div>
    <div class="flex">
      <FormInputText style="width: 100%;" label="Ingredients (Use commas to separate)" v-model="form.ingredients"
        :error="form.errors.ingredients" />
    </div>
    <div>
      <FormInputImage label="Dish Image" @selected="handleSelectedMedia" :error="form.errors.image" />
      <SwitchButton class="my-4" v-model="form.active" label="Activate" />

    </div>
    <AppButton class="mb-4 px-10" type="submit">
      Add
    </AppButton>
  </form>

</template>