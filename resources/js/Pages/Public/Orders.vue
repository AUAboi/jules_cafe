<script setup>
import Paginator from '@/Components/Paginator.vue';
import DataTable from '@/Components/Table/DataTable.vue';
import { Head } from '@inertiajs/inertia-vue3';

const props = defineProps({
  orders: Array
});

const labels = [
  {
    key: "order_no",
    value: "Order No.",
  },

  {
    key: "type",
    value: "Order Type"
  },
  {
    key: "total",
    value: "Total Bill",
  },
  {
    key: "created_at",
    value: "Placed"
  },
  {
    key: "status",
    value: "Status"
  }
];


</script>


<template>

  <Head title="Orders"></Head>
  <div>
    <div class="overflow-x-auto">
      <DataTable :labels="labels" :table-data="orders.data" resource-route="orders.show" />

    </div>
    <Paginator :links="orders.links" />
  </div>
</template>