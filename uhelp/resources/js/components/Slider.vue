<template>
    <div class="fundraisings">
        <vueper-slides
            class="no-shadow"
            :visible-slides="visibleSlides"
            slide-multiple
            :gap="3"
            :slide-ratio="1 / 4"
            :dragging-distance="0"
            :breakpoints="{ 700: { visibleSlides: 2, slideMultiple: 2 } }">
            <vueper-slide
                v-for="(slide, i) in slides"
                :key="i"
            >
                <template #content>
                    <div class="vueperslide__content-wrapper">
                        <div class="slide-img">
                            <Image :src="slide.url" :width="width"/>
                        </div>
                        <div v-if="slide.title" class="vueperslide__title slide-title-text">{{ slide.title }}</div>
                        <div v-if="slide.content" class="slide-text">{{ slide.content }}</div>
                        <button v-if="isButton" class="slide-button">Help</button>
                    </div>
                </template>
            </vueper-slide>
        </vueper-slides>
    </div>
</template>

<script>
import { VueperSlides, VueperSlide } from 'vueperslides';
import Image from 'primevue/image';
import 'vueperslides/dist/vueperslides.css';

export default {
    name: "Slider",

    components: {
        VueperSlides,
        VueperSlide,
        Image,
    },

    props: {
        slides: Array,
        isButton: Boolean,
        width: Number,
        visibleSlides: Number,
    },

    data: () => ({
        // slides: [
        //     {
        //         title: 'Drones for the military',
        //         content: 'We need to raise funds for drones for the 1st unit. ' +
        //             'Join the fundraiser and help our boys better understand the situation at the front.'
        //     },
        //     {
        //         title: 'Drones for the military',
        //         content: 'We need to raise funds for drones for the 1st unit. ' +
        //             'Join the fundraiser and help our boys better understand the situation at the front.'
        //     },
        //     {
        //         title: 'Drones for the military',
        //         content: 'We need to raise funds for drones for the 1st unit. ' +
        //             'Join the fundraiser and help our boys better understand the situation at the front.'
        //     },
        //     {
        //         title: 'Drones for the military',
        //         content: 'We need to raise funds for drones for the 1st unit. ' +
        //             'Join the fundraiser and help our boys better understand the situation at the front.'
        //     }
        // ]
    })
}
</script>
