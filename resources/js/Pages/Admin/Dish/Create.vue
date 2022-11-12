<script setup>
import PageTitle from '@/Components/UI/PageTitle.vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';
import FormInputText from '@/Components/form/FormInputText.vue'
import ImagePreview from '@/Components/Image/ImagePreview.vue';
import FormInputImage from '@/Components/form/FormInputImage.vue';


const form = useForm({
  name: "",
  price: 0,
  image: null
})

const submit = () => {
  form.post(route('admin.dish.store'))
}

const allowedMediaTypes = ["image/jpg", "image/jpeg", "image/png"];

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
  <form class="max-w-md mx-auto mt-10" @submit.prevent="submit">
    <div class="flex">
      <FormInputText label="Name" v-model="form.name" :error="form.errors.name" />
      <FormInputText label="Price" v-model="form.price" :error="form.errors.price" />
    </div>
    <div>
      <FormInputImage label="Dish Image" @selected="handleSelectedMedia" />
    </div>
  </form>
  <ImagePreview v-if="form.image" :image="form.image" />
</template>