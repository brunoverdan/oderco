<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Oderço - Cotação de Frete | Bruno Verdan</div>

                    <div class="card-body">


                    </div>

                    <div class="container">
                        <ul>
                            <li v-for="(erro, index) of errors" :key="index">
                                campo <b>{{ erro.field }}</b> - {{ erro.message}}

                            </li>
                        </ul>
                    <!-- Inicio -->
                    <div class="row mb-2">
                        <div class="col-md-6">

                        <label><b>Cadastro Cotação de Frete</b></label>
                        <p></p>
                        <p></p>
                        <p></p>


                        <form @submit.prevent="salvar">

                            <label>Transportadora</label>
                            <select v-model="cotacao.transportadora_id" class="form-control" placeholder="Transportadora">

                                <option v-for="transportadora in transportadoras" :key="transportadora.id">{{ transportadora.id }}</option>

                            </select>
                            <label>UF</label>
                            <select v-model="cotacao.uf" class="form-control" placeholder="UF">
                                <option v-for="uf in ufs" :key="uf">{{ uf }}</option>

                            </select><br />
                             <label>Porcentagem cotação %</label>
                            <p><input type="text" v-model="cotacao.porcentual_cotacao" class="form-control"></p>
                            <label>Valor extra (R$)</label>
                            <p><input type="text" v-model="cotacao.valor_extra" class="form-control"><br /></p>

                            <p><button>Salvar</button></p>
                        </form>


                        </div>
                        <div class="col-md-6">

                            <form @submit.prevent="RankCalculo">

                            <label><b>Cotar Frete</b></label>
                            <p></p>
                            <p></p>
                            <p></p>

                            <label>UF</label>
                            <select v-model="calculo.uf" class="form-control">
                                <option v-for="uf in ufs" :key="uf">{{ uf }}</option>

                            </select><br />
                            <label>Porcentagem Cotação (%)</label>
                            <input type="text" placeholder="valor_pedido" v-model.number="calculo.valor_pedido" class="form-control">
                            <p></p>
                            <p></p>
                            <p><button>cotar</button></p>

                            </form>

                            <label>Melhores Resultados</label>

                            <table class="table">
                                <thead class="thead-light">
                                    <tr>
                                    <th scope="col">Rank</th>
                                    <th scope="col">Trasportadora</th>
                                    <th scope="col">Valor Cotação</th>
                                    </tr>
                                </thead>
                            <tbody>

                        <tr v-for="calc of calcular" :key="calc.id">
                            <th>Rank</th>
                            <th>{{ calc.transportadora_id}}</th>
                            <th>{{ calc.valor_cotacao}}</th>
                        </tr>

                </tbody>
                </table>


                        </div>
                    </div>

                    <!-- FIM --->

                    <h3><b>Relatorio</b></h3>
                    <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">UF</th>
                            <th scope="col">Percentual Frete</th>
                            <th scope="col">Valores Taxa</th>
                            <th scope="col">Trasportadora</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr v-for="cotacao of cotacoes" :key="cotacao.id" style="position:text-align:center;">
                            <td >{{ cotacao.id }}</td>
                            <td>{{ cotacao.uf }}</td>
                            <td>{{ cotacao.porcentual_cotacao }} %</td>
                            <td>R$ {{ formatPrice(cotacao.valor_extra) }}</td>
                            <td>{{ cotacao.transportadora_id }}</td>
                        </tr>


                </tbody>
                </table>
                    </div>


                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import Cotacao from '../services/cotacao.js'
    export default {

        data(){
            return{
                cotacao:{
                    id: '',
                    uf: '',
                    porcentual_cotacao: '',
                    valor_extra: '',
                    transportadora_id: ''

                },
                cotacoes:[],
                errors:[],
                ufs:['PR', 'SP' , 'MG', 'SC','GO', 'RJ' , 'BA', 'TO'],
                transportadora:{
                    id:'',
                    nome:''
                },
                transportadoras:[],
                calculo:{
                    uf: '',
                    transportadora_id: '',
                    valor_pedido: '',
                    valor_cotacao: ''
                },
                calcular:[]
            }
        },


        mounted() {
            this.listar(),
            this.listarTransportadora()
        },

        methods:{

            listar(){
                Cotacao.listar().then(resposta => {
                this.cotacoes = resposta.data
                })
            },

            listarTransportadora(){
                Cotacao.listarTransportadora().then(resposta => {
                this.transportadoras = resposta.data
                })
            },

            listarCalculo(){

                Cotacao.listarCalculo().then(resposta => {

                this.calcular = resposta.data

                })
            },

            RankCalculo(){

                if(!this.calculo.uf){


                    alert("nao tem uf")

                }else{

                    Cotacao.Calcular(this.calculo).then(resposta => {
                        this.calculo = {}
                        //alert(this.calculo)
                        this.listarCalculo()
                        this.listar()
                        this.errors = []
                    })

                }


                //this.listarCalculo()
            },

            salvar(){

                if(!this.cotacao.id){

                     Cotacao.salvar(this.cotacao).then(resposta => {
                        this.cotacao = {}
                        alert("Salvo com Sucesso")
                        this.listar()
                        this.errors = []
                    }).catch(e => {
                        this.errors = e.response.data.errors
                    })

                }else{
                    Cotacao.atualizar(this.cotacao).then(resposta => {
                        this.cotacao = {}
                        alert("Atualizado com Sucesso")
                        this.listar()
                        this.errors = []
                    }).catch(e => {
                        this.errors = e.response.data.errors
                    })

                }


            },

            formatPrice(value) {
                let val = (value/1).toFixed(2).replace('.', ',')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            }


        }

    }

</script>

<style>

</style>
