<template>
    <div v-if="links.length > 3" class="flex flex-row justify-between">
        <div class="flex flex-wrap -mb-1">
            <Link
                class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-white focus:border-rose-500 focus:text-rose-500"
                :class="{ 'bg-white': links[0].active }"
                :href="firstPage"
            >
                First page
            </Link>
            <div
                v-if="links[0].url === null"
                class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded"
            >
                &laquo; Înapoi
            </div>
            <Link
                v-else
                class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-white focus:border-rose-500 focus:text-rose-500"
                :class="{ 'bg-white': links[0].active }"
                :href="links[0].url"
                >&laquo; Back</Link
            >
            <template v-for="(link, key) in links" :key="key">
                <template v-if="key !== 0 && key !== links.length - 1">
                    <div
                        v-if="link.url === null"
                        class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded"
                        v-html="link.label"
                    />
                    <Link
                        v-else
                        class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-white focus:border-rose-500 focus:text-rose-500"
                        :class="{ 'bg-white': link.active }"
                        :href="link.url"
                        v-html="link.label"
                    />
                </template>
            </template>
            <div
                v-if="links[links.length - 1].url === null"
                class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded"
            >
                Previous &raquo;
            </div>
            <Link
                v-else
                class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-white focus:border-rose-500 focus:text-rose-500"
                :class="{ 'bg-white': links[links.length - 1].active }"
                :href="links[links.length - 1].url"
                >Next &raquo;</Link
            >
            <Link
                class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-white focus:border-rose-500 focus:text-rose-500"
                :href="lastPage"
            >
                Last page
            </Link>
        </div>
        <div class="mt-2 flex">
            Pagina {{ data.current_page }} - {{ data.last_page }}
            <div class="mr-4 ml-4">
                De la {{ data.from }} pană la {{ data.to }} din {{ data.total }}
            </div>
        </div>
    </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";
export default {
    components: {
        Link,
    },
    props: {
        firstPage: {
            default: null,
        },
        lastPage: {
            default: null,
        },
        links: Array,
        data: {
            type: Object,
            default: null,
        },
    },
};
</script>
