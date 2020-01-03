<template>
    <div>
        <h2>Vols</h2>
        <form @submit.prevent="addVol" class="mb-4">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Entrer la date de départ" v-model="vol.dateDepart">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Entrer l'heure de départ" v-model="vol.heureDepart">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Entrer la date d'arrivée" v-model="vol.dateArrivee">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Entrer l'heure d'arrivée" v-model="vol.heureArrivee">
            </div>
            <button type="submit" class="btn btn-light btn-block">Enregistrer</button>
        </form>
        <div class="row">
            <div class="card card-body mb-2 col-6 text-center" v-for="vol in vols" v-bind:key="vol.id">
                <router-link class="btn btn-primary" tag="button" :to="{name: 'vol', params: {id:vol.id}}">Details du vol</router-link>
                <p style="font-size:20px">Départ le <strong>{{ vol.dateDepart }}</strong> à <strong>{{ vol.heureDepart }}</strong> </p>
                <p>Arrivée le <strong>{{ vol.dateArrivee }}</strong> à <strong>{{ vol.heureArrivee }}</strong> </p>
                <hr>
                <button @click="editVol(vol)" class="btn btn-warning facebook-style-btn facebook-style-dark mb-2">Modifier</button>
                <button @click="deleteVol(vol.id)" class="btn btn-danger facebook-style-btn facebook-style-light">Supprimer</button>
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
</template>

<script>
export default {
    data(){
        return{
            vols: [],
            vol: {
                id: '',
                dateDepart: '',
                heureDepart: '',
                dateArrivee: '',
                heureArrivee: ''
            }, 
            vol_id: '',
            pagination: {},
            edit: false
        }
    },

    created(){
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
        deleteVol(id){
            if(confirm('Etes vous sur ?')){
                fetch(`api/vol/${id}`, {
                    method: 'delete'
                })
                .then(res => res.json())
                .then(data => {
                    alert('Vol Supprimé')
                    this.fetchVols()
                })
                .catch(err => console.log(err))
            }
        },
        addVol(){
            if(this.edit === false){
                //ajouter
                fetch('api/vol', {
                    method: 'post',
                    body: JSON.stringify(this.vol),
                    headers: {
                        'content-type': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    this.vol.dateDepart = '',
                    this.vol.heureDepart = '',
                    this.vol.dateArrivee = '',
                    this.vol.heureArrivee = ''
                    alert('Vol ajouté')
                    this.fetchVols()
                })
                .catch(err => console.log(err))
            }else{
                //update
                 fetch('api/vol', {
                    method: 'put',
                    body: JSON.stringify(this.vol),
                    headers: {
                        'content-type': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    this.vol.dateDepart = '',
                    this.vol.heureDepart = '',
                    this.vol.dateArrivee = '',
                    this.vol.heureArrivee = ''
                    alert('Vol Modifié')
                    this.fetchVols()
                })
                .catch(err => console.log(err))
            }
        },
        editVol(vol){
            this.edit = true
            this.vol.id = vol.id
            this.vol.vol_id = vol.id
            this.vol.dateDepart = vol.dateDepart
            this.vol.heureDepart = vol.heureDepart
            this.vol.dateArrivee = vol.dateArrivee
            this.vol.heureArrivee = vol.heureArrivee
        }
    }
}
</script>