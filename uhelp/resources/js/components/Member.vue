<template>
    <UserLayout :user="user" :active="'fundraising'">
        <div class="center-position">
            <div class="page-title-text">Member documents</div>
            <div class="center layout">
                <img :src="member.document">
                <div class="button-layout">
                    <Button severity="success" @click="approve">Approve</Button>
                    <Button severity="danger" @click="reject">Reject</Button>
                </div>
            </div>
        </div>
    </UserLayout>
</template>

<script>
import UserLayout from "./UserLayout.vue";
import DataTable from 'primevue/datatable';
import Button from 'primevue/button';

export default {
    name: "Member",

    components: {
        UserLayout,
        DataTable,
        Button
    },

    props: {
        user: [Object, null],
        member: [],
    },

    methods: {
        approve() {
            window.location.href = '/approve/' + this.member.user_id;
        },

        reject() {
            window.location.href = '/reject/' + this.member.user_id;
        },
    }
}
</script>
