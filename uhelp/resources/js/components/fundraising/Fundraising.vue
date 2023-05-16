<template>
    <UserLayout :user="user" :active="'fundraising'">
        <div class="center-position">
            <div class="page-title-text">Збори коштів</div>
            <GridLayout
                v-model:layout="layout"
                :col-num="3"
                :row-height="450"
                :margin="[70, 70]"
                :use-css-transforms="false"
                :useStyleCursor="false"
                vertical-compact
            >
                <GridItem
                    v-for="item in layout"
                    :key="item.i"
                    :x="item.x"
                    :y="item.y"
                    :w="item.w"
                    :h="item.h"
                    :i="item.i"
                    :is-draggable="false"
                    :is-resizable="false"
                    class="slot-style"
                >
                    <div class="slot-configuration">
                        <div class="slot-title-text">{{ item.title }}</div>
                        <div class="slot-text">{{ item.shortInfo }}</div>
                        <div class="slot-goal-text">Наша ціль: {{ item.sum }} UAH</div>
                        <button @click="toogle(item.id)" class="slide-button large-margin">Деталі</button>
                    </div>
                </GridItem>
            </GridLayout>
        </div>
    </UserLayout>
</template>

<script>
import UserLayout from "../UserLayout.vue";
import { GridLayout, GridItem } from 'grid-layout-plus';

export default {
    name: "Fundraising",

    components: {
        UserLayout,
        GridLayout,
        GridItem
    },

    props: {
        user: [Object, null],
        layout: [],
    },

    data() {
        return {
            width: 1,
            height: 1,
        }
    },

    methods: {
        toogle(id) {
            window.location.href = '/details-fundraising/' + id;
        }
    }
}
</script>
