<template>
    <app-layout :title="task.title">
        <template #header>
            <div class="flex flex-row">
                <div class="flex-grow">
                    <h2
                        class="font-semibold text-xl text-gray-800 leading-tight"
                    >
                        {{ task.title }}
                    </h2>
                </div>
                <div class="flex-shrink-0">
                    <div class="w-32 text-right">
                        <Menu as="div" class="inline-block text-left">
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
                                            v-if="!task.completed"
                                        >
                                            <button
                                                :class="[
                                                    active
                                                        ? 'bg-violet-500 text-white'
                                                        : 'text-gray-900',
                                                    'group flex rounded-md items-center w-full px-2 py-2 text-sm',
                                                ]"
                                                @click.stop="markAsCompleted"
                                            >
                                                <CheckIcon
                                                    :active="active"
                                                    class="w-5 h-5 mr-2 text-violet-400"
                                                    aria-hidden="true"
                                                />
                                                Mark as completed
                                            </button>
                                        </MenuItem>
                                        <MenuItem
                                            v-slot="{ active }"
                                            v-if="task.completed"
                                        >
                                            <button
                                                :class="[
                                                    active
                                                        ? 'bg-violet-500 text-white'
                                                        : 'text-gray-900',
                                                    'group flex rounded-md items-center w-full px-2 py-2 text-sm',
                                                ]"
                                                @click.stop="MarkAsInProgress"
                                            >
                                                <BriefcaseIcon
                                                    :active="active"
                                                    class="w-5 h-5 mr-2 text-violet-400"
                                                    aria-hidden="true"
                                                />
                                                Mark as in progress
                                            </button>
                                        </MenuItem>
                                        <MenuItem v-slot="{ active }">
                                            <button
                                                :class="[
                                                    active
                                                        ? 'bg-violet-500 text-white'
                                                        : 'text-gray-900',
                                                    'group flex rounded-md items-center w-full px-2 py-2 text-sm',
                                                ]"
                                            >
                                                <PencilAltIcon
                                                    :active="active"
                                                    class="w-5 h-5 mr-2 text-violet-400"
                                                    aria-hidden="true"
                                                />
                                                Edit
                                            </button>
                                        </MenuItem>
                                    </div>
                                    <div class="px-1 py-1">
                                        <MenuItem v-slot="{ active }">
                                            <button
                                                :class="[
                                                    active
                                                        ? 'bg-violet-500 text-white'
                                                        : 'text-gray-900',
                                                    'group flex rounded-md items-center w-full px-2 py-2 text-sm',
                                                ]"
                                            >
                                                <TrashIcon
                                                    :active="active"
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
                </div>
            </div>
        </template>

        <div class="py-12 px-8">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                    <dl class="sm:divide-y sm:divide-gray-200">
                        <div
                            class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                        >
                            <dt class="text-sm font-medium text-gray-500">
                                Description
                            </dt>
                            <dd
                                class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"
                            >
                                {{ task.description }}
                            </dd>
                        </div>
                        <div
                            class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                        >
                            <dt class="text-sm font-medium text-gray-500">
                                Status
                            </dt>
                            <dd
                                class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"
                            >
                                {{ task.completed ? "Completed" : "Pending" }}
                            </dd>
                        </div>
                        <div
                            class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                        >
                            <dt class="text-sm font-medium text-gray-500">
                                Due Date
                            </dt>
                            <dd
                                class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"
                            >
                                {{ task.human_due_date }}
                            </dd>
                        </div>
                        <div
                            class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                        >
                            <dt class="text-sm font-medium text-gray-500">
                                Created At
                            </dt>
                            <dd
                                class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"
                            >
                                {{ task.human_created_at }}
                            </dd>
                        </div>
                        <div
                            class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                        >
                            <dt class="text-sm font-medium text-gray-500">
                                Updated At
                            </dt>
                            <dd
                                class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"
                            >
                                {{ task.human_updated_at }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";

import JetButton from "@/Jetstream/Button.vue";

import { Menu, MenuButton, MenuItems, MenuItem } from "@headlessui/vue";
import {
    ChevronDownIcon,
    CheckIcon,
    BriefcaseIcon,
    PencilAltIcon,
    TrashIcon,
} from "@heroicons/vue/solid";

import { Link } from "@inertiajs/inertia-vue3";

export default defineComponent({
    components: {
        AppLayout,
        JetButton,
        Menu,
        MenuButton,
        MenuItems,
        MenuItem,
        ChevronDownIcon,
        CheckIcon,
        BriefcaseIcon,
        PencilAltIcon,
        TrashIcon,
        Link,
    },

    props: {
        task: Object,
    },

    methods: {
        markAsCompleted() {
            console.log("test");
            this.$inertia.post(route("tasks.complete"));
        },
    },
});
</script>
