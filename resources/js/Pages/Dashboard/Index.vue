<script setup>
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Search from '../../Components/Search.vue';
import WatchList from '../../Components/Watchlist.vue';
import { ref } from 'vue';

const newWatchListItem = ref();


</script>
<template>
    <AppLayout>
        <WatchList :newWatchListItem="newWatchListItem" />
        <Search @updateWatchList="(item) => newWatchListItem = item"/>
    </AppLayout>
</template>