<template>
    <UserLayout :user="user" :active="'announcements'">
        <div class="center-position">
            <div class="page-title-text">My Announcements</div>
            <div class="fundraising">
                <div class="padding-top-button">
                    <Button severity="secondary" @click="toogleAdd">Add new</Button>
                </div>

                <DataTable
                    :value="announcements"
                    paginator
                    :rows="10"
                    :rowsPerPageOptions="[5, 10, 20, 50]"
                    paginatorTemplate="FirstPageLink PrevPageLink CurrentPageReport NextPageLink LastPageLink"
                    tableStyle="min-width: 102rem"
                >
                    <Column field="title" header="Title"></Column>
                    <Column field="short_info" header="Short information"></Column>
                    <Column field="card_number" header="Card number"></Column>
                    <Column field="phone_number" header="Phone number"></Column>
                    <Column field="id"  style="width: 15%">
                        <template #body="{data}" class="justify-content-space-between">
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
    name: "MyAnnouncements",

    components: {
        UserLayout,
        DataTable,
        Column,
        Button
    },

    props: {
        user: [Object, null],
        announcements: [],
    },

    methods: {
        toogle(data) {
            window.location.href = '/edit-announcement/' + data.id;
        },

        close(data) {
            window.location.href = '/close-announcement/' + data.id;
        },

        toogleAdd() {
            window.location.href = '/add-announcement';
        }
    }
}
</script>
