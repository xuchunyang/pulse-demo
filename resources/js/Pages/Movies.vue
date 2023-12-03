<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router } from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import { reactive } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

interface Movie {
    id: number;
    title: string;
    overview: string;
    genres: string[];
    poster: string;
    release_date: string;
}

interface MovieResponse {
    current_page: number;
    data: Movie[];
    last_page: number;
    per_page: number;
}

const props = defineProps<{
    movies: MovieResponse;
    q: string;
}>();

const form = reactive({
    per_page: props.movies.per_page,
    current_page: props.movies.current_page,
    q: props.q,
});

const submit = () => {
    router.visit(
        route("movies.index", {
            per_page: form.per_page,
            page: form.current_page,
            q: form.q,
        }),
    );
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                电影列表
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <form
                            @submit.prevent="submit"
                            class="flex gap-4 uppercase mb-4"
                        >
                            <div>
                                <InputLabel>per_page</InputLabel>
                                <TextInput
                                    class="mt-1"
                                    v-model="form.per_page"
                                    type="number"
                                    required
                                />
                            </div>
                            <div>
                                <InputLabel>current_page</InputLabel>
                                <TextInput
                                    class="mt-1"
                                    v-model="form.current_page"
                                    type="number"
                                    required
                                />
                            </div>
                            <div>
                                <InputLabel>last_page</InputLabel>
                                <TextInput
                                    readonly
                                    v-model="props.movies.last_page"
                                    class="mt-1 cursor-not-allowed"
                                    type="number"
                                    required
                                />
                            </div>
                            <div>
                                <InputLabel>Query</InputLabel>
                                <TextInput
                                    v-model="form.q"
                                    class="mt-1"
                                    type="search"
                                    placeholder="匹配标题/概述"
                                />
                            </div>
                            <div class="flex flex-col justify-end">
                                <PrimaryButton>Search</PrimaryButton>
                            </div>
                        </form>

                        <table
                            class="divide-y divide-gray-200 dark:divide-gray-700 w-full"
                        >
                            <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th
                                        class="p-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider"
                                    >
                                        ID
                                    </th>
                                    <th
                                        class="p-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider"
                                    >
                                        标题
                                    </th>
                                    <th
                                        class="p-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider"
                                    >
                                        概述
                                    </th>
                                    <th
                                        class="p-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider"
                                    >
                                        海报
                                    </th>
                                    <th
                                        class="p-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider"
                                    >
                                        类型
                                    </th>
                                    <th
                                        class="p-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider"
                                    >
                                        发布日期
                                    </th>
                                </tr>
                            </thead>
                            <tbody
                                class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700"
                            >
                                <tr
                                    v-for="movie in movies.data"
                                    :key="movie.id"
                                >
                                    <td class="p-4">
                                        <div
                                            class="text-sm text-gray-900 dark:text-gray-100"
                                        >
                                            {{ movie.id }}
                                        </div>
                                    </td>
                                    <td class="p-2">
                                        <div
                                            class="text-sm text-gray-900 dark:text-gray-100"
                                        >
                                            {{ movie.title }}
                                        </div>
                                    </td>
                                    <td class="p-2">
                                        <div
                                            class="text-sm text-gray-900 dark:text-gray-100"
                                        >
                                            {{ movie.overview }}
                                        </div>
                                    </td>
                                    <td class="p-2">
                                        <div
                                            class="text-sm text-gray-900 dark:text-gray-100"
                                        >
                                            <img
                                                v-if="movie.poster"
                                                :src="movie.poster"
                                                alt=""
                                            />
                                        </div>
                                    </td>
                                    <td class="p-2">
                                        <div
                                            class="text-sm text-gray-900 dark:text-gray-100"
                                        >
                                            {{ movie.genres.join(", ") }}
                                        </div>
                                    </td>
                                    <td class="p-2">
                                        <div
                                            class="text-sm text-gray-900 dark:text-gray-100"
                                        >
                                            {{ movie.release_date }}
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
