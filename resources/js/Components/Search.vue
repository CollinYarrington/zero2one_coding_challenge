<script setup>
import { Link, useForm } from "@inertiajs/vue3";
import TextInput from "./Ui/Input/InputText.vue";
import ButtonPrimary from "./Ui/Button/ButtonPrimary.vue";
import { onMounted, ref, watch } from "vue";
import axios from "axios";
import { ArrowLeftIcon, ArrowRightIcon, BookmarkIcon, EyeIcon, TrashIcon } from '@heroicons/vue/24/solid';

const props = defineProps({
    userFeedback: Object,
    placeholder: String
});

const emit = defineEmits(['addToWatchlist', 'deleteFromWatchlist'])
const loading = ref(false);
const pageNumber = ref(1);
const totalPageCount = ref(0);
const resultsFound = ref();
const timeout = ref();

const form = useForm({
    search: ""
});

const search = async () => {
    pageNumber.value=1;
    updateListing();
};

const nextPage = () => {
    if (pageNumber.value < totalPageCount.value) {
        pageNumber.value++;
        clearTimeout(timeout.value);
        timeout.value = setTimeout(() => {
            updateListing();
        },300)
    } else {
        alert('Page limit reached');
    }
}

const previousPage = () => {
    if (pageNumber.value > 1) {
        pageNumber.value--;
        clearTimeout(timeout.value);
        timeout.value = setTimeout(() => {
            updateListing();
        },300)
    } else {
        alert('Cannot go back any further');
    }
};

const updateListing = async () => {
    loading.value = true;
    await axios.post(route('movie.search'), {
        search: form.search,
        page: pageNumber.value
    }).then((response) => {
        resultsFound.value = response.data
    })
    .finally(() => loading.value = false);
};

const addToWatchlist = (item) => {
    emit('addToWatchlist', item);
};

const deleteFromWatchlist = (item) => {
    emit('deleteFromWatchlist', item);
};

watch(resultsFound, (update)=>{
    totalPageCount.value = Math.ceil((update.data?.totalResults ?? 0) / 10);
});

watch(() => props.userFeedback, (feedback) => {
    console.log(feedback);
    if (feedback.status == 'success') {
        const movie = resultsFound.value.data?.search.find(item => item.imdb_id === feedback.imdb_id);
        if (movie) {
            if (feedback.action == 'deleted'){
                movie.on_watchlist = false;
            } else if(feedback.action == 'added'){
                movie.on_watchlist = true;
            }
        }
    }
});


</script>

<template>
    <div class="bg-zinc-800 h-fit p-5">
        <form @submit.prevent="search">
            <div class="flex gap-2 justify-end">
                <TextInput v-model="form.search" :class="'white'" placeholder="Search..."/>
                <ButtonPrimary size="lg" class="border border-l-0 px-3 bg-white">Search</ButtonPrimary>
            </div>
        </form>
    </div>
    <div class="bg-white p-5">
        <div class="relative">
            <p class="bg-white absolute translate-x-10 translate-y-[-13px]">Movies</p>
        </div>
        <div class="border p-5 rounded">
            <div v-if="loading" class="flex justify-center align-middle mt-10">
                <div class="w-10 h-10 border-4 border-gray-300 border-t-blue-500 rounded-full animate-spin"></div>
            </div>
            <div v-else-if="!loading && resultsFound?.data?.search">

                <div class="my-5">
                    <div class="bg-white rounded-xl flex justify-center w-fit p-2">
                        Total Results: {{ resultsFound?.data?.totalResults ?? 0 }}
                    </div>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-5 gap-5">
                    <div v-for="(item, index) in resultsFound?.data?.search" :key="index" class="bg-white col-span-1 rounded-xl p-5 border shadow-2xl">
                        <div class="flex justify-center">
                            <p class="text-pretty font-extrabold">
                                {{ item.title }}
                            </p>
                        </div>
                        
                        <div class="flex justify-center align-middle h-80 overflow-hidden bg-black">
                            <img :src="item.poster" :alt="item.title" class="h-full"/>
                    </div>
                    
                    <div>
                        <p class="text-pretty">
                            Type: {{ item.type }}
                        </p>
                        <p class="text-pretty">
                            Year: {{ item.year }}
                        </p>
                        <p class="text-pretty">
                            Genre: {{ item.genre }}
                        </p>
                    </div>
                    
                    <div class="flex justify-center align-middle pt-5 gap-5">
                        <Link :href="route('movie.view',{'imdb_id': item.imdb_id})" class="bg-blue-400 rounded border px-2">
                            <EyeIcon class="h-6"/>
                        </Link>

                        <ButtonPrimary 
                        v-if="!item.on_watchlist"
                        @click="addToWatchlist(item)" 
                        class="bg-yellow-400">
                            <BookmarkIcon class="h-6"/>
                        </ButtonPrimary>

                        <ButtonPrimary 
                        v-else
                        @click="deleteFromWatchlist(item)" 
                        class="bg-red-400">
                            <TrashIcon class="h-6"/>
                        </ButtonPrimary>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="resultsFound?.data?.totalResults">
            <p class="text-center">Pages:</p>
            <div class="flex justify-center items-center bg-white w-full p-1 rounded-xl">
                <ButtonPrimary @click="previousPage" class="bg-white text-2xl"><ArrowLeftIcon class="h-6"/></ButtonPrimary>
                <p>
                    {{ pageNumber }} / {{ totalPageCount ?? 0 }}
                </p>
                <ButtonPrimary @click="nextPage" class="bg-white text-2xl"><ArrowRightIcon class="h-6"/></ButtonPrimary>
            </div>
        </div>
        
        <div v-else-if="!resultsFound?.data?.totalResults && !loading">
            <p>No results found</p>
        </div>
        </div>
    </div>

</template>