<template>
    <UserLayout :user="user" :active="'fundraising'">
        <div class="center-position">
            <div class="page-title-text">Користувачі</div>
            <div class="fundraising">
                <DataTable
                    :value="members"
                    paginator
                    :rows="10"
                    :rowsPerPageOptions="[5, 10, 20, 50]"
                    paginatorTemplate="FirstPageLink PrevPageLink CurrentPageReport NextPageLink LastPageLink"
                    tableStyle="min-width: 102rem"
                >
                    <Column field="name" header="Ім'я"></Column>
                    <Column field="email" header="Емейл"></Column>
                    <Column field="account_type_id" header="Тип акаунта"></Column>
                    <Column field="phone" header="Номер телефону"></Column>
                    <Column field="approved" header="Статус акаунта">
                        <template #body="{data}">
                            <p :class="data.approved ? 'green-bacgr' : 'red-bacgr'">{{ data.approved === 1 ? "Переглянуто" : "До перегляду" }}</p>
                        </template>
                    </Column>
                    <Column field="id"  style="width: 15%">
                        <template #body="{data}" class="justify-content-space-between">
                            <Button v-if="!data.approved" severity="secondary" @click="toogle(data)">Перевірити</Button>
                        </template>
                    </Column>
                </DataTable>
            </div>
        </div>
    </UserLayout>
</template>

<script>
import UserLayout from "./UserLayout.vue";
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Button from 'primevue/button';

export default {
    name: "Members",

    components: {
        UserLayout,
        DataTable,
        Column,
        Button
    },

    props: {
        user: [Object, null],
        members: [],
    },

    methods: {
        toogle(data) {
            window.location.href = '/watch-member/' + data.id;
        },
    }
}
</script>
