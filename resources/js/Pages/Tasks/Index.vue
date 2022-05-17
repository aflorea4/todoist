<template>
    <app-layout title="Tasks">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Tasks
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <Table
                        class="p-4"
                        :filters="queryBuilderProps.filters"
                        :search="queryBuilderProps.search"
                        :columns="queryBuilderProps.columns"
                        :on-update="setQueryBuilder"
                        :meta="tasks"
                    >
                        <template #head>
                            <tr>
                                <th @click.prevent="sortBy('title')">Title</th>
                                <th @click.prevent="sortBy('completed')">
                                    Completed
                                </th>
                                <th @click.prevent="sortBy('due_date')">
                                    Due Date
                                </th>
                                <th>
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </template>

                        <template #body>
                            <tr v-for="task in tasks.data" :key="task.id">
                                <td>
                                    {{ task.title }}
                                </td>
                                <td>
                                    {{
                                        task.completed ? "Done" : "In progress"
                                    }}
                                </td>
                                <td>
                                    {{ task.due_date }}
                                </td>
                                <td>
                                    <div class="w-32 text-right">
                                        <Menu
                                            as="div"
                                            class="inline-block text-left"
                                        >
                                            <div class="z-0">
                                                <MenuButton
                                                    class="inline-flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-black rounded-md focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75"
                                                >
                                                    Options
                                                    <ChevronDownIcon
                                                        class="w-5 h-5 ml-2 -mr-1 text-violet-200 hover:text-violet-100"
                                                        aria-hidden="true"
                                                    />
                                                </MenuButton>
                                            </div>

                                            <transition
                                                enter-active-class="transition duration-100 ease-out"
                                                enter-from-class="transform scale-95 opacity-0"
                                                enter-to-class="transform scale-100 opacity-100"
                                                leave-active-class="transition duration-75 ease-in"
                                                leave-from-class="transform scale-100 opacity-100"
                                                leave-to-class="transform scale-95 opacity-0"
                                            >
                                                <MenuItems
                                                    class="z-50 absolute right-0 w-56 mt-2 origin-top-right bg-white divide-y divide-gray-100 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                                >
                                                    <div class="px-1 py-1">
                                                        <MenuItem
                                                            v-slot="{ active }"
                                                        >
                                                            <button
                                                                :class="[
                                                                    active
                                                                        ? 'bg-violet-500 text-white'
                                                                        : 'text-gray-900',
                                                                    'group flex rounded-md items-center w-full px-2 py-2 text-sm',
                                                                ]"
                                                                @click.stop="
                                                                    $inertia.visit(
                                                                        route(
                                                                            'tasks.show',
                                                                            task.id
                                                                        )
                                                                    )
                                                                "
                                                            >
                                                                <EyeIcon
                                                                    :active="
                                                                        active
                                                                    "
                                                                    class="w-5 h-5 mr-2 text-violet-400"
                                                                    aria-hidden="true"
                                                                />
                                                                View
                                                            </button>
                                                        </MenuItem>
                                                        <MenuItem
                                                            v-slot="{ active }"
                                                        >
                                                            <button
                                                                :class="[
                                                                    active
                                                                        ? 'bg-violet-500 text-white'
                                                                        : 'text-gray-900',
                                                                    'group flex rounded-md items-center w-full px-2 py-2 text-sm',
                                                                ]"
                                                                @click.stop="
                                                                    editTask(
                                                                        task.id
                                                                    )
                                                                "
                                                            >
                                                                <PencilAltIcon
                                                                    :active="
                                                                        active
                                                                    "
                                                                    class="w-5 h-5 mr-2 text-violet-400"
                                                                    aria-hidden="true"
                                                                />
                                                                Edit
                                                            </button>
                                                        </MenuItem>
                                                    </div>
                                                    <div class="px-1 py-1">
                                                        <MenuItem
                                                            v-slot="{ active }"
                                                        >
                                                            <button
                                                                :class="[
                                                                    active
                                                                        ? 'bg-violet-500 text-white'
                                                                        : 'text-gray-900',
                                                                    'group flex rounded-md items-center w-full px-2 py-2 text-sm',
                                                                ]"
                                                                @click.stop="
                                                                    deleteTask(
                                                                        task.id
                                                                    )
                                                                "
                                                            >
                                                                <TrashIcon
                                                                    :active="
                                                                        active
                                                                    "
                                                                    class="w-5 h-5 mr-2 text-violet-400"
                                                                    aria-hidden="true"
                                                                />
                                                                Delete
                                                            </button>
                                                        </MenuItem>
                                                    </div>
                                                </MenuItems>
                                            </transition>
                                        </Menu>
                                    </div>
                                </td>
                            </tr>
                        </template>
                        <template #pagination>
                            <table-pagination
                                class="mt-4"
                                :data="tasks"
                                :links="tasks.links"
                                :firstPage="tasks.first_page_url"
                                :lastPage="tasks.last_page_url"
                            />
                        </template>
                    </Table>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import {
    InteractsWithQueryBuilder,
    Tailwind2,
} from "@protonemedia/inertiajs-tables-laravel-query-builder";

import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";

import JetButton from "@/Jetstream/Button.vue";

import { Menu, MenuButton, MenuItems, MenuItem } from "@headlessui/vue";
import {
    ChevronDownIcon,
    EyeIcon,
    PencilAltIcon,
    TrashIcon,
} from "@heroicons/vue/solid";

import TablePagination from "@/Pages/Tailwind2/Pagination.vue";

import { Link } from "@inertiajs/inertia-vue3";

import Swal from "sweetalert2/dist/sweetalert2.js";

export default defineComponent({
    mixins: [InteractsWithQueryBuilder],

    data() {
        return {
            form: this.$inertia.form({}),
        };
    },

    components: {
        AppLayout,
        Table: Tailwind2.Table,
        JetButton,
        Menu,
        MenuButton,
        MenuItems,
        MenuItem,
        ChevronDownIcon,
        EyeIcon,
        PencilAltIcon,
        TrashIcon,
        TablePagination,
        Link,
        Swal,
    },

    props: {
        tasks: Object,
        queryBuilderProps: Object,
    },

    methods: {
        editTask(id) {
            this.$inertia.visit(route("tasks.edit", id));
        },
        deleteTask(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    this.form.post(route("tasks.destroy", id));
                    Swal.fire(
                        "Deleted!",
                        "Your file has been deleted.",
                        "success"
                    );
                }
            });
        },
    },
});
</script>
