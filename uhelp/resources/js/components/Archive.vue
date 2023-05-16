<template>
    <UserLayout :user="user" :active="'archive'">
        <div class="center-position">
            <div class="page-title-text">Архів зборів</div>
            <div class="fundraising padding-top-button">
                <DataTable
                    :value="fundraising"
                    paginator
                    :rows="10"
                    :rowsPerPageOptions="[5, 10, 20, 50]"
                    paginatorTemplate="FirstPageLink PrevPageLink CurrentPageReport NextPageLink LastPageLink"
                    tableStyle="min-width: 102rem"
                >
                    <Column field="title" header="Назва"></Column>
                    <Column field="short_info" header="Коротка інформація"></Column>
                    <Column field="cause" header="Причина закриття"></Column>
                    <Column field="id" style="width: 10%">
                        <template #body="{data}">
                            <Button severity="secondary" @click="toogle(data)">Деталі</Button>
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
    name: "Archive",

    components: {
        UserLayout,
        DataTable,
        Column,
        Button
    },

    props: {
        user: [Object, null],
        fundraising: Array,
    },

    methods: {
        toogle(data) {
            window.location.href = '/details-fundraising/' + data.id;
        },
    }
}
</script>
