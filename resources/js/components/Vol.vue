<template>

    <div>
        <div class="text-center">
            <p style="font-size:20px">Départ le <strong>{{ vol.dateDepart }}</strong> à <strong>{{ vol.heureDepart }}</strong> </p>
            <p>Arrivée le <strong>{{ vol.dateArrivee }}</strong> à <strong>{{ vol.heureArrivee }}</strong> </p>
            <br>
            <h3>Réservations sur ce vol</h3>
            <br>
            <div class="row">
                <div class="card card-body mb-2 col-6 text-center" v-for="reservation in reservations" v-bind:key="reservation.id">
                    <p style="font-size:20px">Date de la reservation <strong>{{ reservation.date }}</strong> à <strong>{{ vol.heureDepart }}</strong> </p>
                    <p>Numero de la reservation <strong>{{ reservation.numero }}</strong></p>
                    <p>Numero du vol: <strong> {{ reservation.vol_id }} </strong></p>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
export default {
    data(){
        return{
            vol: {
                id: '',
                dateDepart: '',
                heureDepart: '',
                dateArrivee: '',
                heureArrivee: ''
            },
            reservations: ''
        }
    },

    created(){
        this.fetchVol()
    },

    methods: {
        fetchVol(page_url){
            page_url = page_url || '/api/vol/' + this.$route.params.id
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.vol.id = res.id,
                    this.vol.dateDepart = res.dateDepart,
                    this.vol.heureDepart = res.heureDepart,
                    this.vol.dateArrivee = res.dateArrivee,
                    this.vol.heureArrivee = res.heureArrivee,
                    this.reservations = res.reservations
                })
                .catch(err => console.log(err))
        },
    }
}
</script>