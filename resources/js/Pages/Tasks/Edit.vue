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
                    <form @submit.prevent="submit">
                        <dl class="sm:divide-y sm:divide-gray-200">
                            <div
                                class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                            >
                                <dt class="text-sm font-medium text-gray-500">
                                    Title
                                </dt>
                                <dd
                                    class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"
                                >
                                    <input
                                        type="text"
                                        class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                        v-model="form.title"
                                        placeholder="Wash dishes"
                                    />
                                </dd>
                            </div>
                            <div
                                class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                            >
                                <dt class="text-sm font-medium text-gray-500">
                                    Description
                                </dt>
                                <dd
                                    class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"
                                >
                                    <textarea
                                        class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                        rows="3"
                                        placeholder="Put the dishes in the dishwasher"
                                        v-model="form.description"
                                    ></textarea>
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
                                    <select
                                        class="form-select appearance-none block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                        aria-label="Select an option"
                                        v-model="form.completed"
                                    >
                                        <option
                                            v-for="option in statusOptions"
                                            v-bind:value="option.value"
                                            :key="option.value"
                                        >
                                            {{ option.text }}
                                        </option>
                                    </select>
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
                                    <datepicker v-model="form.due_date" />
                                </dd>
                            </div>
                            <div class="py-4 sm:py-5 sm:px-6">
                                <button
                                    class="w-full px-4 py-2 border-2 border-green-400 rounded-md hover:bg-green-400"
                                    type="submit"
                                    @click.stop="submit"
                                >
                                    Update
                                </button>
                            </div>

                            <jet-validation-errors class="mb-4" />
                        </dl>
                    </form>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";

import JetButton from "@/Jetstream/Button.vue";
import JetValidationErrors from "@/Jetstream/ValidationErrors.vue";

import { Menu, MenuButton, MenuItems, MenuItem } from "@headlessui/vue";
import {
    ChevronDownIcon,
    CheckIcon,
    BriefcaseIcon,
    PencilAltIcon,
    TrashIcon,
} from "@heroicons/vue/solid";

import { Link } from "@inertiajs/inertia-vue3";

import Datepicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";

export default defineComponent({
    components: {
        AppLayout,
        JetButton,
        JetValidationErrors,
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
        Datepicker,
    },

    props: {
        task: Object,
    },

    data() {
        return {
            form: this.$inertia.form({
                title: this.task.title,
                description: this.task.description,
                due_date: this.task.due_date,
                completed: this.task.completed,
            }),
            statusOptions: [
                { text: "Select status", value: null },
                { text: "In progress", value: 0 },
                { text: "Completed", value: 1 },
            ],
        };
    },

    methods: {
        submit() {
            this.form.post(route("tasks.update", this.task.id));
        },
        markAsCompleted() {
            console.log("test");
            this.$inertia.post(route("tasks.complete"));
        },
    },
});
</script>
