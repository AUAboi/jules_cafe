<script setup>
import PageTitle from '@/Components/PageTitle.vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';
import FormInputText from '@/Components/form/FormInputText.vue'

const form = useForm({
  name: "",
  price: 0,
  image: null
})

form.post('/dish/store')

</script>
<template>
  {{ form }}

  <Head title="Create Dish"></Head>
  <PageTitle>
    Create Dish
  </PageTitle>
  <form>
    <FormInputText label="Name" v-model="form.name" :error="form.errors.name" />
    <div>
      <label for="">Name</label>
      <input type="text">

    </div>
  </form>
</template>