<template>
    <UserLayout :user="user" :active="'fundraising'">
        <div class="start">
            <div class="page-title-text">Деталі збору</div>
            <div class="flex">
                <div class="width-slider fundr-info">
                    <Carousel :value="images" :numVisible="1" :numScroll="1">
                        <template #item="slotProps">
                            <img :src="slotProps.data.url" style="width: 500px">
                        </template>
                    </Carousel>
                </div>
                <div class="fundr-info">
                    <div class="label-text padding-small">{{ fundraising[0]['title'] }}</div>
                    <div class="slot-text padding-small">{{ fundraising[0]['info'] }}</div>
                    <div class="italic-text padding-small">Дата початку: {{ fundraising[0]['start_date'] }}</div>
                    <div class="slot-goal-text padding-small">Сума збору: {{ fundraising[0]['sum'] }} UAH</div>
                    <div class="slot-goal-text padding-small">Залишилося зібрати: {{ fundraising[0]['remaining_amount'] }} UAH</div>
                    <div class="slot-text padding-small">
                        Статус збору:
                        <ProgressBar :value="(fundraising[0]['sum'] - fundraising[0]['remaining_amount']) / fundraising[0]['sum'] * 100"></ProgressBar>
                    </div>
                </div>
            </div>
            <div class="flex">
                <div v-if="fundraising[0]['is_active']" class="padding-small donate fundr-info">
                    <div class="label-text padding-small">Ви можете доєднатись та задонатити тут:</div>
                    <a class="donate-button button right-align" :href="fundraising[0]['link']">Донат!</a>
                </div>
                <div v-else class="padding-small donate fundr-info">
                    <div class="italic-text red padding-small">Цей збір був закритий</div>
                    <div class="label-text padding-small">Причина: {{ fundraising[0]['cause'] }}</div>
                </div>
                <div class="donate fundr-info">
                    <div class="label-text padding-small">Волонтер, відповідальний за збір:</div>
                    <div class="italic-text padding-small">Ім'я: {{ volunteer['name'] }}</div>
                    <div class="italic-text padding-small">Номер телефону: {{ volunteer['phone'] }}</div>
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
    name: "FundraisingDetails",

    components: {
        UserLayout,
        Carousel,
        ProgressBar,
    },

    props: {
        user: [Object, null],
        fundraising: Array,
        images: Array,
        volunteer: Object
    },

    methods: {
    }
}
</script>
