import Vue from 'vue';
import VueRouter from 'vue-router';
import Vols from './components/Vols';
import Reservation from './components/Reservation';
import Vol from './components/Vol';


Vue.use(VueRouter);

export default new VueRouter({
    routes: [
        { path: '/', component: Vols, name: 'vols'},
        { path: '/reservations', component: Reservation, name: 'reservations'},
        { path: '/vol/:id(\\d+)', component: Vol, name: 'vol'}
    ],
    mode: 'history'
});