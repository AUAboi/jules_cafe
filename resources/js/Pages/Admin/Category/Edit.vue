<script setup>
import PageTitle from '@/Components/UI/PageTitle.vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';
import FormInputText from '@/Components/form/FormInputText.vue'
import ImagePreview from '@/Components/Image/ImagePreview.vue';
import FormInputImage from '@/Components/form/FormInputImage.vue';
import AppButton from '@/Components/UI/AppButton.vue';
import SwitchButton from '@/Components/UI/SwitchButton.vue';
import { onMounted } from 'vue';
import DataTable from '@/Components/Table/DataTable.vue';

const props = defineProps({
  category: {
    required: true,
    type: Object
  }
})


const form = useForm({
  '_method': 'put',
  name: props.category.name,
  image: null,
  active: props.category.active
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



const submit = () => {
  form.post(route('admin.category.update', props.category.id))
}
const destroy = () => {
  if (confirm('Do you really want to delete'))

    form.delete(route('admin.category.destroy', props.category.id))
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
  form.image = await urlToImageFile(props.category.image)
}
onMounted(setFormValues)
</script>
<template>

  <Head :title="`Edit ${form.name}`"></Head>
  <PageTitle>
    Edit category
  </PageTitle>
  <ImagePreview class="max-w-md m-auto my-10" v-if="form.image" :image="form.image" />
  <h2 v-else class="text-center text-2xl my-10">No image associated with this category.</h2>
  <form id="edit-form" enctype="multipart/form-data" class="max-w-md mx-auto mt-10" @submit.prevent="submit">
    <div class="flex">
      <FormInputText label="Name" v-model="form.name" :error="form.errors.name" />
    </div>
    <div>
      <FormInputImage label="Category Image" @selected="handleSelectedMedia" :error="form.errors.image" />
      <SwitchButton class="my-4" v-model="form.active" label="Activate" />

    </div>
    <div class="flex justify-between">
      <AppButton form="edit-form" class="mb-4 px-10" type="submit">
        Save
      </AppButton>

      <form @submit.prevent="destroy" id="delete-form" class="m-0">
        <button form="delete-form" :disabled="form.processing" type="submit" class="hover:underline text-red-600 ">
          Delete
        </button>
      </form>
    </div>
  </form>
</template>
