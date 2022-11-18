<script setup>
import PageTitle from '@/Components/UI/PageTitle.vue';

const props = defineProps({
  order: { type: Object, required: true },
  dishes: { type: Object, required: true }
})
</script>

<template>
  <PageTitle>Order # {{ order.order_no }}</PageTitle>
  <div>
    {{ dishes }}

  </div>

</template>