<template>
    <UserLayout :user="user" :active="'announcements'">
        <div class="center-position">
            <div class="page-title-text">Announcements</div>
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
                        <button class="slide-button large-margin" @click="toogle(item.id)">Help</button>
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
    name: "Announcements",

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
            window.location.href = '/details-announcement/' + id;
        }
    }
}
</script>
