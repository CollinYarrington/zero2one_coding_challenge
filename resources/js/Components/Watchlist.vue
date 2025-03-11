<script setup>
import axios from 'axios';
import { onMounted, ref, watch } from 'vue';
import ButtonPrimary from './Ui/Button/ButtonPrimary.vue';
import { TrashIcon, ArrowLeftIcon, ArrowRightIcon, EyeIcon } from '@heroicons/vue/24/solid';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    newWatchlistItem: Object,
});

const emit = defineEmits(['userFeedback']);

const loading = ref(false);
const userFeedback = ref();
const addToWatchlist = async (movie) => {
    loading.value = true;

    try {
        var response = await axios.post(route('movie.watchlist.add'), movie);
        userFeedback.value = response.data;
        userFeedback.value.imdb_id = movie.imdb_id;
        userFeedback.value.action = 'added';
        
        if (userFeedback.value.status == 'success') {
            getWatchList();
        }
        
    } catch (error) {
        if (error.response && error.response.status === 422) { 
            const errors = error.response.data.errors;
            var messages = [];
            for (const [key, value] of Object.entries(errors)) {
                messages.push(value[0]);
            }

            var restructuredResponse = {
                status: 'error',
                messages: messages,
            }
            userFeedback.value = restructuredResponse;
        }
    }
    emit('userFeedback', userFeedback.value)
    loading.value = false;
};

const watchlist = ref();
const getWatchList = async (url = route('movie.watchlist')) => {
    try {
        var response = await axios.get(url);
        watchlist.value = response.data.watchlist;
        
    } catch (error) {
        if (error.response && error.response.status === 422) { 
            const errors = error.response.data.errors;
            var messages = [];
            for (const [key, value] of Object.entries(errors)) {
                messages.push(value[0]);
            }

            var restructuredResponse = {
                status: 'error',
                messages: messages,
            }
            userFeedback.value = restructuredResponse;
        }
    }
};

const deleteFromWatchlist = async (movie) => {
    try {
        var response = await axios.post(route('movie.watchlist.delete'), { movie: movie, page: watchlist?.current_page });
        watchlist.value = response.data.watchlist;
        userFeedback.value = {
            status: response.data.status,
            message: response.data.message,
            imdb_id: movie.imdb_id,
            action: 'deleted'
        };
        emit('userFeedback', userFeedback.value)
        
    } catch (error) {
        if (error.response && error.response.status === 422) { 
            const errors = error.response.data.errors;
            var messages = [];
            for (const [key, value] of Object.entries(errors)) {
                messages.push(value[0]);
            }

            var restructuredResponse = {
                status: 'error',
                messages: messages,
            }
            userFeedback.value = restructuredResponse;
        }
    }
}

onMounted(() => getWatchList());

defineExpose({ addToWatchlist, deleteFromWatchlist });
</script>
<template>
    <div class="bg-white p-5">
        <div class="relative">
            <p class="bg-white absolute translate-x-10 translate-y-[-13px]">Watch List</p>
        </div>        
        <div class="border p-5 rounded">
            <div class="grid grid-cols-1 lg:grid-cols-5 md:grid-cols-3 sm:grid-cols-2 gap-5">
                    <div class="bg-white col-span-1 rounded-xl p-5" v-for="(item, index) in watchlist?.data" :key="index">
                        <div class="flex justify-center">
                            <p class="text-pretty font-extrabold">
                                {{ item?.title }}
                            </p>
                        </div>
                        
                        <div class="flex justify-center align-middle h-80 overflow-hidden bg-black">
                            <img :src="item?.poster" :alt="item?.title" class="h-full"/>
                    </div>
                    
                    <div>
                        <p class="text-pretty">
                            Type: {{ item?.type }}
                        </p>
                        <p class="text-pretty">
                            Year: {{ item?.year }}
                        </p>
                        <p class="text-pretty">
                            Genre: {{ item?.genre }}
                        </p>
                    </div>
                    
                    <div class="flex justify-center align-middle gap-5">
                        <Link :href="route('movie.view',{'imdb_id': item.imdb_id})" class="bg-blue-400 rounded border px-2">
                            <EyeIcon class="h-6"/>
                        </Link>
                        <ButtonPrimary class="bg-red-400" @click="deleteFromWatchlist(item)" title="Remove movie from watchlist">
                            <TrashIcon class="h-6"/>
                        </ButtonPrimary>
                    </div>
                </div>
            </div>
            <div class="flex justify-center" v-if="watchlist?.total">
                <ButtonPrimary v-if="watchlist?.current_page > 1" @click="getWatchList(watchlist?.prev_page_url)" title="Previous page">
                    <ArrowLeftIcon class="h-5"/>
                </ButtonPrimary>

                {{ watchlist?.current_page }}/{{ watchlist?.last_page }}
                
                <ButtonPrimary v-if="watchlist?.current_page < watchlist?.last_page" @click="getWatchList(watchlist?.next_page_url)" title="Next page">
                    <ArrowRightIcon class="h-5"/>
                </ButtonPrimary>
            </div>
            <p v-else>No Movies have been added to your watch list yet</p>
        </div>
    </div>
</template>