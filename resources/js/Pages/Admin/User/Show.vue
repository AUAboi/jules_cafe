<script setup>
import AppButton from '@/Components/UI/AppButton.vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
  user: {
    required: true,
  }
})

const destroy = () => {
  if (confirm('Do you really want to delete')) {
    Inertia.delete(route('admin.users.destroy', props.user.id));

  }
}

</script>

<template>
  {{ user }}

  <div class="bg-white shadow mt-4 max-w-lg mx-auto rounded-md ">
    <p class="px-1 font-bold">
      Details
    </p>
    <div class="flex flex-col gap-4  py-4 px-2 border-t">

      <p>
        Name: {{ user.name }}
      </p>
      <p>
        Phone: {{ user.phone }}
      </p>
      <p>
        Email: {{ user.email }}
      </p>
      <p>
        Created since: {{ user.created_at }}
      </p>
      <div>
        <AppButton @click.prevent="destroy" class="primary-btn text-center">Delete</AppButton>
      </div>
    </div>

  </div>
</template>