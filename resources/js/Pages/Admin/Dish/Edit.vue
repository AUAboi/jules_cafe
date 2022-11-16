<script setup>
import PageTitle from '@/Components/UI/PageTitle.vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';
import FormInputText from '@/Components/form/FormInputText.vue'
import ImagePreview from '@/Components/Image/ImagePreview.vue';
import FormInputImage from '@/Components/form/FormInputImage.vue';
import AppButton from '@/Components/UI/AppButton.vue';
import SwitchButton from '@/Components/UI/SwitchButton.vue';
import { onMounted } from 'vue';

const props = defineProps({
  dish: {
    required: true,
    type: Object
  }
})


const urlToImageFile = async (url) => {
  let image = null
  if (url) {
    let result = await fetch(url);
    let blob = await result.blob()
    image = new File([blob], 'image.jpg', blob)
  }
  return image
}


const form = useForm({
  '_method': 'put',
  name: props.dish.name,
  price: props.dish.price,
  image: null,
  active: props.dish.active
})


const submit = () => {
  form.post(route('admin.dish.update', props.dish.id))
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
const setFormValues = async () => {
  form.image = await urlToImageFile(props.dish.image)
}
onMounted(setFormValues)
</script>
<template>

  <Head :title="`Edit ${form.name}`"></Head>
  <PageTitle>
    Edit Dish
  </PageTitle>
  {{ form }}
  <ImagePreview class="max-w-md m-auto my-10" v-if="form.image" :image="form.image" />
  <h2 class="text-center text-2xl my-10">No image associated with this dish.</h2>
  <form enctype="multipart/form-data" class="max-w-md mx-auto mt-10" @submit.prevent="submit">
    <div class="flex">
      <FormInputText label="Name" v-model="form.name" :error="form.errors.name" />
      <FormInputText label="Price" v-model="form.price" :error="form.errors.price" type="number" />
    </div>
    <div>
      <FormInputImage label="Dish Image" @selected="handleSelectedMedia" :error="form.errors.image" />
      <SwitchButton class="my-4" v-model="form.active" label="Activate" />

    </div>
    <AppButton class="mb-4 px-10" type="submit">
      Edit
    </AppButton>
  </form>

</template>