<template>
    <UserLayout :user="user" :active="'announcements'">
        <div class="start">
            <div class="page-title-text">Announcement Details</div>
            <div class="flex">
                <div class="width-slider fundr-info">
                    <Carousel :value="images" :numVisible="1" :numScroll="1">
                        <template #item="slotProps">
                            <img :src="slotProps.data.url" style="width: 500px">
                        </template>
                    </Carousel>
                </div>
                <div class="fundr-info">
                    <div class="label-text padding-small">{{ announcement[0]['title'] }}</div>
                    <div class="slot-text padding-small">{{ announcement[0]['info'] }}</div>
                    <div class="label-text padding-small">Victim information to contact:</div>
                    <div class="italic-text padding-small">Name: {{ user['name'] }}</div>
                    <div class="italic-text padding-small">Phone: {{ announcement[0]['phone_number'] }}</div>
                    <div class="italic-text padding-small">Card number: {{ announcement[0]['card_number'] }}</div>
                </div>
            </div>
            <div class="flex">
                <div class="donate fundr-info">
                </div>
            </div>
        </div>
    </UserLayout>
</template>

<script>
import UserLayout from "../UserLayout.vue";
import Carousel from "primevue/carousel";
import ProgressBar from "primevue/progressbar";

export default {
    name: "AnnouncementDetails",

    components: {
        UserLayout,
        Carousel,
        ProgressBar,
    },

    props: {
        user: [Object, null],
        announcement: Array,
        images: Array,
    },

    methods: {
    }
}
</script>
