<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';

import PageTitle from '@/Components/UI/PageTitle.vue'
import AppButton from '@/Components/UI/AppButton.vue';

const props = defineProps({
    siteMeta: {
        required: true
    }
})

</script>

<template>

    <Head title="Dashboard"></Head>
    <PageTitle>
        Dashboard
    </PageTitle>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 flex justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 rounded-full" :class="siteMeta.is_closed?'bg-red-500':'bg-green-500'"></div>
                        <p>
                            Ordering is {{ siteMeta.is_closed ?
                            'closed'
                            : 'open'
                            }}
                        </p>
                    </div>
                    <Link method="post" as="span" :href="route('admin.site.togglestatus')" class="primary-btn"
                        v-if="siteMeta.is_closed">
                    Open Now</Link>
                    <Link method="post" as="span" :href="route('admin.site.togglestatus')" class="primary-btn" v-else>
                    Close</Link>
                </div>

            </div>
        </div>
    </div>
</template>
