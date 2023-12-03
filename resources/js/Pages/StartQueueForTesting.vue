<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
</script>

<template>
    <div>
        <h1 class="text-xl font-medium">测试 Queue 任务</h1>
        <p class="text-sm my-2 opacity-75">
            用来测试 Pulse 的「Queues」和「Slow Jobs」
        </p>

        <div>
            <Link
                :as="'button'"
                method="post"
                :href="route('relax-and-have-fun')"
                class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150"
            >
                开始任务
            </Link>
        </div>
    </div>
</template>
