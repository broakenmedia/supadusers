<template>
    <div class="mx-auto max-w-3xl">
        <h1 class="mb-3">Users</h1>
        <div class="flex items-center justify-end">
            <button
                class="mb-3 flex items-center justify-center rounded-full bg-blue-600 px-4 py-2 align-middle text-sm text-white"
                @click="createModal.open"
            >
                Add user
            </button>
        </div>
        <div class="flex flex-col">
            <div class="overflow-x-auto shadow-md sm:rounded-lg">
                <div class="inline-block min-w-full align-middle">
                    <div class="overflow-hidden">
                        <table
                            class="min-w-full table-auto divide-y divide-gray-200"
                        >
                            <thead class="bg-gray-100">
                                <tr>
                                    <th scope="col" class="t-head">ID</th>
                                    <th scope="col" class="t-head">Name</th>
                                    <th scope="col" class="t-head">Email</th>
                                    <th scope="col" class="p-4">
                                        <span class="sr-only">Edit</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                <tr
                                    class="hover:bg-gray-100"
                                    v-if="users.length <= 0 && isSuccess"
                                >
                                    <td colspan="4" class="t-body">
                                        <svg
                                            class="mx-auto h-5 w-5 animate-spin text-black"
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                        >
                                            <circle
                                                class="opacity-25"
                                                cx="12"
                                                cy="12"
                                                r="10"
                                                stroke="currentColor"
                                                stroke-width="4"
                                            ></circle>
                                            <path
                                                class="opacity-75"
                                                fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                            ></path>
                                        </svg>
                                    </td>
                                </tr>

                                <tr
                                    class="hover:bg-gray-100"
                                    v-for="user in users"
                                >
                                    <td class="t-body">{{ user.id }}</td>
                                    <td class="t-body">
                                        {{ user.firstName }} {{ user.lastName }}
                                    </td>
                                    <td
                                        class="whitespace-nowrap py-4 px-6 text-sm font-medium text-gray-500"
                                    >
                                        {{ user.email }}
                                    </td>
                                    <td
                                        class="flex justify-end gap-4 whitespace-nowrap py-4 px-6 text-right text-sm font-medium"
                                    >
                                        <a
                                            @click.prevent="
                                                () => {
                                                    editModal.open(user);
                                                }
                                            "
                                            class="cursor-pointer text-blue-600 hover:underline"
                                            >Edit</a
                                        >
                                        <a
                                            @click.prevent="
                                                () => {
                                                    onDeleteClicked(user);
                                                }
                                            "
                                            class="cursor-pointer text-red-600 hover:underline"
                                            >Delete</a
                                        >
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="nav mt-3 flex items-center justify-between">
            <button
                @click="prevClick"
                :class="{ invisible: pageNo === 1 }"
                class="text-base font-bold uppercase"
            >
                Prev
            </button>
            <div>
                <p class="text-xs text-gray-500">
                    Page {{ pageNo }} of {{ lastPage }}
                </p>
            </div>
            <button
                @click="nextClick"
                :class="{ invisible: pageNo === lastPage }"
                class="text-base font-bold uppercase"
            >
                Next
            </button>
        </div>
        <div
            class="mt-3 w-full rounded-md border-2 border-red-500 bg-red-400 px-4 py-2 text-base font-semibold"
            v-show="!isSuccess"
            v-cloak
        >
            <div class="prose text-white">{{ errorMessage }}</div>
        </div>

        <add-user-modal
            :modal-data="createModal"
            @confirm-add="createUser"
        ></add-user-modal>

        <edit-user-modal
            :modal-data="editModal"
            @confirm-edit="editUser"
        ></edit-user-modal>

        <modal :open="deleteModal.open" @closed="deleteModal.open = false">
            <template v-slot:title> Are you sure? </template>
            <template v-slot:body>
                Please confirm that you'd like to delete this user. It cannot be
                undone.
            </template>
            <template v-slot:buttons>
                <button
                    type="button"
                    class="btn-delete"
                    @click="
                        () => {
                            confirmDelete(deleteModal.userId);
                        }
                    "
                >
                    Delete
                </button>
                <button
                    type="button"
                    class="btn-standard"
                    @click="deleteModal.open = false"
                    ref="cancelButtonRef"
                >
                    Cancel
                </button>
            </template>
        </modal>
    </div>
