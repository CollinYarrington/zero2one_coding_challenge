<script setup>
import axios from 'axios';
import { ref, watch } from 'vue';

const props = defineProps({
    newWatchListItem: Object,
})
const loading = ref(false);

watch(() => props.newWatchListItem, (movie) => addToWatchList(movie));

const addToWatchList = (movie) => {
    console.log(movie);
    loading.value = true;
    axios.post(route('movie.add-to-watch-list'), movie).then((response) => {
        console.log(response);
    }).finally(() => loading.value = false);
}
</script>
<template>
    <div class="bg-white p-5">
        <div class="relative">
            <p class="bg-white absolute translate-x-10 translate-y-[-13px]">Watch List</p>
        </div>
        <!-- v-for="(item, index) in resultsFound?.data?.search" :key="index" -->
        <div class="grid grid-cols-1 sm:grid-cols-5 gap-5">
                    <div class="bg-white col-span-1 rounded-xl p-5">
                        <div class="flex justify-center">
                            <p class="text-pretty font-extrabold">
                                {{ newWatchListItem?.title }}
                            </p>
                        </div>
                        
                        <div class="flex justify-center align-middle h-80 overflow-hidden bg-black">
                            <img :src="newWatchListItem?.poster" :alt="newWatchListItem?.title" class="h-full"/>
                    </div>
                    
                    <div>
                        <p class="text-pretty">
                            Type: {{ newWatchListItem?.type }}
                        </p>
                        <p class="text-pretty">
                            Year: {{ newWatchListItem?.year }}
                        </p>
                        <p class="text-pretty">
                            Year: {{ newWatchListItem?.genre }}
                        </p>
                    </div>
                    
                    <div class="flex justify-center align-middle">
                        <!-- <Link :href="route('movie.view',{imdbID: item.imdbID})">
                            View
                        </Link> -->
                        <!-- <ButtonPrimary @click="addToWatchList(item)">
                            Add To Watch List
                        </ButtonPrimary> -->
                    </div>
                </div>
            </div>
        <div class="border p-5 rounded">
            <p>No Movies have been added to your watch list yet</p>
        </div>
    </div>
</template>