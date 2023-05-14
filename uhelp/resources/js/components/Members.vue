<template>
    <UserLayout :user="user" :active="'fundraising'">
        <div class="center-position">
            <div class="page-title-text">Members</div>
            <div class="fundraising">
                <DataTable
                    :value="members"
                    paginator
                    :rows="10"
                    :rowsPerPageOptions="[5, 10, 20, 50]"
                    paginatorTemplate="FirstPageLink PrevPageLink CurrentPageReport NextPageLink LastPageLink"
                    tableStyle="min-width: 102rem"
                >
                    <Column field="name" header="Name"></Column>
                    <Column field="email" header="Email"></Column>
                    <Column field="account_type_id" header="Account type"></Column>
                    <Column field="phone" header="Phone number"></Column>
                    <Column field="approved" header="Approved">
                        <template #body="{data}">
                            <p :class="data.approved ? 'green-bacgr' : 'red-bacgr'">{{ data.approved === 1 ? "Watched" : "To watch" }}</p>
                        </template>
                    </Column>
                    <Column field="id"  style="width: 15%">
                        <template #body="{data}" class="justify-content-space-between">
                            <Button v-if="!data.approved" severity="secondary" @click="toogle(data)">Check</Button>
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
