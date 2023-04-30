<template>
    <div class="fundraisings">
        <vueper-slides
            class="no-shadow"
            :visible-slides="3"
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
                            <img src="../../img/fundraising.png">
                        </div>
                        <div class="vueperslide__title slide-title-text">{{ slide.title }}</div>
                        <div class="slide-text">{{ slide.content }}</div>
                        <button class="slide-button">Help</button>
                    </div>
                </template>
            </vueper-slide>
        </vueper-slides>
    </div>
</template>

<script>
import { VueperSlides, VueperSlide } from 'vueperslides';
import 'vueperslides/dist/vueperslides.css';

export default {
    name: "Slider",

    components: {
        VueperSlides,
        VueperSlide,
    },

    data: () => ({
        slides: [
            {
                title: 'Drones for the military',
                content: 'We need to raise funds for drones for the 1st unit. ' +
                    'Join the fundraiser and help our boys better understand the situation at the front.'
            },
            {
                title: 'Drones for the military',
                content: 'We need to raise funds for drones for the 1st unit. ' +
                    'Join the fundraiser and help our boys better understand the situation at the front.'
            },
            {
                title: 'Drones for the military',
                content: 'We need to raise funds for drones for the 1st unit. ' +
                    'Join the fundraiser and help our boys better understand the situation at the front.'
            },
            {
                title: 'Drones for the military',
                content: 'We need to raise funds for drones for the 1st unit. ' +
                    'Join the fundraiser and help our boys better understand the situation at the front.'
            }
        ]
    })
}
</script>