</template>

<script>
export default {
    data() {
        return {
            responseObject: null,
            isLoading: true,
            users: [],
            pageNo: 1,
            deleteModal: {
                userId: null,
                open: false,
            },
            createModal: {
                isOpen: false,
                form: {
                    firstName: null,
                    lastName: null,
                    email: null,
                    password: null,
                    password_confirm: null,
                },
                errors: null,
                open: function (user) {
                    this.isOpen = true;
                },
                close: function () {
                    this.errors = null;
                    this.isOpen = false;
                    let reset = () => {
                        this.resetForm();
                    };
                    reset();
                },
                resetForm: function () {
                    this.form.firstName = null;
                    this.form.lastName = null;
                    this.form.email = null;
                    this.form.password = null;
                    this.form.password_confirm = null;
                },
            },
            editModal: {
                user: null,
                isOpen: false,
                form: {
                    firstName: null,
                    lastName: null,
                    email: null,
                    password: null,
                    password_confirm: null,
                },
                errors: null,
                open: function (user) {
                    this.isOpen = true;
                    this.user = user;
                },
                close: function () {
                    this.errors = null;
                    this.user = null;
                    this.isOpen = false;
                    let reset = () => {
                        this.resetForm();
                    };
                    reset();
                },
                resetForm: function () {
                    this.form.firstName = null;
                    this.form.lastName = null;
                    this.form.email = null;
                    this.form.password = null;
                    this.form.password_confirm = null;
                },
            },
        };
    },
    mounted() {
        this.load();
    },
    computed: {
        isSuccess() {
            return this.responseObject ? this.responseObject.success : true;
        },
        errorMessage() {
            return this.responseObject ? this.responseObject.message : "";
        },
        lastPage() {
            return this.responseObject ? this.responseObject.data.last_page : 1;
        },
    },
    watch: {
        lastPage(newVal, oldVal) {
            if (this.pageNo > newVal) {
                this.pageNo = newVal;
            }
        },
        pageNo(newPage, oldPage) {
            this.load();
        },
    },
    methods: {
        async load() {
            this.isLoading = true;
            let response = await fetch(
                route("users.index") + "?page=" + this.pageNo
            );
            this.responseObject = await response.json();
            if (this.responseObject.success) {
                this.users = this.responseObject.data.data;
            }
        },
        prevClick() {
            this.pageNo = Math.max(1, this.pageNo - 1);
            this.load();
        },
        nextClick() {
            this.pageNo = Math.min(this.lastPage, this.pageNo + 1);
            this.load();
        },
        onDeleteClicked(row) {
            this.deleteModal.open = true;
            this.deleteModal.userId = row.id;
        },
        async editUser() {
            this.editModal.errors = null;
            var form_data = new FormData();
            for (var key in this.editModal.form) {
                if (this.editModal.form[key]) {
                    form_data.append(key, this.editModal.form[key]);
                }
            }
            let response = await fetch(
                route("users.update", { userId: this.editModal.user.id }),
                {
                    method: "POST",
                    body: form_data,
                }
            );
            let responseObject = await response.json();
            if (responseObject.success) {
                this.editModal.close();
                this.load();
            } else {
                this.editModal.errors = responseObject.errors;
            }
        },
        async createUser() {
            this.createModal.errors = null;
            var form_data = new FormData();
            for (var key in this.createModal.form) {
                if (this.createModal.form[key]) {
                    form_data.append(key, this.createModal.form[key]);
                }
            }
            let response = await fetch(route("users.store"), {
                method: "POST",
                body: form_data,
            });
            let responseObject = await response.json();
            if (responseObject.success) {
                this.createModal.close();
                this.load();
            } else {
                this.createModal.errors = responseObject.errors;
            }
        },
        async confirmDelete(userId) {
            let response = await fetch(
                route("users.destroy", { userId: userId }),
                { method: "DELETE" }
            );
            let responseObject = await response.json();
            if (responseObject.success) {
                this.deleteModal.open = false;
                this.load();
            }
        },
    },
};
</script>
