import Vue from 'vue';
import VueRouter from 'vue-router';
import Vols from './components/Vols';
import Reservation from './components/Reservation';


Vue.use(VueRouter);

export default new VueRouter({
    routes: [
        { path: '/', component: Vols},
        { path: '/reservations', component: Reservation}
    ],
    mode: 'history'
});