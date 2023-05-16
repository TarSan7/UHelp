<template>
    <div class="container">
        <div class="screen-wraper">
            <img class="img1" src="../../img/landing-first-screen.png">

            <div class="screen">

                <div id="sidemenu">
                    <button class="sidemenu__btn" v-on:click="navOpen=!navOpen" v-bind:class="{active:navOpen}">
                        <span class="top"></span>
                        <span class="mid"></span>
                        <span class="bottom"></span>
                    </button>
                    <transition name="translateX">
                        <nav v-show="navOpen">
                            <div class="sidemenu__wrapper">
                                <ul class="sidemenu__list">
                                    <li class="sidemenu__item"><a href="/login">Логін</a></li>
                                    <li class="sidemenu__item"><a href="/fundraising">Збори коштів</a></li>
                                    <li class="sidemenu__item"><a href="/map">Мапа центрів донації</a></li>
                                    <li class="sidemenu__item"><a href="/announcements">Допомога постраждалим</a></li>
                                </ul>
                            </div>
                        </nav>
                    </transition>
                </div>

                <div class="first-screen-block">
                    <div class="large-text text-right">Допоможи собі та всім<br>хто цього потребує</div>
                    <div class="small-text text-right">Якщо ви потребуєте допомоги або хочете допомогти<br>постраждалим або ЗСУ,<br>
                        волонтерська платформа надасть вам таку <br>можливість.
                    </div>
                    <button class="second-button button right-align" @click="redirect">Допомогти!</button>
                </div>
            </div>
        </div>
        <div class="screen yellow-background">
            <div class="second-screen-block">
                <div class="large-text text-left">Зроби донат щоб<br>покрити найкритичніші<br>потреби</div>
                <div class="small-text text-left small-margin-top">
                    Зараз, під час війни, відкриваються волонтерські проекти з
                    метою допомоги як військовим на передовій, так і мирним українцям
                    які перебувають у скрутному становищі через війну.
                </div>
                <button class="main-button button right-align" @click="redirect">Перейти до проектів</button>
            </div>
            <div class="img2">
                <img class="img-height" src="../../img/landing-second-screen.png">
            </div>
        </div>
        <div class="service-screen">
            <div class="left-groups">
                <div class="group group1-img small-text">
                    Колекції зборів кошт <br>для потреб<br> армії
                </div>
                <div class="group group2-img small-text">
                    Збори коштів на<br> зброю
                </div>
            </div>
            <div class="all-services">
                <div class="group all-services-img large-text">
                    Можливості
                </div>
            </div>
            <div class="right-groups">
                <div class="group group3-img small-text">
                    Допомога<br> людям дез дому
                </div>
                <div class="group group4-img small-text">
                    Перегляд <br>пунктів донорства<br> крові
                </div>
            </div>
        </div>
        <div class="screen">
            <div class="flows">
                <div class="small-title">Робота платформи</div>
                <div class="very-small-text">Ви можете працювати з платформою під різними обліковими записами.
                    <br><br>
                    Якщо ви волонтер, у вас є можливість зареєструватися та використовувати свій обліковий запис для публікації
                    збирання коштів та відстеження їх, прийом заявок від людей, які потребують допомоги, розміщення пунктів
                    донації на карті.
                    <br><br>
                    Якщо ви людина, яка потрапила в складну ситуацію через напади ворога, то у вас є
                    можливість створити запит на допомогу, який опрацюють волонтери.
                    <br><br>
                    Якщо ви турботлива людина, яка хоче допомогти, ви можете зробити це без створення облікового запису.
                </div>
            </div>
        </div>
        <div class="screen light-yellow-background">
            <div class="fundraising-block">
                <div class="small-title dark-text">Активні збори коштів</div>
                <slider :slides="slides" :visible-slides="3" :width="200" :is-button="true" />
            </div>
        </div>
        <div class="footer">
            <div class="footer-row">
                <div class="footer-title">UHelp</div>
                <div class="footer-links">
                    <div class="very-small-text link-padding">Карта центрів донації</div>
                    <div class="very-small-text link-padding">Збори коштів</div>
                    <div class="very-small-text link-padding">Допомога постраждалим</div>
                </div>
                <div class="socials-footer">
                    <img class="social" src="../../img/insta-logo.svg">
                    <img class="social" src="../../img/facebook-logo.svg">
                    <img class="social" src="../../img/telegram-logo.svg">
                </div>
            </div>
            <div class="rights">All rights are served@ 2023</div>
        </div>
    </div>
</template>

<script>
import Slider from "./Slider.vue";

    export default {
        components: {
            Slider
        },

        props: {
            slides: Array
        },

        data() {
            return {
                navOpen: false,
            }
        },

        methods: {
            redirect() {
                window.location.href = '/fundraising';
            }
        }
    }
</script>
