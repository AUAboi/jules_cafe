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
  },
  category_dishes: Array,
  categories: Array
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
  active: props.dish.active,
  categories: props.categories,
  ingredients: props.dish.ingredients
})



const submit = () => {
  form.post(route('admin.dish.update', props.dish.id))
}
const destroy = () => {
  if (confirm('Do you really want to delete'))
    form.delete(route('admin.dish.destroy', props.dish.id))
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
  <ImagePreview class="max-w-md m-auto my-10" v-if="form.image" :image="form.image" />
  <h2 v-else class="text-center text-2xl my-10">No image associated with this dish.</h2>
  <form id="edit-form" enctype="multipart/form-data" class="max-w-md mx-auto mt-10" @submit.prevent="submit">
    <div class="flex">
      <FormInputText label="Name" v-model="form.name" :error="form.errors.name" />
      <FormInputText label="Price" step=".01" v-model="form.price" :error="form.errors.price" type="number" />
    </div>
    <div class="flex">
      <FormInputText style="width: 100%;" label="Ingredients (Use commas to separate)" v-model="form.ingredients"
        :error="form.errors.ingredients" />
    </div>
    <div>
      <FormInputImage label="Dish Image" @selected="handleSelectedMedia" :error="form.errors.image" />
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
  <div class="py-4">
    <h1 class="max-w-3xl mx-auto mt-10 font-bold text-2xl">Dish Categories</h1>
    <div class="bg-white rounded-md shadow overflow-x-auto  max-w-3xl mx-auto">
      <table class="w-full whitespace-nowrap">
        <tr class="text-left font-bold">
          <th class="px-6 pt-6 pb-4">Name</th>
          <th class="px-6 pt-6 pb-4"></th>
        </tr>
        <tr v-for="category in categories" :key="category.id"
          @click="category.belongs_to_program = !category.belongs_to_program"
          class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t">
            <label for="course" class="px-6 py-4 flex items-center focus:text-indigo-500">
              {{ category.name }}
            </label>
          </td>
          <td class="border-t w-px">
            <span class="px-4 flex items-center" tabindex="-1">
              <input name="course" type="checkbox" v-model="category.belongs_to_program" />
            </span>
          </td>
        </tr>
        <tr v-if="categories.length === 0">
          <td class="border-t px-6 py-4" colspan="4">
            No category found.
          </td>
        </tr>
      </table>
    </div>
  </div>

</template>

