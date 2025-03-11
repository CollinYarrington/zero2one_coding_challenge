<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
defineProps({
    movie: Object
});
</script>
<template>
    <AppLayout>
        <div class="bg-black p-10rounded-xl">
            <div class="flex gap-5 justify-center align-middle">
                <div>
                    <img :src="movie?.poster" :alt="movie?.title" class="max-h-96">

                    <span class="text-white">Sources:</span>
                    <ul class="list-disc ml-5">
                        <li class="text-white" v-for="(item, index) in movie?.ratings" :key="index">{{ item.Source }} - {{ item.Value }}</li>
                    </ul>
                </div>

                <div>
                    <p class="text-white">Title: {{ movie?.title}}</p>
                    <p class="text-white">Type: {{ movie?.type}}</p>
                    <p class="text-white">Rated: {{ movie?.rated}}</p>
                    <p class="text-white">Plot: {{ movie?.plot}}</p>
                    <p class="text-white">Released: {{ movie?.released}}</p>
                    <p class="text-white">Year: {{ movie?.year}}</p>
                    <p class="text-white">Runtime: {{ movie?.runtime}}</p>
                    <p class="text-white">Genre: {{ movie?.genre}}</p>
                    <p class="text-white">Language: {{ movie?.language}}</p>
                    <p class="text-white">Country: {{ movie?.country}}</p>
                    <br>
                    <p class="text-white">Director: {{ movie?.director}}</p>
                    <p class="text-white">Writer: {{ movie?.writer}}</p>
                    <p class="text-white">Actors: {{ movie?.actors}}</p>
                    <br>
                    <p class="text-white">Awards: {{ movie?.awards}}</p>
                    <p class="text-white">imdbRating: {{ movie?.imdbRating}}</p>
                    <p class="text-white">BoxOffice: {{ movie?.boxOffice}}</p>
                </div>
            </div>
            <div class="flex justify-center gap-3">
                <Link :href="route('dashboard.index')" class="bg-white p-3 rounded-xl">Back</Link>
            </div>
        </div> 
    </AppLayout>
</template>