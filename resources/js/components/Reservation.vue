<template>
    <div>
        <h2>Reservations</h2>
        <div class="row">
            <form @submit.prevent="addReservation" class="col-6">
                <div class="form-group">
                    <label>Date de reservation</label>
                    <input type="date" class="form-control" placeholder="Entrer la date" v-model="reservation.date">
                </div>
                <div class="form-group">
                    <label>Numero de reservation</label>
                    <input type="text" class="form-control" readonly v-model="reservation.numero">
                </div>
                <div class="form-group">
                    <label>Numero du Vol</label>
                    <input type="text" class="form-control" readonly placeholder="Veuillez choisir un vol à droit" v-model="reservation.vol_id">
                </div>
                <button type="submit" class="btn btn-light btn-block">Enregistrer</button>
            </form>
            <div class="card card-body col-6 text-center" > 
                <div class="row">
                    <div class="col-6" v-for="vol in vols" v-bind:key="vol.id">
                        <button @click="chooseVol(vol.id)" class="mb-2 btn btn-primary">Départ le: {{ vol.dateDepart }} <br>  A {{ vol.heureDepart }} </button>
                    </div>
                </div>
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item">
                            <a href="#" class="page-link" @click="fetchVols(pagination.prev_page_url)">Previous</a>
                        </li>
                        <li class="page-item disabled">
                            <a href="#" class="page-link text-dark"> Page {{ pagination.current_page }} of {{ pagination.last_page }} </a>
                        </li>
                        <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item">
                            <a href="#" class="page-link" @click="fetchVols(pagination.next_page_url)">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
         <div class="row">
             <div class="card card-body col-6 text-center mb-2" v-for="reservation in reservations" v-bind:key="reservation.id">
                <p> Réservé le <strong>{{ reservation.date }}</strong> </p>
                <p>Numero de la réservation <strong>{{ reservation.numero }}</strong></p>
                <p>Numero du vol <strong>{{ reservation.vol_id }} </strong> </p>
                <hr>
                <button @click="editReservation(reservation)" class="btn btn-warning gradient-button-1 mb-2">Modifier</button>
                <button @click="deleteReservation(reservation.id)" class="btn btn-danger gradient-button-2">Supprimer</button>
            </div>
         </div>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item">
                    <a href="#" class="page-link" @click="fetchReservations(pagination.prev_page_url)">Previous</a>
                </li>
                <li class="page-item disabled">
                    <a href="#" class="page-link text-dark"> Page {{ pagination.current_page }} of {{ pagination.last_page }} </a>
                </li>
                <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item">
                    <a href="#" class="page-link" @click="fetchReservations(pagination.next_page_url)">Next</a>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                reservations: [],
                vols: [],
                reservation: {
                    id: '',
                    date: '',
                    numero: new Date().getFullYear() + '-' + new Date().getMonth() + '-' + new Date().getDate() + '-' + new Date().getDay() + '-' + new Date().getHours() + '-' + new Date().getMinutes() + '-' + new Date().getSeconds(),
                    vol_id: '',
                }, 
                reservation_id: '',
                pagination: {},
                edit: false
            }
        },

        created(){
            this.fetchReservations(),
            this.fetchVols()
        },

        methods: {
            fetchVols(page_url){
                let vm = this
                page_url = page_url || '/api/vols'
                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        this.vols = res.data
                        vm.makePagination(res.meta, res.links)
                    })
                    .catch(err => console.log(err))
            },
            makePagination(meta, links){
                let pagination = {
                    current_page: meta.current_page,
                    last_page: meta.last_page,
                    next_page_url: links.next,
                    prev_page_url: links.prev
                }
                this.pagination = pagination
            },
            fetchReservations(page_url){
                let vm = this
                page_url = page_url || '/api/reservations'
                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        this.reservations = res.data
                        vm.makePagination(res.meta, res.links)
                    })
                    .catch(err => console.log(err))
            },
            makePagination(meta, links){
                let pagination = {
                    current_page: meta.current_page,
                    last_page: meta.last_page,
                    next_page_url: links.next,
                    prev_page_url: links.prev
                }
                this.pagination = pagination
            },

            deleteReservation(id){
                if(confirm('Etes vous sur ?')){
                    fetch(`api/reservation/${id}`, {
                        method: 'delete'
                    })
                    .then(res => res.json())
                    .then(data => {
                        alert('reservation Supprimé')
                        this.fetchReservations()
                    })
                    .catch(err => console.log(err))
                }
            },

            addReservation(){
                if(this.edit === false){
                    //ajouter
                    fetch('api/reservation', {
                        method: 'post',
                        body: JSON.stringify(this.reservation),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.reservation.date = '',
                        this.reservation.numero = '',
                        this.reservation.vol_id = '',
                        alert('Ajouter ajouté')
                        this.fetchReservations()
                    })
                    .catch(err => console.log(err))
                }else{
                    //update
                    fetch('api/reservation', {
                        method: 'put',
                        body: JSON.stringify(this.reservation),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.reservation.date = '',
                        this.reservation.numero = '',
                        this.reservation.vol_id = '',
                        alert('Reservation Modifier')
                        this.fetchReservations()
                    })
                    .catch(err => console.log(err))
                }
            },

            editReservation(reservation){
                this.edit = true
                this.reservation.id = reservation.id
                this.reservation.reservation_id = reservation.id
                this.reservation.date = reservation.date
                this.reservation.numero = reservation.numero
                this.reservation.vol_id = reservation.vol_id
            },
            chooseVol(id){
                this.reservation.vol_id = id
            }
        }
    }
</script>
