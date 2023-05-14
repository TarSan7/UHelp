<template>
    <UserLayout :user="user" :active="'fundraising'">
        <div class="center-position">
            <div class="page-title-text">My Fundraising</div>
            <div class="fundraising">
                <div class="padding-top-button">
                    <Button severity="secondary" @click="toogleAdd">Add new</Button>
                </div>

                <DataTable
                    :value="fundraising"
                    paginator
                    :rows="10"
                    :rowsPerPageOptions="[5, 10, 20, 50]"
                    paginatorTemplate="FirstPageLink PrevPageLink CurrentPageReport NextPageLink LastPageLink"
                    tableStyle="min-width: 102rem"
                >
                    <Column field="title" header="Title"></Column>
                    <Column field="short_info" header="Short information"></Column>
                    <Column field="start_date" header="Start date"></Column>
                    <Column field="sum" header="Sum"></Column>
                    <Column field="id"  style="width: 15%">
                        <template #body="{data}">
                            <Button v-if="data.is_active" severity="secondary" @click="toogle(data)">Edit</Button>
                            <Button v-if="data.is_active" severity="secondary" @click="close(data)">Close</Button>
                            <Button v-else severity="secondary" disabled>Closed</Button>
                        </template>
                    </Column>
                </DataTable>
            </div>
        </div>
    </UserLayout>
</template>

<script>
import UserLayout from "../UserLayout.vue";
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Button from 'primevue/button';

export default {
    name: "MyFundraising",

    components: {
        UserLayout,
        DataTable,
        Column,
        Button
    },

    props: {
        user: [Object, null],
        fundraising: [],
    },

    methods: {
        toogle(data) {
            window.location.href = '/edit-fundraising/' + data.id;
        },

        close(data) {
            window.location.href = '/close-fundraising/' + data.id;
        },

        toogleAdd() {
            window.location.href = '/add-fundraising';
        }
    }
}
</script>
