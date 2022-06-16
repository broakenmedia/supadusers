<template>
    <modal
        :open="modalData.isOpen"
        @closed="
            () => {
                modalData.close();
            }
        "
    >
        <template v-slot:title>Edit user</template>
        <template v-slot:body>
            <div class="py-4">
                <template v-if="modalData.errors !== null">
                    <div
                        class="mb-3 w-full rounded-md border-2 border-red-500 bg-red-400 px-4 py-1 text-base font-semibold"
                        v-for="(error, name) in modalData.errors"
                    >
                        <div class="prose text-white">
                            <p>
                                {{ error[0] }}
                            </p>
                        </div>
                    </div>
                </template>
                <div class="grid gap-3 lg:grid-cols-2">
                    <div>
                        <label
                            for="firstName"
                            class="mb-2 block text-sm font-medium text-gray-900"
                            >First name</label
                        >
                        <input
                            type="text"
                            name="firstName"
                            id="firstName"
                            v-model="modalData.form.firstName"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                            required=""
                        />
                    </div>
                    <div>
                        <label
                            for="lastName"
                            class="mb-2 block text-sm font-medium text-gray-900"
                            >Last name</label
                        >
                        <input
                            type="text"
                            name="lastName"
                            id="lastName"
                            v-model="modalData.form.lastName"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                            required=""
                        />
                    </div>
                </div>
                <div class="mt-3">
                    <label
                        for="email"
                        class="mb-2 block text-sm font-medium text-gray-900"
                        >Email</label
                    >
                    <input
                        type="email"
                        name="email"
                        id="email"
                        v-model="modalData.form.email"
                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                        placeholder="name@company.com"
                        required=""
                    />
                </div>
                <div class="mt-3 grid gap-3 lg:grid-cols-2">
                    <div>
                        <label
                            for="password"
                            class="mb-2 block text-sm font-medium text-gray-900"
                            >Password</label
                        >
                        <input
                            type="password"
                            name="password"
                            id="password"
                            v-model="modalData.form.password"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                            required=""
                        />
                    </div>
                    <div>
                        <label
                            for="password_confirm"
                            class="mb-2 block text-sm font-medium text-gray-900"
                            >Confirm Password</label
                        >
                        <input
                            type="password"
                            name="password_confirm"
                            v-model="modalData.form.password_confirm"
                            id="password_confirm"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                            required=""
                        />
                    </div>
                </div>
            </div>
        </template>
        <template v-slot:buttons>
            <button
                type="button"
                class="btn-create"
                @click="$emit('confirmEdit')"
            >
                Edit user
            </button>
            <button
                type="button"
                class="btn-standard"
                @click="
                    () => {
                        modalData.close();
                    }
                "
                ref="cancelButtonRef"
            >
                Cancel
            </button>
        </template>
    </modal>
</template>

<script>
export default {
    props: ["modalData"],
    emits: ["confirmEdit"],
    data() {
        return {};
    },
    mounted() {},
    computed: {},
    watch: {},
    methods: {},
};
</script>
