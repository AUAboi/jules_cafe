<script setup>
import PageTitle from '@/Components/PageTitle.vue';
import { Head } from '@inertiajs/inertia-vue3';


const props = defineProps({
  dishes: {
    required: true,
    type: Array
  }
})
</script>

<template>

  <Head title="Menu" />
  <PageTitle>
    Menu
  </PageTitle>
  <div>
    {{ dishes }}
  </div>
</template>