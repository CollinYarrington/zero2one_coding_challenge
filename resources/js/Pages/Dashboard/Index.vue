<script setup>
import { Link } from '@inertiajs/vue3';
import AppLayout from '../../Layouts/AppLayout.vue';
import Search from '../../Components/Search.vue';
import Watchlist from '../../Components/Watchlist.vue';
import { ref } from 'vue';
import Alerts from '../../Components/Alerts.vue';

const watchlist = ref(null);
const invokeAddToWatchlist = (movie) => {
    watchlist.value.addToWatchlist(movie);
};
const invokeDeleteFromWatchlist = (movie) => {
    watchlist.value.deleteFromWatchlist(movie);
};

const userFeedback = ref();

</script>
<template>
    <AppLayout>
        <Alerts :feedback="userFeedback" />
        <Watchlist 
        ref="watchlist"
        @userFeedback="(feedback) => userFeedback = feedback" />
        <Search 
        @addToWatchlist="invokeAddToWatchlist" 
        @deleteFromWatchlist="invokeDeleteFromWatchlist"
        :userFeedback="userFeedback" />
    </AppLayout>
</template>